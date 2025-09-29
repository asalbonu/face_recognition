<?php
if(isset($_POST['username'])){
$host = "localhost";
$user = "v98577nf_face";
$pass = "v98577nf_facee";
$db   = "v98577nf_face"; 
    session_start();
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);

$username = $_POST['username'];
$password = $_POST['password'];
$sql = "
    SELECT * from students where nickname = '$username' AND password ='$password';
";
$sql1 = "
    SELECT * from students where nickname = '$username';
";
$result = mysqli_query($conn,$sql);
$error= "";
$s = mysqli_num_rows($result);

if($s > 0){
  $row = $result->fetch_assoc();
  $_SESSION['username1'] = $username;
  $_SESSION['id1'] = $row['user_id'];
  $idd = $row['user_id'];
  header("Location: profile.php?id=$idd");
}else{
    $result1 = $conn->query($sql1);
    if($result1->num_rows > 0){
      $error = "Неправильный пароль";
    }
    else{
      $error = "Такого пользователя не существует!";
    }
}}
?>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
    }

    .login-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      width: 300px;
      text-align: center;
    }

    .login-container h2 {
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .login-container input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    .login-container input:focus {
      border-color: #3498db;
      outline: none;
      box-shadow: 0 0 5px rgba(52,152,219,0.6);
    }

    .login-container button {
      width: 100%;
      padding: 10px;
      margin-top: 15px;
      background: #3498db;
      border: none;
      border-radius: 6px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .login-container button:hover {
      background: #2c80b4;
    }

    .login-container .links {
      margin-top: 15px;
      font-size: 14px;
    }

    .login-container .links a {
      color: #3498db;
      text-decoration: none;
    }

    .login-container .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
  <div class="login-container">
    <h2>Вход в систему</h2>
    <form action="login.php" method="post">
      <?php
      if(isset($_POST['username'])){
      ?>
      <input type="text" name="username" placeholder="Логин" value="<?= $_POST['username']?>" required>
      <?php
      }else{
      ?>
      <input type="text" name="username" placeholder="Логин" required>
      <?php } 
      if(isset($error) && $error == "Такого пользователя не существует!") echo "<span style = 'color:red'>$error</span>";
      if(isset($_POST['username'])){?>
      <input type="password" name="password" placeholder="Пароль" value="<?= $_POST['password']?>" required>
      <?php
      }
      else{
      ?>
      <input type="password" name="password" placeholder="Пароль"  required>
      <?php }
      if(isset($error) && $error == "Неправильный пароль") echo "<span style = 'color:red'>$error</span>";
      ?>
      <button type="submit">Войти</button>
    </form>
    <div class="links">
      <a href="#">Забыли пароль?</a>
    </div>
  </div>

</body>
</html>