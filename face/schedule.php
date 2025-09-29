<?php
$host = "localhost";
$user = "v98577nf_face";
$pass = "v98577nf_facee";
$db   = "v98577nf_face"; 
session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ru';
require_once("1.php");
$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);
$grade = isset($_GET['grade']) ? intval($_GET['grade']) : 10;
$class = isset($_GET['class']) ? $_GET['class'] : 'A';
$result = mysqli_query($conn,"
    SELECT day_of_week, lesson_number, subject, room
    FROM schedule
    WHERE grade = $grade AND class = '$class'
    ORDER BY FIELD(day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'), lesson_number
");
$schedule = [];
while($row = mysqli_fetch_assoc($result)) {
    $schedule[$row['day_of_week']][] = $row;
}

$conn->close();
date_default_timezone_set("Asia/Dushanbe"); 
$year_start = 2025;
$year_end = 2026;
$school_year = "$year_start / $year_end";
$schedule1 = [
    ["08:00", "08:45", "1 урок"],
    ["08:45", "08:50", "Перемена"],
    ["08:50", "09:35", "2 урок"],
    ["09:35", "08:40", "Перемена"],
    ["09:40", "10:25", "3 урок"],
    ["10:25", "10:35", "Перемена"],
    ["10:35", "11:20", "4 урок"],
    ["11:20", "11:25", "Перемена"],
    ["11:25", "12:10", "5 урок"],
     ["12:10", "12:15", "Перемена"],
    ["12:15", "13:00", "6 урок"]
];
$schedule2 = [
    ["13:05", "13:50", "1 урок"],
    ["13:50", "13:55", "Перемена"],
    ["13:55", "14:40", "2 урок"],
    ["14:40", "14:45", "Перемена"],
    ["14:45", "15:30", "3 урок"],
    ["15:30", "15:45", "Перемена"],
    ["15:45", "16:30", "4 урок"],
    ["16:35", "16:40", "Перемена"],
    ["16:45", "17:30", "5 урок"],
     ["17:30", "17:35", "Перемена"],
    ["17:35", "18:20", "6 урок"]
];
$now = date("H:i");
$current = "Вне уроков";
foreach ($schedule1 as $item) {
    list($start, $end, $label) = $item;
    if ($now >= $start && $now <= $end) {
        $current = $label;
        break;
    }
}
if($current == "Вне уроков"){
    foreach ($schedule2 as $item) {
    list($start, $end, $label) = $item;
    if ($now >= $start && $now <= $end) {
        $current = $label;
        break;
    }
}
}$shift = (date("H") < 13) ? "1 смена" : "2 смена";
if($current == "Вне уроков"){
    $shift = "Уроки закончились";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Расписание класса</title>
<style>
    
.row { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:20px;}
.col { flex:1; min-width:300px; background:#f9fcff; padding:15px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.05);}
.card-title { font-size:18px; font-weight:bold; margin-bottom:10px; color:#1c3f95; border-bottom:2px solid #4a90e2; padding-bottom:5px;}
table { border-collapse:collapse; width:100%; margin:10px 0;}
th,td { border:1px solid #a2c4e1; padding:8px; text-align:center;}
th { background:#1c3f95; color:white; }
tr:nth-child(even){ background:#f0f6ff;}
   .select-label {
    display: inline-block;
    font-weight: 600;           
    font-size: 16px;             
    margin-right: 10px;          
    color: #2c3e50;            
    vertical-align: middle;     
}
input,select[name="grade"] {
    padding: 6px 12px;
    font-size: 15px;
    border: 1px solid #2980b9;
    border-radius: 5px;
    background-color: #f0f4f8;
    color: #2c3e50;
    cursor: pointer;
    transition: all 0.3s ease;
}

input,select[name="grade"]:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 5px rgba(41, 128, 185, 0.5);
}
   .select-label {
    display: inline-block;
    font-weight: 600;           
    font-size: 20px;             
    margin-right: 10px;          
    color: #2c3e50;            
    vertical-align: middle;  

}
input,select[name="grade"],select[name="class"] {
    padding: 6px 12px;
    font-size: 15px;
    margin-left: 5px;
     margin-right: 5px;
    border: 1px solid #2980b9;
    border-radius: 5px;
    background-color: #f0f4f8;
    color: #2c3e50;
    cursor: pointer;
    transition: all 0.3s ease;
}

input,select[name="grade"],select[name="class"]:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 5px rgba(41, 128, 185, 0.5);
}
 h1 {
    text-align: center;
    margin-bottom: 30px;
  }
</style>
</head>
<body>
  <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
   <h1>Расписание класса <?= htmlspecialchars($grade . $class) ?></h1>
<form method="get" style="display: flex; justify-content: center; margin: 10px;">
    <label for="" class="select-label">Класс: </label> 
    <select name="grade">
        <?php for($g=5;$g<=11;$g++): ?>
            <option value="<?= $g ?>" <?= $g==$grade?'selected':'' ?>><?= $g ?></option>
        <?php endfor; ?>
    </select>
    <select name="class">
        <?php foreach(['A','B','C','D','G'] as $c): ?>
            <option value="<?= $c ?>" <?= $c==$class?'selected':'' ?>><?= $c ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Показать</button>
</form>
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
