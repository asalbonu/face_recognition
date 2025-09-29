<?php
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'face_recognition';
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) { 
    die('Ошибка подключения к БД: '. $conn->connect_error);
}
?>