<?php
date_default_timezone_set("Asia/Dushanbe");
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ru';
require '1.php';
$year_start = 2025;
$year_end = 2026;
$school_year = "$year_start / $year_end";
$now = date("H:i");
$current = "Вне уроков";


$schedule1 = [
    ["08:00", "08:45", "1 урок"],
    ["08:45", "08:50", "Перемена"],
    ["08:50", "09:35", "2 урок"],
    ["09:35", "09:40", "Перемена"],
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

foreach ($schedule1 as $item) {
    list($start, $end, $label) = $item;
    if ($now >= $start && $now <= $end) {
        $current = $label;
        break;
    }
}
if ($current == "Вне уроков") {
    foreach ($schedule2 as $item) {
        list($start, $end, $label) = $item;
        if ($now >= $start && $now <= $end) {
            $current = $label;
            break;
        }
    }
}
$shift = (date("H") < 13) ? "1 смена" : "2 смена";
if ($current == "Вне уроков") {
    $shift = "Уроки закончились";
}
?>
<style>
   body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      max-width: 1000px;
      margin: 90px;
      margin-top:50px;
      padding: 20px;
      background: #f0f4f8;
      color: #333;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
     .navbar {
  display: flex;
  background: #2980b9;
  padding: 8px 15px;
  justify-content: center;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  height: 40px;
  z-index: 110000;
  position: fixed;
  top: 0;
  width: 100%;
  left: 0;
  margin-bottom: 0;
}

    .navbar a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-size: 20px;
      font-weight: bold;
      padding: 6px 10px;
      border-radius: 4px;
      transition: background 0.3s;
    }
    .navbar a:hover {
      background: #1c5980;
    }
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown a {
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #2980b9;
  min-width: 90px;
  min-height:30px;
  box-shadow: 0 6px 10px rgba(0,0,0,0.2);
  z-index: 900;
  border-radius: 4px;
}

.dropdown-content a {
  color: white;
  padding: 7px 10px;
  text-decoration: none;
  display: block;
  font-size: 14px;
}

.dropdown-content a:hover {
  background-color: #1c5980;
}
.dropdown:hover .dropdown-content {
  display: block;
}
  .info-bar span {
      margin: 0 10px;
    }

.info-bar {
  position: fixed;
  top: 50px;
  left: 0;
  width: 100%;
  background: #e3f2fd;
  color: #333;
  padding: 8px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: 500;
  border-bottom: 1px solid #ccc;
  z-index: 80000;
}
   .navbar-left {
      color: white;
      font-size: 18px;
      font-weight: bold;
   }
   .navbar-center {
      flex-grow: 1;
      text-align: center;
   }
   
   

   .navbar-right img {
      width: 28px;
      height: 20px;
      margin-left: 10px;
      cursor: pointer;
      border: 1px solid #ddd;
   }
   
</style>

<div class="navbar">
  <div class="navbar-left"><?= $texts[$lang]['title'] ?></div>
  <div class="navbar-center">
    <a href="index.php"><?= $texts[$lang]['home'] ?></a>
    <div class="dropdown">
      <a href="rating_student.php"><?= $texts[$lang]['students'] ?></a>
      <div class="dropdown-content">
        <a href="schedule.php"><?= $texts[$lang]['schedule'] ?></a>
        <a href="student_prediction.php"><?= $texts[$lang]['predict'] ?></a>
      </div>
    </div>
    <a href="statistics.php"><?= $texts[$lang]['stats'] ?></a>
  </div>
  <div class="navbar-right">
    <a href="?lang=ru"><img src="img/ru.png" alt="Русский"></a>
    <a href="?lang=tj"><img src="img/tj.png" alt="Тоҷикӣ"></a>
  </div>
</div>

<div class="info-bar">
    <span><?= $texts[$lang]['time'] ?>: <span id="clock"><?=date("H:i:s")?></span></span>
    <span><?= $texts[$lang]['now'] ?>: <?=$current?></span>
    <span><?=$texts[$lang]['shift']?>: <?=$shift?></span>
    <span style="padding-right:13px;"><?=$texts[$lang]['year']?>: <?=$school_year?></span>
</div>
