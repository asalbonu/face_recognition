
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    
</head>
<body>
<form action="?page=3" method="POST">
    <label for="">Выбрать класс</label>
    <select name="grade">
    <?php
        $grade = 1;
        $class = 'A';
        for($i = 1;$i < 12; $i++){
            if(isset($_POST['grade']) && $i == $_POST['grade']){
               $grade = $_POST['grade'];
    ?>
        <option value="<?=$i?>" selected><?=$i?></option>
        <?php
            }
            else{
        ?>
        <option value="<?=$i?>" ><?=$i?></option>
        <?php }
        } ?>
    </select>
    <label for="" style="margin-left: 10px;">Выбрать группу</label>
    <select name="class">
    <?php
        $c = ['A','B','C','D'];
        foreach($c as $c1){
            if($c1 == $_POST['class'] && isset($_POST['class'])){
                $class = $_POST['class'];
    ?>
        <option value="<?=$c1?>" selected><?=$c1?></option>
        <?php
            }
            else{
        ?>
        <option value="<?=$c1?>" ><?=$c1?></option>
        <?php }
        } ?>
    </select>
    <input type="submit" class="btn btn-secondary" style="margin-bottom: 10px;">
</form>
<table class="table col-sm-9">
        <tr> 
            <th>#</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Очество</th>
            <th>День рождения</th>
            <th>Пол</th>
            <th>Класс</th>
            <th>группа</th>
           <th>Удалить</th>
           <th>Изменить</th>
        </tr>
        <?php
        $i=0;
        require_once("config.php");
        $query = "Select * from users where `grade` = $grade and `class` = '$class' order by surname,name ASC;";
        $result = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($result)){
        $i++;
        ?>
        <tr>
            <td><?=$i;?></td>
            <td><?=$row['name'];?></td>
            <td><?=$row['surname'];?></td>
            <td><?=$row['patronymic'];?></td>
            <td><?=$row['birth'];?></td>
            <?php
            if($row['gender'] == 'male'){?>
             <td>Мужской</td>
            <?php } 
            else{ ?>
             <td>Женский</td>
             <?php } ?>
              <td><?=$row['grade'];?></td>
                            <td><?=$row['class'];?></td>
            <td><a class="btn btn-danger" href="?page=6&id=<?=$row['id']?>">Удалить</a></td>
            <td><a class="btn btn-success" href="?page=4&id=<?=$row['id']?>">Изменить</a></td>
        </tr>

    <?php } ?> </table>
    <a class="btn btn-primary " href="?page=1">Добавить</a>

</body>
</html>