<?php
if (isset($_GET['edit']))
{
  


require_once('..\config2.php');


$id = $_GET['id'];
$name = $_GET['name'];
$surname = $_GET['surname'];
$date = $_GET['date'];
$email = $_GET['email'];
$gender = $_GET['gender'];
$login = $_GET['login'];
$password = $_GET['password'];


$query = "UPDATE `register`
set 
`name` = '$name',
`surname` = '$surname',
`date` = '$date', 
	`email` = '$email', 
	`gender` = '$gender', 
	`login` = '$login', 
	`password` = '$password'
	
	WHERE
	`id` = '$id';";
$result = mysqli_query($conn, $query);
header('Location: ../../index.php');
}
?>