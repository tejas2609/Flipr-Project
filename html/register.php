<?php
session_start();
    $db = mysqli_connect('localhost','root',"",'googleclass');
    if($db->connect_error){
        die("Connection Failed!".$db->connect_error);
    }

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
            $insertQuery->bind_param("sss", $teacherName, $teacherEmailReg, $password_hash);
            $result = $insertQuery->execute();
            if($result){
                $_SESSION['message'] = "You can now SignIn!";
                $_SESSION['alert-class'] = "alert-success";
                header('location:home-after-login.php');
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

<?php
    $db = mysqli_connect('localhost','root',"",'googleclass');
    if($db->connect_error){
        die("Connection Failed!".$db->connect_error);
    }
  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLoginFormStudent'])){
    $studentName = trim($_POST['studentName']);
    $studentEmail = trim($_POST['studentEmail']);
    $studfakepasswordReg = trim($_POST['studfakepasswordReg']);
    $studfakepasswordRegRepeat = trim($_POST['studfakepasswordRegRepeat']);
    $password_hash = password_hash($studfakepasswordReg, PASSWORD_BCRYPT);

    if (empty($studentName)) {
        $errors['studentName'] = "Name required";
    }
    if (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
        $errors['studentEmail'] = "Email address is invalid";
    }
    if (empty($studentEmail)) {
        $errors['studentEmail'] = "Email required";
    }
    if (empty($studfakepasswordReg)) {
        $errors['studfakepasswordReg'] = "Password required";
    }
    if($studfakepasswordReg !== $studfakepasswordRegRepeat) {
        $errors ['studfakepasswordReg'] = "The two passwords do not match";
    }

    if($query = $db->prepare("SELECT * FROM studreg WHERE studentEmail = ?" )){
        $error = '';
        $query->bind_param('s', $studentEmail);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){
            $error = '<p class="error"> Email already exits!</p>';
        }
        else{
            if(strlen($studfakepasswordReg) < 8){
                $error = '<p class="error"> Length of password must be more than 8!</p>';
            }
        }
        if(empty($error)){
            $insertQuery = $db->prepare("INSERT INTO studreg(studentName, studentEmail, studfakepasswordReg) VALUES (?,?,?)");
            $insertQuery->bind_param("sss", $studentName, $studentEmail, $password_hash);
            $result = $insertQuery->execute();
            if($result){
                $_SESSION['message'] = "You can now SignIn!";
                $_SESSION['alert-class'] = "alert-success";
                header('location:home-after-login.php');
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/register.css  ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Clients</a>
        <a href="#">Contact</a>
    </div>
    <div class="navbar-border">
        <div class="navbar">
            <div class="left-navbar">
                <div class="sidebar-pull" onclick="openNav()"><i class="fa fa-bars"></i></div>
                <div class="web-logo">
                    <img src="../images/logo-01.png">
                </div>    
            </div>
            <div class="right-navbar">
                <div class="user-profile">
                    <img src="../images/user-logo.PNG">
                </div>
            </div>
        </div>
    </div>

    <div class="Login-form">    
        <h1>It's the duty of students and work of teacher to be connected.</h1>
        <p class="flaunt-line">So here <span><img src="../images/login-image-02.png"></span> make it easy to happen between both of you.</p>
        <p class="wish-line">A great learning ahead.</p>
        <div class="Login-options">
            <button onclick="teacherLogin()">Register as a Teacher</button>
            <button onclick="studentLogin()">Register as a Student</button>
        </div>
        <div class="login-form" id="login-for-teacher">
            <form method="post">
                <input type="text" name="teacherName" id="teacherName" placeholder="Enter your name"><br>
                <input type="email" name="teacherEmailReg" id="teacherEmailReg" placeholder="Enter your Email-ID"><br>
                <input type="password" name="teachfakepasswordReg" id="teacherPasswordReg" placeholder="Enter a Password"><br>
                <input type="password" name="teachfakepasswordRegRepeat" id="teacherPasswordRegRepeat" placeholder="Re-enter your Password"><br>
                <input type="checkbox" name="showpsw" onclick="myFunction()">Show Password<br>
                <input type="submit" name="submitLoginFormTeacher" placeholder="Sign Up">
            </form>
            <div class="forgot-password">
                <div class="forgot-password-link"><a href="#">Forgot Password?</a></div>
            </div>
            <p>Also you can sign-up with:</p>
            <div class="more-sign-in-options">
                <img src="../images/google-logo-removebg-preview.png">
                <img src="../images/fb-logo-removebg-preview.png">
            </div>
            <div class="register-button">
                <div class="register-heading">Already registered <button><a href="../html/login-page.php">Log In Here</a></button></div>
            </div>
        </div>
        <div class="login-form" id="login-for-student">
            <form method="post">
                <input type="text" name="studentName" id="studentName" placeholder="Student Name"><br>
                <input type="email" name="studentEmail" id="studentEmail" placeholder="Student's Email-ID"><br>
                <input type="password" name="studfakepasswordReg" id="studentPasswordReg" placeholder="Enter a Password"><br>
                <input type="password" name="studfakepasswordRegRepeat" id="studentPasswordRegRepeat" placeholder="Re-enter a Password"><br>
                <input type="checkbox" name="showpsw" onclick="myFunction()">Show Password<br>
                <input type="submit" name="submitLoginFormStudent" placeholder="Log In">
            </form>
            <div class="forgot-password">
                <div class="forgot-password-link"><a href="#">Forgot Password?</a></div>
            </div>
            <p>Also you can sign-up with:</p>
            <div class="more-sign-in-options">
                <img src="../images/google-logo-removebg-preview.png">
                <img src="../images/fb-logo-removebg-preview.png">
            </div>
            <div class="register-button">
                <div class="register-heading">Already registered <button><a href="../html/login-page.php">Log In Here</a></button></div>
            </div>
        </div>
    </div>
    <script src="../js/home-after-login.js"></script>
</body>
</html>
</body>
</html>