<?php
	$db = mysqli_connect('localhost','root',"",'googleclass');
    if($db->connect_error){
        die("Connection Failed!".$db->connect_error);
    }
?>