<?php
session_start();
    $db = mysqli_connect('localhost','root',"",'googleclass');
    if($db->connect_error){
        die("Connection Failed!".$db->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLoginFormTeacher'])) {
        $teacherEmailReg = $_POST['teacherEmailReg'];
        $teachfakepasswordReg = $_POST['teachfakepasswordReg'];
        $errors = array();
        // validation
        if (empty($teacherEmailReg)) {
            $errors['teacherEmailReg'] = "Email required";
        }
        if (empty($teachfakepasswordReg)) {
            $errors['teachfakepasswordReg'] = "Password required";
        }


        if (count($errors)===0) {
        $sql = "SELECT * FROM teacherreg WHERE teacherEmailReg=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s',$teacherEmailReg);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
            if($user===NULL){
                $errors['login_fail']= "Wrong credentials";
            }
            else{
                if(password_verify($teachfakepasswordReg, $user['teachfakepasswordReg'])) {
                    $_SESSION['teacherName'] = $user['teacherName'];
                    $_SESSION['teacherEmailReg'] = $user['teacherEmailReg'];
                    // flash message
                    $_SESSION['message'] = "You are now logged in!";
                    $_SESSION['alert-class'] = "alert-success";
                    header('location:home-after-login.php'); 
                    exit();
                } 
                else{
                    $errors['login_fail']= "Wrong credentials";
                }
            }
        }
    }
?>

<?php
    $db = mysqli_connect('localhost','root',"",'googleclass');
    if($db->connect_error){
        die("Connection Failed!".$db->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLoginFormStudent'])) {
        $studentEmail = $_POST['studentEmail'];
        $studfakepasswordReg = $_POST['studfakepasswordReg'];
        $errors = array();
        // validation
        if (empty($studentEmail)) {
            $errors['studentEmail'] = "Email required";
        }
        if (empty($studfakepasswordReg)) {
            $errors['studfakepasswordReg'] = "Password required";
        }


        if (count($errors)===0) {
        $sql = "SELECT * FROM studreg WHERE studentEmail=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s',$studentEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
            if($user===NULL){
                $errors['login_fail']= "Wrong credentials";
            }
            else{
                if(password_verify($studfakepasswordReg, $user['studfakepasswordReg'])) {
                    $_SESSION['studentName'] = $user['studentName'];
                    $_SESSION['studentEmail'] = $user['studentEmail'];
                    // flash message
                    $_SESSION['message'] = "You are now logged in!";
                    $_SESSION['alert-class'] = "alert-success";
                    header('location:home-after-login.php'); 
                    exit();
                } 
                else{
                    $errors['login_fail']= "Wrong credentials";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/login-page.css">
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
            <button onclick="teacherLogin()">Login as a Teacher</button>
            <button onclick="studentLogin()">Login as a Student</button>
        </div>
        <div class="login-form" id="login-for-teacher">
            <form method="post">
                <input type="email" name="teacherEmailReg" id="teacherEmail" placeholder="Teacher's Email-ID"><br>
                <input type="password" name="teachfakepasswordReg" id="teacherPassword" placeholder="Password"><br>
                <input type="checkbox" name="showpsw" onclick="myFunction()">Show Password<br>
                <input type="submit" name="submitLoginFormTeacher" placeholder="Log In">
            </form>
            <div class="forgot-password">
                <div class="forgot-password-link"><a href="#">Forgot Password?</a></div>
            </div>
            <p>Also you can sign-in with:</p>
            <div class="more-sign-in-options">
                <img src="../images/google-logo-removebg-preview.png">
                <img src="../images/fb-logo-removebg-preview.png">
            </div>
            <div class="register-button">
                <div class="register-heading">Did not signed up <button><a href="../html/register.php">Register Here</a></button></div>
            </div>
        </div>
        <div class="login-form" id="login-for-student">
            <form method="post">
                <input type="email" name="studentEmail" id="studentEmail" placeholder="Student's Email-ID"><br>
                <input type="password" name="studfakepasswordReg" id="studentPassword" placeholder="Password"><br>
                <input type="checkbox" name="showpsw" onclick="myFunction()">Show Password<br>
                <input type="submit" name="submitLoginFormStudent" placeholder="Log In">
            </form>
            <div class="forgot-password">
                <div class="forgot-password-link"><a href="#">Forgot Password?</a></div>
            </div>
            <p>Also you can sign-in with:</p>
            <div class="more-sign-in-options">
                <img src="../images/google-logo-removebg-preview.png">
                <img src="../images/fb-logo-removebg-preview.png">
            </div>
            <div class="register-button">
                <div class="register-heading">Did not signed up <button><a href="../html/register.php">Register Here</a></button></div>
            </div>
        </div>
    </div>
    <script src="../js/home-after-login.js"></script>
</body>
</html>