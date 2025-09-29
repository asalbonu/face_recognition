<?php
if (isset($_GET['id']) || !empty($_GET['id']))
{
   $host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'face';
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) { 
    die('Ошибка подключения к БД: '. $conn->connect_error);
}
    
    $id = $_GET['id'];
    $query = "Select * from users where id = $id";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);
    if($rows <= 0){
        header('Localtion:index.php?page=3');
    }
    $row = mysqli_fetch_assoc($result);
    
}
?>
<link rel="stylesheet" href="css/bootsrap.css">
<div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Добавление ученика(цы)</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="pages/pupils/update.php"  method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                     <input type="hidden" name="id" value="<?=$row['id'];?>">
                    <label for="exampleInputEmail1">Имя</label>
                    <input type="text" name="name" value="<?=$row['name'];?>" class="form-control" id="exampleInputEmail1" >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Фамилия</label>
                    <input type="text" name="surname" value="<?=$row['surname'];?>" class="form-control" id="exampleInputPassword1" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Очество</label>
                    <input type="text" name="patronymic" value="<?=$row['patronymic'];?>" class="form-control" id="exampleInputPassword1" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">День рождения</label>
                    <input type="date" name="birthday" value="<?=$row['birth'];?>" class="form-control" id="exampleInputPassword1" placeholder="">
                  </div>
                  <label for="">Пол</label>
                  <select name="gender" id="" class="form-control">
                <?php
                if($row['gender'] == "male"){
                    echo " <option value='male' selected >Мужской</option>
                    <option value='female'>Женский</option>";
                }
                else{
                    echo " <option value='male'  >Мужской</option>
                    <option value='female'selected >Женский</option>";
                }
                ?>
                  </select>
                  <label for="">Класс</label>
                  <select name="grade" id="" class="form-control">
                  <?php
                  for($i = 1;$i <=11;$i++){
                    if($i == $row['grade'])echo "<option value='$i' selected>$i</option>";
                    else echo "<option value='$i'>$i</option>";
                  }
                  ?>
                  </select>
                  <label for="">Группа</label>
                  <select name="class" id="" class="form-control">
                    <?php
                    $a = ['A','B','C','D','G'];
                  for($i = 0;$i <5;$i++){
                    if($a[$i] == $row['class'])echo "<option value='$a[$i]' selected>$a[$i]</option>";
                    else echo "<option value='$a[$i]'>$a[$i]</option>";
                  }
                  ?>
                  </select>
                 
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
              <input type="submit" value="Изменить" class="btn btn-success" name="edit">   
            </div>
                
              </form>
              
            </div>
</div>
        </div>
       
 </div>

    