<?php
$host = "localhost";
$user = "v98577nf_face";
$pass = "v98577nf_facee";
$db   = "v98577nf_face"; 
session_start();
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);
if(!isset($_SESSION['id1'])) header("Location: login.php");
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "
SELECT 
    u.id,
    u.surname,
    u.name,
    u.patronymic,
    u.gender,
    u.birth,
    u.grade,
    u.class,
    ROUND(SUM(v.visit='visited') / COUNT(v.visit) * 100, 2) AS attendance,
    ROUND(AVG(g.grade_value),2) AS avg_grade,
    ROUND(((SUM(v.visit='visited') / COUNT(v.visit) * 100) + (AVG(g.grade_value) * 10)) / 2, 2) AS rating
FROM users u
LEFT JOIN visits v ON u.id = v.user_id
LEFT JOIN grades g ON u.id = g.user_id
WHERE u.id = $student_id
GROUP BY u.id
";
$student = $conn->query($sql)->fetch_assoc();

$selected_date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");

$grades_result = $conn->query("
    SELECT g.subject, g.grade_value, g.grade_date, t.name AS teacher
    FROM grades g
    LEFT JOIN teachers t ON g.teacher_id = t.id
    WHERE g.user_id = $student_id AND g.grade_date = $selected_date
");


$subjects_sql = "
    SELECT subject, ROUND(AVG(grade_value),2) AS avg_subj
    FROM grades
    WHERE user_id = $student_id
    GROUP BY subject
";
$subj_res = $conn->query($subjects_sql);
$strong = [];
$weak = [];
while($row = $subj_res->fetch_assoc()) {
    if ($row['avg_subj'] >= 8) $strong[] = $row['subject']." (".$row['avg_subj'].")";
    elseif ($row['avg_subj'] <= 5) $weak[] = $row['subject']." (".$row['avg_subj'].")";
}

$stmt2 = $conn->prepare("
    SELECT day_of_week, lesson_number, subject, room
    FROM schedule
    WHERE grade = ? AND class = ?
    ORDER BY FIELD(day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday'), lesson_number
");
$stmt2->bind_param("is", $student['grade'], $student['class']);
$stmt2->execute();
$schedule_result = $stmt2->get_result();
$schedule = [];
while($row = $schedule_result->fetch_assoc()) {
    $schedule[$row['day_of_week']][] = $row;
}

$conn->close();

$status_class = "status-good";
$status_text  = "Ученик хорошо учится и посещает";

if ($student['rating'] < 20 || $student['attendance'] < 40) {
    $status_class = "status-bad";
    $status_text  = "Ученик подлежит исключению";
} elseif ($student['rating'] < 40 || $student['attendance'] < 60) {
    $status_class = "status-warning";
    $status_text  = "Ученик приближается к исключению";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Профиль ученика</title>
<style>
body { font-family: Arial, sans-serif; background:#eef5ff; margin:20px; color:#03396c; }
.container { max-width:1100px; margin:auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h1,h2 { text-align:center; color:#022b5b; }
.row { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:20px;}
.col { flex:1; min-width:300px; background:#f9fcff; padding:15px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.05);}
.card-title { font-size:18px; font-weight:bold; margin-bottom:10px; color:#1c3f95; border-bottom:2px solid #4a90e2; padding-bottom:5px;}
table { border-collapse:collapse; width:100%; margin:10px 0;}
th,td { border:1px solid #a2c4e1; padding:8px; text-align:center;}
th { background:#1c3f95; color:white; }
tr:nth-child(even){ background:#f0f6ff;}
form { text-align:center; margin:15px 0; }
input[type="date"] { padding:6px; font-size:15px; border:1px solid #ccc; border-radius:6px;}
button { padding:7px 15px; font-size:15px; background:#1c3f95; color:white; border:none; border-radius:6px; cursor:pointer;}
button:hover { background:#4a90e2; }
.badge { display:inline-block; padding:3px 7px; border-radius:5px; font-size:13px; margin:2px; }
.badge-strong { background:#4CAF50; color:white; }
.badge-weak { background:#E74C3C; color:white; }
.status-good, .status-warning, .status-bad {
  padding: 10px;
  border-radius: 6px;
  text-align: center;
  font-weight: bold;
  margin-top: 10px;
}
.status-good { background:#2ecc71; color:white; }
.status-warning { background:#e67e22; color:white; }
.status-bad { background:#e74c3c; color:white; }
</style>
</head>
<body>
     <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
<div class="container">

<h1>Профиль ученика</h1>

<div class="row">

  <div class="col">
    <div class="card-title">Личные данные</div>
    <p><b>ФИО:</b> <?= $student['surname']." ".$student['name']." ".$student['patronymic'] ?><br>
    <b>Класс:</b> <?= $student['grade'].$student['class'] ?><br>
    <b>Дата рождения:</b> <?= $student['birth'] ?><br>
    <b>Пол:</b> <?= $student['gender']=="M" ? "Мужской" : "Женский" ?><br>
    <b>Посещаемость:</b> <?= $student['attendance'] ?> %<br>
    <b>Средняя оценка:</b> <?= $student['avg_grade'] ?><br>
    <b>Рейтинг:</b> <?= $student['rating'] ?></p>

    <div class="<?= $status_class ?>"><?= $status_text ?></div>
  </div>

  <div class="col">
    <div class="card-title">Анализ предметов</div>
    <p><b>Сильные предметы:</b><br>
      <?php if($strong): foreach($strong as $s): ?>
        <span class="badge badge-strong"><?= $s ?></span>
      <?php endforeach; else: ?>Нет сильных предметов<?php endif; ?>
    </p>
    <p><b>Слабые предметы:</b><br>
      <?php if($weak): foreach($weak as $w): ?>
        <span class="badge badge-weak"><?= $w ?></span>
      <?php endforeach; else: ?>Нет слабых предметов<?php endif; ?>
    </p>
  </div>
</div>

<h2>Оценки</h2>
<form method="get">
    <input type="hidden" name="id" value="<?= $student_id ?>">
    <input type="date" name="date" value="<?= $selected_date ?>">
    <button type="submit">Показать</button>
</form>

<table>
<tr><th>№</th><th>Предмет</th><th>Учитель</th><th>Оценка</th></tr>
<?php if ($grades_result->num_rows > 0): ?>
    <?php $i=1; while($g = $grades_result->fetch_assoc()): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($g['subject']) ?></td>
            <td><?= htmlspecialchars($g['teacher']) ?></td>
            <td><?= $g['grade_value'] ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr><td colspan="4">Не был на уроках</td></tr>
<?php endif; ?>
</table>


<h2>Расписание класса <?= $student['grade'].$student['class'] ?></h2>
<div class="row">
<?php foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day): ?>
    <div class="col">
        <?php
        $d = '';
        if($day == 'Monday')$d = 'Понедельник';
        if($day == 'Tuesday')$d = 'Вторник';
        if($day == 'Wednesday')$d = 'Среда';
        if($day == 'Thursday')$d = 'Четверг';
        if($day == 'Friday')$d = 'Пятница';
        if($day == 'Saturday')$d = 'Суббота';
        ?>
    <div class="card-title"><?= $d ?></div>
    <table>
      <tr><th>№</th><th>Предмет</th><th>Каб.</th></tr>
      <?php if(isset($schedule[$day])): ?>
          <?php foreach($schedule[$day] as $lesson): ?>
              <tr>
                  <td><?= $lesson['lesson_number'] ?></td>
                  <td><?= htmlspecialchars($lesson['subject']) ?></td>
                  <td><?= htmlspecialchars($lesson['room']) ?></td>
              </tr>
          <?php endforeach; ?>
      <?php else: ?>
          <tr><td colspan="3">Нет уроков</td></tr>
      <?php endif; ?>
    </table>
  </div>
<?php endforeach; ?>
</div>

</div>
</body>
</html>
