<?php

$mysqli = mysqli_connect("localhost", "v98577nf_face", "v98577nf_facee", "v98577nf_face");
date_default_timezone_set("Asia/Dushanbe"); 
$lessonTimesShift1 = [
    1 => ['08:00', '08:45'],
    2 => ['08:50', '09:35'],
    3 => ['09:40', '10:25'],
    4 => ['10:35', '11:20'],
    5 => ['11:25', '12:10'],
    6 => ['12:15', '13:00'],
];
$lessonTimesShift2 = [
    1 => ['13:10', '13:55'],
    2 => ['14:00', '14:45'],
    3 => ['14:50', '15:35'],
    4 => ['15:45', '16:30'],
    5 => ['16:35', '17:20'],
];

$currentTime = date('H:i');
$today = date('l'); 

$selectedGrade = '';
$selectedClass = '';
$currentLesson = null;
if (isset($_POST['grade_class'])) {
    $gradeClass = $_POST['grade_class'];
    $selectedGrade = intval($gradeClass);
    $selectedClass = substr($gradeClass, strlen($selectedGrade));

    $res = mysqli_query($mysqli,"SELECT * FROM schedule WHERE grade = $selectedGrade AND class = '$selectedClass' AND day_of_week = '$today';");
    if($selectedGrade > 7){
    while ($row = $res->fetch_assoc()) {
        $lessonNum = $row['lesson_number'];
        if (isset($lessonTimesShift1[$lessonNum])) {
            $start = $lessonTimesShift1[$lessonNum][0];
            $end   = $lessonTimesShift1[$lessonNum][1];
            if ($currentTime >= $start && $currentTime <= $end) {
                $currentLesson = $row;
                break;
            }
        }
    }
}
    else{
        $res = mysqli_query($mysqli,"SELECT * FROM schedule WHERE grade = $selectedGrade AND class = '$selectedClass' AND day_of_week = '$today';");
         while ($row = $res->fetch_assoc()) {
        $lessonNum = $row['lesson_number'];
        if (isset($lessonTimesShift2[$lessonNum])) {
            $start = $lessonTimesShift2[$lessonNum][0];
            $end   = $lessonTimesShift2[$lessonNum][1];
            if ($currentTime >= $start && $currentTime <= $end) {
                $currentLesson = $row;
                break;
            }
        }
    }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Текущий урок класса</title>
<link rel="stylesheet" href="css/style_lesson.css">
</head>
<body>
     <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
 
<div class="container content">
    <div class="header">
        <span>📚</span>
        <h1>Текущий урок в классе</h1>
    </div>
    <form method="POST">
        <select name="grade_class">
            <?php
            $resGrades = $mysqli->query("SELECT DISTINCT grade, class FROM schedule ORDER BY grade, class");
            while($row = $resGrades->fetch_assoc()) {
                $val = $row['grade'] . $row['class'];
                $selected = ($row['grade'] == $selectedGrade && $row['class'] == $selectedClass) ? 'selected' : '';
                echo "<option value='{$val}' {$selected}>{$val}</option>";
            }
            ?>
        </select>
        <button type="submit">Показать</button>
    </form>

   <?php if ($selectedGrade && $selectedClass){ ?>
        <div class="timeline">⏰ Сейчас время: <?= $currentTime ?></div>
        <?php if ($currentLesson){ ?>
            <div class="card">
                <h3>Урок для <?= $selectedGrade . $selectedClass ?> класса</h3>
                <p><strong>Предмет:</strong> <?= htmlspecialchars($currentLesson['subject']) ?></p>
                <p><strong>Учитель:</strong> <?= htmlspecialchars($currentLesson['teacher_id']) ?></p>
                <p><strong>Кабинет:</strong> <?= htmlspecialchars($currentLesson['room']) ?></p>
                <p><strong>Номер урока:</strong> <?= htmlspecialchars($currentLesson['lesson_number']) ?></p>
            </div>
        <?php 
        }
        else if($current == "Перемена"){ ?>
            <div class="card break-card">
                <h3>🎉 Перемена!</h3>
                <p>У <?= $selectedGrade . $selectedClass ?> класса сейчас нет урока.</p>
            </div>
        <?php }
        else{?>
            <div class="card break-card">
                <h3>🎉 Уроки окончены!</h3>
                <p>У <?= $selectedGrade . $selectedClass ?> класса уроки подошли к концу.</p>
            </div>
       <?php }
        ?>
    <?php } ?>
</div>
</body>
</html>