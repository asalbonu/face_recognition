<?php
if (isset($_GET['id']) || !empty($_GET['id']))
{
    require_once('config.php');
    $id = $_GET['id'];
    $query = "Select * from teachers where id = '$id'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);
    if($rows <= 0){
        header('Localtion:index.php?page=11');
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
                <h3 class="card-title">Изменение данных учителя </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="pages/teacher/update.php"  method="post" enctype="multipart/form-data">
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
                    <label for="exampleInputPassword1">Возраст</label>
                    <input type="number" name="age" value="<?=$row['age'];?>" class="form-control" id="exampleInputPassword1" placeholder="">
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
                    echo " <option value='male'>Мужской</option>
                    <option value='female'selected >Женский</option>";
                }
                ?>
                  </select>
                  <label for="">Предмет</label>
                  <select name="subject" id="" class="form-control">
                  <?php
                  $b = ["Русский язык","Английский язык","Биология","География","Алгебра","Геометрия","История","Обществознание",
                  "Информатика","Физика","Химия","Физкультура","Забони давлатӣ"];
                  foreach($b as $i){
                    if($i == $row['subject'])echo "<option value='$i' selected>$i</option>";
                    else echo "<option value='$i'>$i</option>";
                  }
                  ?>
                  </select>
                  <label for="">Категория специальности</label>
                  <select name="category_of_specialty" id="" class="form-control">
                    <?php
                    $a = [1,2,'highest'];
                  for($i = 0;$i <3;$i++){
                    if($a[$i] == $row['category_of_specialty'])echo "<option value='$a[$i]' selected>$a[$i]</option>";
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

    