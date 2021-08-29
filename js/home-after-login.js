function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}
  
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}
var teachLog = document.getElementById("login-for-teacher");
var studentLog = document.getElementById("login-for-student");
teachLog.style.display = "none";
studentLog.style.display = "none";
function teacherLogin(){
    if(teachLog.style.display == "none"){
        teachLog.style.display = "block";
        studentLog.style.display = "none";
    }
}
function studentLogin(){
    if(studentLog.style.display == "none"){
        teachLog.style.display = "none";
        studentLog.style.display = "block";
    }
}