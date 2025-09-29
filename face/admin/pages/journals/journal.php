<?php

$host = "localhost";
$user = "v98577nf_face";
$pass = "v98577nf_facee";
$db   = "v98577nf_face"; 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { 
    die('Ошибка подключения к БД: '. $conn->connect_error);
}
function gp($name, $def) {
    if (isset($_POST[$name])) return $_POST[$name];
    if (isset($_GET[$name])) return $_GET[$name];
    return $def;
}

// --- Параметры фильтра ---
$grade   = (int) gp('grade', 1);
$class   = gp('class', 'A');
$subject = gp('subject', 'Русский язык');
$quarter = (int) gp('quarter', 1);
$year    = (int) gp('year', date("Y"));

// --- Четверти ---
$quarters = [
  1 => ["start" => "$year-09-01", "end" => "$year-10-31"],
  2 => ["start" => "$year-11-11", "end" => "$year-12-31"],
  3 => ["start" => "$year-01-11", "end" => "$year-03-21"],
  4 => ["start" => "$year-06-01", "end" => "$year-06-30"]
];
if (!isset($quarters[$quarter])) $quarter = 1;
$startDate = $quarters[$quarter]['start'];
$endDate   = $quarters[$quarter]['end'];

// --- Сохранение оценок ---
if (isset($_POST['grades']) && is_array($_POST['grades'])) {
    $selStmt = $conn->prepare("SELECT id FROM grades WHERE user_id=? AND subject=? AND grade_date=? LIMIT 1");
    $insStmt = $conn->prepare("INSERT INTO grades (user_id, subject, grade_value, grade_date) VALUES (?, ?, ?, ?)");
    $updStmt = $conn->prepare("UPDATE grades SET grade_value=? WHERE id=?");

    $sStmt = $conn->prepare("SELECT id FROM users WHERE grade=? AND class=?");
    $sStmt->bind_param("is", $grade, $class);
    $sStmt->execute();
    $res = $sStmt->get_result();
    $studentIds = [];
    while ($r = $res->fetch_assoc()) $studentIds[] = (int)$r['id'];
    $sStmt->close();

    $visitsData = [];
    if ($studentIds) {
        $in = implode(',', $studentIds); // безопасно, только числа
        $vsql = "SELECT user_id, DATE(`time`) as day, visit FROM visits WHERE DATE(`time`) BETWEEN '$startDate' AND '$endDate' AND user_id IN ($in)";
        $vres = $conn->query($vsql);
        while ($vr = $vres->fetch_assoc()) {
            $visitsData[(int)$vr['user_id']][$vr['day']] = $vr['visit'];
        }
    }

    foreach ($_POST['grades'] as $uidStr => $datesArr) {
        $user_id = (int)$uidStr;
        if (!in_array($user_id, $studentIds)) continue;
        if (!is_array($datesArr)) continue;
        foreach ($datesArr as $date => $markRaw) {
            $date = trim($date);
            $isAbsent = isset($visitsData[$user_id][$date]) && mb_strtolower($visitsData[$user_id][$date]) === 'did not visit';
            $mark = $isAbsent ? 'н/б' : trim($markRaw);
            if ($mark === '') continue;

             $user_id_esc = (int)$user_id;
        $subject_esc = $conn->real_escape_string($subject);
        $date_esc = $conn->real_escape_string($date);
        $mark_esc = $conn->real_escape_string($mark);

        // Проверяем, есть ли уже запись
        $check_sql = "SELECT id FROM grades WHERE user_id=$user_id_esc AND subject='$subject_esc' AND grade_date='$date_esc' LIMIT 1";
        $res = $conn->query($check_sql);

        if ($row = $res->fetch_assoc()) {
            $grade_id = (int)$row['id'];
            $update_sql = "UPDATE grades SET grade_value='$mark_esc' WHERE id=$grade_id";
            $conn->query($update_sql);
        } else {
            $insert_sql = "INSERT INTO grades (user_id, subject, grade_value, grade_date) 
                           VALUES ($user_id_esc, '$subject_esc', '$mark_esc', '$date_esc')";
            $conn->query($insert_sql);
        }
    }
    }

    $selStmt->close();
    $insStmt->close();
    $updStmt->close();

    $qs = http_build_query([
        'grade' => $grade, 'class' => $class, 'subject' => $subject, 'quarter' => $quarter, 'year' => $year, 'saved' => 1
    ]);
    $i = $_SERVER['PHP_SELF'];
    echo "<script>window.location.href='$i?page=8&$qs';</script>";
    exit;
}

