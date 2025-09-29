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
$grade = $_POST['grade'];
$class = $_POST['class'];
$query = "UPDATE `users`set 
`name` = '$name',
`surname` = '$surname',
`patronymic` = '$patronymic',
`birth` = '$birthday',
`gender` = '$gender',
`grade` = '$grade',
`class` = '$class'
where `id` = '$id'";
$result = mysqli_query($conn, $query);

header('Location: ../../index.php?page=3');
}
?>