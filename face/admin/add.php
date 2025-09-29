<?php
require_once("../config2.php");

if(isset($_POST['add'])){
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$date = $_POST['date'];
$gender = $_POST['gender'];
$login = $_POST['login'];
$password =  $_POST['login'];
}
$query = "INSERT INTO `face_recognition`.`register`(`name`,`surname`,`date`,`email`,`gender`,`login`, `password`)
	VALUES
	('$name','$surname','$date','$email','$gender',	'$login', 
	'$password')";
    $result = mysqli_query($conn, $query);
    header("Location: index.php")
    ?>