// --- Получаем учеников ---
$stuStmt = $conn->prepare("SELECT id, surname, name FROM users WHERE grade=? AND class=? ORDER BY surname, name");
$stuStmt->bind_param("is", $grade, $class);
$stuStmt->execute();
$sres = $stuStmt->get_result();
$students = [];
$studentIds = [];
while ($r = $sres->fetch_assoc()) {
    $students[] = $r;
    $studentIds[] = (int)$r['id'];
}
$stuStmt->close();

// --- Даты по месяцу ---
$startDT = new DateTime($startDate);
$endDT = new DateTime($endDate);
$endDT->modify('+1 day');
$period = new DatePeriod($startDT, new DateInterval('P1D'), $endDT);

$daysByMonth = [];
$allDates = [];
foreach ($period as $d) {
    $allDates[] = $d;
    $m = (int)$d->format('n');
    $daysByMonth[$m][] = $d;
}

$russianMonths = [1=>'Январь',2=>'Февраль',3=>'Март',4=>'Апрель',5=>'Май',6=>'Июнь',7=>'Июль',8=>'Август',9=>'Сентябрь',10=>'Октябрь',11=>'Ноябрь',12=>'Декабрь'];

// --- Подгружаем оценки ---
$existingGrades = [];
if ($studentIds) {
    $in = implode(',', $studentIds);
    $gsql = "SELECT user_id, grade_date, grade_value FROM grades WHERE subject = ? AND grade_date BETWEEN ? AND ? AND user_id IN ($in)";
    $gstmt = $conn->prepare($gsql);
    $gstmt->bind_param("sss", $subject, $startDate, $endDate);
    $gstmt->execute();
    $gres = $gstmt->get_result();
    while ($gr = $gres->fetch_assoc()) {
        $existingGrades[(int)$gr['user_id']][$gr['grade_date']] = $gr['grade_value'];
    }
    $gstmt->close();
}

