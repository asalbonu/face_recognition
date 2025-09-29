
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    
</head>
<body>
<form action="?page=11" method="POST">
    <label for="">Выбрать предмет</label>
    <select name="subject">
    <?php
        $subjects = ['Алгебра','Геометрия','Биология','География','Обшествознание',
        'Физика','Химия','Английский язык','Информатика','Русский язык'];
        $subject = 'Алгебра';
        foreach($subjects as $s){
            if($s == $_POST['subject'] && isset($_POST['subject'])){
                $subject =$_POST['subject'];
    ?>
        <option value="<?=$s?>" selected><?=$s?></option>
        <?php
            }
            else{
        ?>
        <option value="<?=$s?>" ><?=$s?></option>
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
            <th>Возраст</th>
            <th>День рождения</th>
            <th>Пол</th>
            <th>Предмет</th>
            <th>Категория специальности</th>
           <th>Удалить</th>
           <th>Изменить</th>
        </tr>
        <?php
        $i=0;
        require_once("config.php");
        $query = "Select * from teachers where `subject` = '$subject';";
        $result = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($result))
        {
        $i++;
        ?>
        <tr>
            <td><?=$i;?></td>
            <td><?=$row['name'];?></td>
            <td><?=$row['surname'];?></td>
            <td><?=$row['patronymic'];?></td>
             <td><?=$row['age'];?></td>
            <td><?=$row['birth'];?></td>
            <?php
            if($row['gender'] == 'male'){?>
             <td>Мужской</td>
            <?php } else{ ?>
             <td>Женский</td>
             <?php } ?>
              <td><?=$row['subject'];?></td>
              <td><?=$row['category_of_specialty'];?></td>
         
            <td><a class="btn btn-danger" href="?page=14&id=<?=$row['id']?>">Удалить</a></td>
            <td><a class="btn btn-success" href="?page=12&id=<?=$row['id']?>">Изменить</a></td>
        </tr>
           <?php }?>
    </table>

    <a class="btn btn-primary " href="?page=9">Добавить</a>

</body>
</html>