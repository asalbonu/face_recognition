<?php
if (isset($_POST['edit']))
{
require_once('config.php');
$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$patronymic = $_POST['patronymic'];
$birthday = $_POST['birthday'];
$gender = $_POST['gender'];
$subject = $_POST['subject'];
$category_of_specialty = $_POST['category_of_specialty'];
$age = $_POST['age'];
$query = "UPDATE `face`.`teachers`
set 
`name` = '$name',
`surname` = '$surname',
`patronymic` = '$patronymic',
`birth` = '$birthday',
`gender` = '$gender',
`subject` = '$subject',
`category_of_specialty` = '$category_of_specialty',
`age` = $age
where `id` = $id";
$result = mysqli_query($conn, $query);

header('Location: ../../index.php?page=11');
}
?>