// --- Подгружаем посещаемость ---
$visits = [];
if ($studentIds) {
    $in = implode(',', $studentIds);
    $vsql = "SELECT user_id, DATE(`time`) as day, visit FROM visits WHERE DATE(`time`) BETWEEN '$startDate' AND '$endDate' AND user_id IN ($in)";
    $vres = $conn->query($vsql);
    while ($vr = $vres->fetch_assoc()) {
        $visits[(int)$vr['user_id']][$vr['day']] = $vr['visit'];
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Журнал - Четверть <?=$quarter?> <?=$year?></title>
<style>
.filter { margin-bottom: 10px; padding: 8px; background: #f7f7f7; border: 1px solid #ddd; display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
.filter select, .filter input { padding:4px; }

.table-wrap { overflow-x:auto; max-width:100%; border:1px solid #ccc; margin-top:20px; }
table { border-collapse: collapse; font-size: 12px; min-width: 800px; }
th, td { border: 1px solid #ccc; padding: 4px; text-align:center; white-space:nowrap; }
th { background:#f0f0f0; font-weight:600; }
.col-num { width: 40px; min-width:40px; position: sticky; left:0; background:#fff; z-index:5; }
.col-name { width: 220px; min-width:220px; position: sticky; left:40px; background:#fff; z-index:5; text-align:left; padding-left:8px; }
.col-avg { width:100px; min-width:100px; position: sticky; right:100px; background:#fff; z-index:5; }
.col-final { width:100px; min-width:100px; position: sticky; right:0; background:#fff; z-index:6; }
.month-th { font-size:13px; padding:6px 8px; }
input.grade-input { width:30px; height:24px; text-align:center; font-size:12px; }
.msg { color: green; margin: 6px 0; }

</style>
</head>
<body>

<h2 align="center">Электронный журнал</h2>

<form method="get" class="filter">
  <input type="hidden" name="page" value="8">
  Класс:
  <select name="grade"><?php for($g=1;$g<=11;$g++): ?><option value="<?=$g?>" <?=$g==$grade?'selected':''?>><?=$g?></option><?php endfor; ?></select>
  Буква:
  <select name="class"><?php foreach(['A','B','C','D'] as $c): ?><option <?=$c==$class?'selected':''?>><?=$c?></option><?php endforeach; ?></select>
  Предмет:
  <select name="subject"><?php foreach(['Русский язык','Математика','История','Физика','Забони модарӣ'] as $s): ?><option <?=$s==$subject?'selected':''?>><?=$s?></option><?php endforeach; ?></select>
  Четверть:
  <select name="quarter"><option value="1" <?=$quarter==1?'selected':''?>>I</option><option value="2" <?=$quarter==2?'selected':''?>>II</option><option value="3" <?=$quarter==3?'selected':''?>>III</option><option value="4" <?=$quarter==4?'selected':''?>>IV</option></select>
  Год: <input type="number" name="year" value="<?=$year?>" style="width:80px">
  <button type="submit" class="btn btn-secondary">Показать</button>
  <?php if (isset($_GET['saved'])): ?><span style="color:green">✔ Оценки сохранены</span><?php endif; ?>
</form>

<form method="post" action="index.php?page=8">
  <input type="hidden" name="grade" value="<?=$grade?>">
  <input type="hidden" name="class" value="<?=$class?>">
  <input type="hidden" name="subject" value="<?=$subject?>">
  <input type="hidden" name="quarter" value="<?=$quarter?>">
  <input type="hidden" name="year" value="<?=$year?>">

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th class="col-num" rowspan="2">№</th>
          <th class="col-name" rowspan="2">Фамилия Имя</th>
          <?php foreach ($daysByMonth as $m => $dates): ?><th class="month-th" colspan="<?=count($dates)?>"><?= $russianMonths[$m] ?></th><?php endforeach; ?>
          <th class="col-avg" rowspan="2">Средний балл</th>
          <th class="col-final" rowspan="2">Итог</th>
        </tr>
        <tr>
          <?php foreach ($daysByMonth as $m => $dates): ?><?php foreach ($dates as $d): ?><th><?= $d->format('d') ?></th><?php endforeach; ?><?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; foreach ($students as $st): 
            $uid = (int)$st['id'];
            $sum = 0; $cnt = 0;
            foreach ($allDates as $d) {
                $ds = $d->format('Y-m-d');
                $val = $existingGrades[$uid][$ds] ?? null;
                if ($val !== null && is_numeric(str_replace(',', '.', $val))) { $sum += (float)str_replace(',', '.', $val); $cnt++; }
            }
            $avg = $cnt ? round($sum / $cnt, 1) : '';
            $final = $avg !== '' ? (string)round($avg) : '';
        ?>
        <tr>
          <td class="col-num"><?= $i++ ?></td>
          <td class="col-name"><?= htmlspecialchars($st['surname'].' '.$st['name']) ?></td>
          <?php foreach ($allDates as $d):
              $ds = $d->format('Y-m-d');
              $isAbsent = isset($visits[$uid][$ds]) && mb_strtolower($visits[$uid][$ds]) == 'did not visit';
              $existing = $existingGrades[$uid][$ds] ?? null;
              if ($existing !== null) {
                  $value = $existing;
                  $readonly = '';
                  if (mb_strtolower($existing) === 'н/б') $readonly = 'readonly';
              } elseif ($isAbsent) {
                  $value = 'н/б';
                  $readonly = 'readonly';
              } else {
                  $value = '';
                  $readonly = '';
              }
          ?>
            <td>
              <input class="grade-input" <?= $readonly ?> type="text"
                     name="grades[<?= $uid ?>][<?= $ds ?>]"
                     <?php
                     if($value == 'н/б') echo 'value="н/б">';
                     else echo "value='$value' >";
                     ?>
                    
            </td>
          <?php endforeach; ?>
          <td class="col-avg"><?= $avg !== '' ? $avg : '' ?></td>
          <td class="col-final"><?= $final !== '' ? $final : '' ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <p align="center"><button type="submit" class="btn btn-success">Сохранить оценки</button></p>
</form>

</body>
</html>
