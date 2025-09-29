<?php
require_once('config.php');

$msg = "";
$class_name = 'A';
$grade_name = 1;
$day = "Monday";
$current_schedule = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    $class_name = $conn->real_escape_string($_POST["class"] ?? $class_name);
    $grade_name = $conn->real_escape_string($_POST["grade"] ?? $grade_name);
    $day = $conn->real_escape_string($_POST["day"] ?? $day);

    if ($action === 'load') {
        
        $res = $conn->query("SELECT * FROM schedule 
                             WHERE class='$class_name' AND grade='$grade_name' AND day_of_week='$day'
                             ORDER BY lesson_number");
        $current_schedule = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $current_schedule[$row['lesson_number']] = $row;
            }
        }
        $msg = "🔎 Расписание загружено для: {$grade_name}{$class_name}, {$day}";
    } elseif ($action === 'save') {
     
        $conn->query("DELETE FROM schedule 
                      WHERE class='$class_name' AND grade='$grade_name' AND day_of_week='$day'");

        if (!empty($_POST["subject"])) {
            foreach ($_POST["subject"] as $lesson_num => $subject_raw) {
                $subject = $conn->real_escape_string($subject_raw);
                $teacher_raw = $_POST["teacher"][$lesson_num] ?? '';
                $room = $conn->real_escape_string($_POST["room"][$lesson_num] ?? '');

                $teacher_trim = trim($teacher_raw);
                if ($teacher_trim === '') {
                    $teacher_id_val = "NULL";
                } else {
                    $parts = preg_split('/\s+/', $teacher_trim, 2);
                    $surname = $conn->real_escape_string($parts[0] ?? '');
                    $name = $conn->real_escape_string($parts[1] ?? '');
                    $t = $conn->query("SELECT id FROM teachers WHERE `name` = '$name' AND `surname` = '$surname' LIMIT 1");
                    if ($t && $t->num_rows) {
                        $tr = $t->fetch_assoc();
                        $teacher_id_val = (int)$tr['id'];
                    } else {
                        // Если не нашли учителя — оставляем NULL (или можно создать нового)
                        $teacher_id_val = "NULL";
                    }
                }

                if (!empty($subject)) {
                    $teacher_sql_part = ($teacher_id_val === "NULL") ? "NULL" : ("'".$conn->real_escape_string((string)$teacher_id_val)."'");
                    $sql = "INSERT INTO schedule (class, grade, day_of_week, lesson_number, subject, teacher_id, room)
                            VALUES ('$class_name', '$grade_name', '$day', ".(int)$lesson_num.", '$subject', $teacher_sql_part, '$room')";
                    $conn->query($sql);
                }
            }
        }
        $res = $conn->query("SELECT * FROM schedule 
                             WHERE class='$class_name' AND grade='$grade_name' AND day_of_week='$day'
                             ORDER BY lesson_number");
        $current_schedule = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $current_schedule[$row['lesson_number']] = $row;
            }
        }

        $msg = "✅ Расписание сохранено для: {$grade_name}{$class_name}, {$day}";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Изменить расписание</title>
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
    <h1>✏ Изменить расписание уроков</h1>

    <?php if ($msg): ?>
        <div class="msg"><?=htmlspecialchars($msg)?></div>
    <?php endif; ?>

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

        <label>День недели:</label>
        <select name="day" required>
            <?php 
            $days = [
                "Monday" => "Понедельник",
                "Tuesday" => "Вторник",
                "Wednesday" => "Среда",
                "Thursday" => "Четверг",
                "Friday" => "Пятница",
                "Saturday" => "Суббота"
            ];
            foreach($days as $k=>$v): ?>
                <option value="<?=$k?>" <?=$k==$day?'selected':''?>><?=$v?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="action" value="load">🔎 Загрузить расписание</button>

        <table>
            <tr>
                <th>№ урока</th>
                <th>Предмет</th>
                <th>Учитель (Фамилия Имя)</th>
                <th>Кабинет</th>
            </tr>
            <?php for ($i=1; $i<=7; $i++):
                $subj = $current_schedule[$i]['subject'] ?? '';
                $room = $current_schedule[$i]['room'] ?? '';
                $teacher_id = $current_schedule[$i]['teacher_id'] ?? '';
                $teacher_name = '';
                if (!empty($teacher_id)) {
                    $tr = $conn->query("SELECT surname, name FROM teachers WHERE id='".intval($teacher_id)."' LIMIT 1");
                    if ($tr && $tr->num_rows>0) {
                        $trow = $tr->fetch_assoc();
                        $teacher_name = $trow['surname']." ".$trow['name'];
                    }
                }
            ?>
            <tr>
                <td><?=$i?></td>
                <td><input type="text" name="subject[<?=$i?>]" value="<?=htmlspecialchars($subj)?>" placeholder="Например: Математика"></td>
                <td><input type="text" name="teacher[<?=$i?>]" value="<?=htmlspecialchars($teacher_name)?>" placeholder="Фамилия Имя"></td>
                <td><input type="text" name="room[<?=$i?>]" value="<?=htmlspecialchars($room)?>" placeholder="Номер кабинета"></td>
            </tr>
            <?php endfor; ?>
        </table>

        <button type="submit" name="action" value="save">💾 Обновить расписание</button>
    </form>
</div>
</body>
</html>
