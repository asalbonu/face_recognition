<?php

if (isset($_POST["save"])) {
$name = $_POST["name"];
$img = $_FILES["img"]['name'];
$text = $_POST["text"];
$price = $_POST["price"];
require_once('C:\OSPanel\domains\Foodies\config.php');
$query = "INSERT INTO `store`.`menu` 
	(`name`, 
	`img`, 
	`text`, 
	`price` )
	VALUES
	(
	'$name', 
	'$img', 
	'$text', 
	'$price' 
	);";

$result = mysqli_query($conn,$query);


}

?>
