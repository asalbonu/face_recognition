<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "face_recognition";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);

$class_name = $_POST["class"] ?? "A";
$grade_name = $_POST["grade"] ?? 1;

$current_schedule = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $res = $conn->query("SELECT * FROM schedule 
                         WHERE class='$class_name' AND grade='$grade_name'
                         ORDER BY day_of_week, lesson_number");
    while($row = $res->fetch_assoc()) {
        $current_schedule[$row['day_of_week']][$row['lesson_number']] = $row;
    }
}
$days = [
    "Monday"    => "Понедельник",
    "Tuesday"   => "Вторник",
    "Wednesday" => "Среда",
    "Thursday"  => "Четверг",
    "Friday"    => "Пятница",
    "Saturday"  => "Суббота"
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Расписание класса <?=$grade_name?><?=$class_name?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; }
        .box { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: center; font-size: 14px; }
        th { background: #3498db; color: #fff; }
        select, button { padding: 6px; margin: 5px 0; }
        .tables-row { display: flex; gap: 20px; margin-top: 20px; }
        .tables-row > div { flex: 1; }
        h2 { margin: 0; padding: 5px; text-align: center; background: #eee; border-radius: 8px; }
    </style>
</head>
<body>
<div class="box">
    <h1>📖 Расписание <?=$grade_name?><?=$class_name?></h1>

    <form method="POST">
        <label>Класс:</label>
        <select name="grade" required>
            <?php for($g=1;$g<=11;$g++): ?>
                <option value="<?=$g?>" <?=$g==$grade_name ? 'selected' : '' ?>><?=$g?></option>
            <?php endfor; ?>
        </select>

        <label>Буква:</label>
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

        <button type="submit">🔎 Показать</button>
    </form>

    <?php if (!empty($current_schedule)): ?>
        <?php 
      
        $day_keys = array_keys($days);
        for ($i=0; $i<count($day_keys); $i+=3): 
            $chunk = array_slice($day_keys, $i, 3);
        ?>
            <div class="tables-row">
                <?php foreach ($chunk as $day): ?>
                <div>
                    <h2><?=$days[$day]?></h2>
                    <table>
                        <tr><th>№</th><th>Предмет</th><th>Учитель</th><th>Каб.</th></tr>
                        <?php for ($l=1;$l<=7;$l++): 
                            $subj = $current_schedule[$day][$l]['subject'] ?? '';
                            $room = $current_schedule[$day][$l]['room'] ?? '';
                            $teacher_id = $current_schedule[$day][$l]['teacher_id'] ?? '';
                            $teacher_name = '';
                            if ($teacher_id) {
                                $tr = $conn->query("SELECT surname,name FROM teachers WHERE id='".intval($teacher_id)."' LIMIT 1");
                                if ($tr && $tr->num_rows) {
                                    $trow = $tr->fetch_assoc();
                                    $teacher_name = $trow['surname']." ".$trow['name'];
                                }
                            }
                        ?>
                        <tr>
                            <td><?=$l?></td>
                            <td><?=htmlspecialchars($subj)?></td>
                            <td><?=htmlspecialchars($teacher_name)?></td>
                            <td><?=htmlspecialchars($room)?></td>
                        </tr>
                        <?php endfor; ?>
                    </table>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    <?php endif; ?>
</div>
</body>
</html>
