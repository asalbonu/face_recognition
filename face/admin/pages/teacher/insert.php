<?php
if (isset($_POST["save"])) {
require_once('config.php');
  $name = $_POST["name"];
  $surname = $_POST["surname"];
$birth = $_POST["birthday"];
$gender = $_POST["gender"];
$subject = $_POST["subject"];
$category_of_specialty = $_POST["category_of_specialty"];
$patronymic = $_POST["patronymic"];
$age = $_POST["age"];
$query = "INSERT INTO `teachers`(`name`,`surname`,`birth`,`patronymic`, `gender`,`category_of_specialty`,`subject`,`age`)
VALUES('$name', '$surname', '$birth',  '$patronymic','$gender','$category_of_specialty','$subject','$age');";
$result = mysqli_query($conn,$query);
echo "<div class = 'alert alert-success'>Успешно добавлено!</div>";
}
?>