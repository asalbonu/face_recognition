<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "face_recognition";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);
$classes = $conn->query("SELECT DISTINCT grade, class FROM users ORDER BY grade, class");
$msg = "";
$class_name = 'A';
$grade_name = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_name = $conn->real_escape_string($_POST["class"]);
    $grade_name = $conn->real_escape_string($_POST["grade"]);
    $day = $conn->real_escape_string($_POST["day"]);

    if (!empty($_POST["subject"])) {
        foreach ($_POST["subject"] as $lesson_num => $subject) {
            $subject = $conn->real_escape_string($subject);
            $teacher = $conn->real_escape_string($_POST["teacher"][$lesson_num]);
            $room = $conn->real_escape_string($_POST["room"][$lesson_num]);
            $surname = '';
            $name = '';
            $ind = 0;
            for($i = 0; $i < strlen($teacher);$i++){
              if($teacher[$i] != " "){
                $surname = $surname.$teacher[$i];
            }
            else{
                $ind = $i + 1;
                break;
            }
            }
            for($j = $ind; $j < strlen($teacher);$j++){
                $name = $name.$teacher[$j];
            }
        
            $t = mysqli_query($conn,"SELECT id FROM teachers where `name` = '$name' and `surname` = '$surname';");
            $teacher_id = mysqli_fetch_array($t);
            if (!empty($subject)) {
                $p = $conn->query("INSERT INTO schedule (class, grade, day_of_week, lesson_number, subject, teacher_id,room)
                              VALUES ('$class_name', '$grade_name','$day', $lesson_num, '$subject', '$teacher_id[0]','$room')");
            }
        }
        $msg = "✅ Расписание успешно добавлено!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить расписание</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; }
        .box { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: #3498db; color: #fff; }
        select, input, button { padding: 6px; margin: 5px 0; }
        .msg { padding: 10px; background: #eafbea; border-left: 5px solid #2ecc71; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="box">
    <h1>📘 Добавить расписание уроков</h1>

    <?php if ($msg): ?>
        <div class="msg"><?=$msg?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Выберите класс:</label>
        <select name="grade" required>
            <?php for($g=1;$g<=11;$g++): ?>
                <option value="<?=$g?>" <?=$g==$grade_name ? 'selected' : '' ?>><?=$g?></option>
            <?php endfor; ?>
           
        </select>
        <label>Выберите букву:</label>
        <select name="class" required>
           <?php 
          $g = [
             'A' => 'А',
            'B' => 'Б',
            'C' => 'В',
            'G' => 'Г',
            'D' => 'Д',
            
          ];
          foreach(['A','B','C','G','D'] as $c): ?>
            <option value = '<?=$c?>' <?=$c==$class_name?'selected':''?>><?=$g[$c]?></option><?php endforeach; ?>
    
        </select>

        <label>День недели:</label>
        <select name="day" required>
            <option value="Monday">Понедельник</option>
            <option value="Tuesday">Вторник</option>
            <option value="Wednesday">Среда</option>
            <option value="Thursday">Четверг</option>
            <option value="Friday">Пятница</option>
            <option value="Saturday">Суббота</option>
        </select>

        <table>
            <tr>
                <th>№ урока</th>
                <th>Предмет</th>
                <th>Учитель</th>
                <th>Кабинет</th>
            </tr>
            <?php for ($i=1; $i<=7; $i++): ?>
            <tr>
                <td><?=$i?></td>
                <td><input type="text" name="subject[<?=$i?>]" placeholder="Например: Математика"></td>
                <td><input type="text" name="teacher[<?=$i?>]" placeholder="ФИО учителя"></td>
                <td><input type="text" name="room[<?=$i?>]" placeholder="Номер кабинета"></td>
            </tr>
            <?php endfor; ?>
        </table>
        <button type="submit">💾 Сохранить расписание</button>
    </form>
</div>
</body>
</html>