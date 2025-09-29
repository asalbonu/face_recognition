<?php
if (isset($_GET['edit']))
{
  


require_once('C:\OSPanel\domains\Foodies\config.php');


$id = $_GET['id'];
$name = $_GET['name'];
$img = $_GET['img'];
$text = $_GET['text'];
$price = $_GET['price'];


$query = "UPDATE `store`.`menu` 
	SET
	
	`name` = '$name', 
	`img` = '$img', 
	`text` = '$text', 
	`price` = '$price'
	
	WHERE
	`id` = '$id' ;";
$result = mysqli_query($conn, $query);
header('Location: ../../index.php?page=15');
}
?>