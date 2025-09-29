<?php

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $id = $_GET["id"];
    require_once('config.php');
    $query= "delete from teachers where id = $id";
    $result = mysqli_query($conn,$query);
    echo "<script>window.location.href='$i?page=11';</script>";
}
?>