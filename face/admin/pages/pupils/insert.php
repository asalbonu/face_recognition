<?php
if (isset($_POST["save"])) {
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'face_recognition';
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) { 
    die('Ошибка подключения к БД: '. $conn->connect_error);
}
  $name = $_POST["name"];
  $surname = $_POST["surname"];
$birth = $_POST["birthday"];
$gender = $_POST["gender"];
$grade = $_POST["grade"];
$class = $_POST["class"];
$patronymic = $_POST["patronymic"];
$query1 = "SELECT id from users Order by id DESC LIMIT 1;";
$result1 =mysqli_fetch_assoc(mysqli_query($conn,$query1));
$id = $result1['id'] + 1;
$query = "INSERT INTO `users`(id,`name`,`surname`,`birth`,`patronymic`, `gender`,`grade`,`class`)
VALUES($id,'$name', '$surname', '$birth',  '$patronymic','$gender','$grade','$class');";
$result = mysqli_query($conn,$query);

echo "<div class = 'alert alert-success'>Успешно добавлено!</div>";
}
?>