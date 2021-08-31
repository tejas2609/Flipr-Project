<?php
  require_once "config.php";
  session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLoginFormTeacher'])){
    $teacherName = trim($_POST['teacherName']);
    $teacherEmailReg = trim($_POST['teacherEmailReg']);
    $teachfakepasswordReg = trim($_POST['teachfakepasswordReg']);
    $teachfakepasswordRegRepeat = trim($_POST['teachfakepasswordRegRepeat']);
    $password_hash = password_hash($teachfakepasswordRegRepeat, PASSWORD_BCRYPT);

    if (empty($teacherName)) {
        $errors['teacherName'] = "Name required";
    }
    if (!filter_var($teacherEmailReg, FILTER_VALIDATE_EMAIL)) {
        $errors['teacherEmailReg'] = "Email address is invalid";
    }
    if (empty($teacherEmailReg)) {
        $errors['teacherEmailReg'] = "Email required";
    }
    }
    if (empty($teachfakepasswordReg)) {
        $errors['teachfakepasswordReg'] = "Password required";
    }
    if($teachfakepasswordReg !== $teachfakepasswordRegRepeat) {
        $errors ['teachfakepasswordReg'] = "The two passwords do not match";
    }

    if($query = $db->prepare("SELECT * FROM teacherreg WHERE teacherEmailReg = ?" )){
        $error = '';
        $query->bind_param('s', $teacherEmailReg);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){
            $error = '<p class="error"> Email already exits!</p>';
        }
        else{
            if(strlen($teachfakepasswordReg) < 8){
                $error = '<p class="error"> Length of password must be more than 8!</p>';
            }
        }
        if(empty($error)){
            $insertQuery = $db->prepare("INSERT INTO teacherreg(teacherName, teacherEmailReg, teachfakepasswordReg) VALUES (?,?,?)");
            $insertQuery->bind_param("ssss", $teacherName, $teacherEmailReg, $password_hash);
            $result = $insertQuery->execute();
            if($result){
                $_SESSION['message'] = "You can now SignIn!";
                $_SESSION['alert-class'] = "alert-success";
                header('location:../html/home-after-login.html');
                exit();
            }
            else{
                '<p class="error"> Something went wrong!</p>';
            }
        }
    }
    $query->close();
    $insertQuery->close();
    mysqli_close($db);
  }
?>

