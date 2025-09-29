
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    
</head>
<body>

<table class="table col-sm-9">
        <tr> 
            <th>#</th>
            <th>Name</th>
            <th>Img</th>
            <th>Text</th>
            <th>Price</th>
           <th>Удалить</th>
           <th>Изменить</th>
        </tr>
        <?php
        $i=0;
    require_once('C:\OSPanel\domains\Foodies\config.php');
        $query = "Select * from menu";
        $result = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($result))
        {
            
        $i++;
        ?>
        <tr>
            <td><?=$i;?></td>
            <td><?=$row['name'];?></td>
            <td><?=$row['img'];?></td>
            <td><?=$row['text'];?></td>
            <td><?=$row['price'];?></td>
            <td><a class="btn btn-danger" href="?page=16&id=<?=$row['id']?>">Удалить</a></td>
            <td><a class="btn btn-success" href="?page=17&id=<?=$row['id']?>">Изменить</a></td>
        </tr>
        <?php
        }
        ?>

    </table>
    <a class="btn btn-primary " href="?page=13">Добавить</a>

</body>
</html>