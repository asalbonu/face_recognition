<?php
$host = "localhost";
$user = "v98577nf_face";
$pass = "v98577nf_facee";
$db   = "v98577nf_face"; 
    session_start();
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);

function GetTime ($datetime) {
  $tm = '';
  $sp = 0;
  for ($i = 0; $i < strlen($datetime); $i++) {
    if ($datetime[$i] == ' ') {
      $sp = 1;
    }else if ($sp == 1) {
      $tm .= $datetime[$i];
    }
  }
  return $tm;
}

$sql = "
    SELECT 
        u.id,
        u.name,
        u.surname,
        u.grade,
        u.class,
        ROUND(SUM(v.visit='visited') / COUNT(v.visit) * 100, 2) AS attendance
    FROM users u
    JOIN visits v ON u.id = v.user_id
    GROUP BY u.id
    ORDER BY attendance DESC
    LIMIT 10
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <title>РИТМ - Распознавание и Интеллектуальный Технологический Мониторинг</title>
  <link rel="stylesheet" href="css/style_index.css">
  <style>
     h1 {
    text-align: center;
    margin-bottom: 30px;
  }

  .cards-container {
    display: flex;
    flex-wrap: wrap;     
    gap: 20px;            
    justify-content: center;
  }

  .card {
    display: flex;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    width: 60%;            
    max-width: 400px;      
    min-width: 300px;       
    height: 200px;
    transition: transform 0.3s;
  }

  .card:hover {
    transform: translateY(-5px);
  }

  .card img {
    width: 200px;
    height: 20 0px;
    object-fit: cover;
  }

  .card-content {
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .card-content h3 {
    margin: 0 0 12px 0;
    font-size: 20px;
    color: #333;
  }

  .card-content p {
    margin: 0;
    font-size: 16px;
    color: #666;
  }

  @media (max-width: 800px) {
    .card {
      width: 100%; 
    }
  }
  </style>
</head>
<body>
  <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
  <div class="content">
 <div class="poster">
  <div class="poster-overlay"></div>
  <div class="poster-content">
    <h1 style="color: white;"><?=$texts[$lang]['text1']?></h1>
    <div id="poster-quote-container">
      <i class="quote-icon">📊</i>
      <p id="poster-quote">Следи за посещаемостью, успеваемостью и статистикой учеников в реальном времени.</p>
    </div>
  </div>
</div>

 <?php 
   $__host = "localhost";
$__login = "v98577nf_face";
$__password = "v98577nf_facee";
$__database   = "v98577nf_face"; 

   $mysql = new mysqli($__host, $__login, $__password, $__database);

   $in_time = 0;
   $late = 0;
    if(isset($_POST['grade'])){
      $grade = $_POST['grade'];
      $date = $_POST['date'];
      $class = $grade[strlen($grade) - 1];
    }
    else{
      $grade = "5A";
      $date = date('Y-m-d');
      $class = $grade[strlen($grade) - 1];
    }
   $res = $mysql->query("
       SELECT 
    o.visit_id AS id,
    o.user_id,
    o.visit,
    o.time,
    u.id AS user_id_actual,
    u.surname,
    u.name AS user_name,
    u.patronymic,
    u.gender,
    u.birth,
    u.grade,
    u.class
FROM visits o
LEFT JOIN users u ON o.user_id = u.id
WHERE CAST(o.time AS DATE) = '$date'
  AND u.grade = '$grade'
  AND u.class = '$class'
ORDER BY o.time DESC;

    ");

  ?>  
<h1><?=$texts[$lang]['text2']?></h1>
  
   <form action="index.php" method = "POST">
    <span><?=$texts[$lang]['text3']?></span>
   <select name = "grade">
   <?php
   if(!empty($_POST['grade'])){
    ?>
    <option value="<?=$_POST['grade']?>" selected><?=$_POST['grade']?></option>
    <?php
   }
   else{
   ?>
   <option value="5A" selected>5A</option>
   <?php }
   $a = ['A','B','C','D'];
   for($i = 5;$i <= 11;$i++){
    for($j = 0; $j < 4;$j++){
    ?>
    <option value="<?=$i.$a[$j]?>"><?=$i.$a[$j]?></option>
    <?php
    }
   }
   ?>

   </select>  
   <span><?=$texts[$lang]['text4']?></span>
   <?php
   if(!empty($_POST['date'])){
    ?>
    <input type="date" name = "date" value="<?=$_POST['date']?>">
    <?php
   }
   else{
    $d = date('Y-m-d');
   ?>
   <input type="date" name = "date" value="<?=$d?>">
   <?php }
   ?>

   </select> 
   <input type = "submit"style="
      margin: 10px auto 0 auto;
      padding: 10px 25px;
      font-size: 15px;
      font-weight: 100;
      color: white;
      background: linear-gradient(135deg, #3498db, #2980b9);
      border: none;
      border-radius: 40px;
      cursor: pointer;
      box-shadow: 0 6px 15px rgba(41, 128, 185, 0.4);
      transition: background 0.3s ease, transform 0.2s ease;"></form>
   
  <table id="attendanceTable" aria-label="Таблица учёта посещаемости">
    <thead>
      <tr>
        <th><?=$texts[$lang]['text5']?></th>
        <th><?=$texts[$lang]['text6']?></th>
        <th><?=$texts[$lang]['text7']?></th>
        <th><?=$texts[$lang]['text8']?></th>
        <th><?=$texts[$lang]['text9']?></th>
        <th><?=$texts[$lang]['text10']?></th>
      </tr>
    </thead>
    <tbody>
      <?php
    $limit = 10;
     for ($i = 1; $i <= $res->num_rows; $i++) {
        $row = $res->fetch_assoc();
          $time = GetTime($row['time']);
        $is_late = 0;
        if ($time > '08:00:00') {
          $late++;
          $is_late = 1;
        }else {
          $in_time++;
        }
        $check_1 = 'checked';
        $check_2 = '';
        if ($is_late == 1) {
          $check_1 = '';
          $check_2 = 'checked';
        }
        $user_name = $row['surname'].' '.$row['user_name'].' '.$row['patronymic'];
        if ($row['user_id'] == 0) {
          $user_name = 'Unknown';
        }
        $extraClass = ($i > $limit) ? "class='extra-row' style=\"display:none;\"" : "";
        echo '<tr '.$extraClass.'>
        <td>'.$user_name.'</td>
        <td>'.$row['grade'].$row['class'].'</td>
        <td><input type="time" name="arrival_'.$i.'" value="'.$time.'" /></td>
        <td><input type="radio" name="status_'.$i.'" value="Присутствует"'.$check_1.'></td>
        <td><input type="radio" name="status_'.$i.'" value="Отсутствует"></td>
        <td><input type="radio" name="status_'.$i.'" value="Опоздал"'.$check_2.'></td>
        </tr>';
        }
      ?>
    </tbody>
  </table>
  <div style="text-align:center; margin-top:20px;">
    <button type="button" id="showAllBtn"><?=$texts[$lang]['text11']?></button>
    <button type="button" id="collapseBtn" style="display:none;"><?=$texts[$lang]['text12']?></button>
  </div>
  
  <button onclick="submitAttendance()"><?=$texts[$lang]['text13']?></button>

  <div id="result" role="region" aria-live="polite"></div>

  <div id="chartContainer">
    <canvas id="attendanceChart"></canvas>
  </div>
    <h1>🏆<?=$texts[$lang]['text14']?></h1>
  <table class="table">
    <tr class="tr">
      <th class="th"><?=$texts[$lang]['text15']?></th>
      <th class="th"><?=$texts[$lang]['text16']?></th>
      <th class="th"><?=$texts[$lang]['text17']?></th>
      <th class="th"><?=$texts[$lang]['text18']?></th>
    </tr>
    <?php
    if ($result && $result->num_rows > 0) {
        $rank = 1;
        while($row = $result->fetch_assoc()) {
            $fio = $row["surname"]." ".$row["name"];
            $class = $row["grade"].$row["class"];
            $att = $row["attendance"];
            $badge = "";
            if ($rank == 1) $badge = "<span class='badge gold'>🥇</span>";
            elseif ($rank == 2) $badge = "<span class='badge silver'>🥈</span>";
            elseif ($rank == 3) $badge = "<span class='badge bronze'>🥉</span>";
            else $badge = "<span class='badge good'>✔</span>";

            echo "<tr class='tr'>
                    <td class='td'>$rank $badge</td>
                    <td class='td'>$fio</td>
                    <td class='td'>$class</td>
                    <td class='td'>{$att}%</td>
                  </tr>";
            $rank++;
        }
    } else {
        echo "<tr class='tr'><td colspan='4' class='td'>Нет данных</td></tr>";
    }
    ?>
  </table>
  </div>
  <h1><?=$texts[$lang]['text19']?></h1>

  <div class="news-container">
    <div class="news-card">
      <img src="img/9.jpg" alt="Школьные олимпиады">
      <h3><?=$texts[$lang]['text20']?></h3>
      <p><?=$texts[$lang]['text21']?></p>
        <p><?=$texts[$lang]['text22']?></p>
        <p><?=$texts[$lang]['text23']?></p>
        <p><?=$texts[$lang]['text24']?></p>
      
      <span class="news-date">02.09.2025</span>
    </div>

    <div class="news-card">
      <img src="img/8.jpg" alt="Международные олимпиады">
      <h3><?=$texts[$lang]['text25']?></h3>
      <p><?=$texts[$lang]['text26']?></p>
      <p><?=$texts[$lang]['text27']?></p>
      <p><?=$texts[$lang]['text28']?></p>
      <p><?=$texts[$lang]['text29']?></p>
      <span class="news-date">05.09.2025</span>
    </div>

    <div class="news-card">
      <img src="img/7.jpg" alt="Спортивные соревнования">
      <h3><?=$texts[$lang]['t30']?></h3>
      <p><?=$texts[$lang]['t31']?></p>
      <span class="news-date">09.09.2025</span>
    </div>
  </div>
  
<h1><?=$texts[$lang]['t1']?></h1>

<div class="cards-container">
  <div class="card">
    <img src="img/10.jfif" alt="Музыкальный кружок">
    <div class="card-content">
      <h3><?=$texts[$lang]['t2']?></h3>
      <p><?=$texts[$lang]['t3']?></p>
      <p><?=$texts[$lang]['t4']?></p>
      <p><?=$texts[$lang]['t5']?></p>
      <a href="chess.php"><?=$texts[$lang]['t6']?></a>
    </div>
  </div>

  <div class="card">
    <img src="img/11.jfif" alt="Художественный кружок">
    <div class="card-content">
      <h3><?=$texts[$lang]['t7']?></h3>
      <p><?=$texts[$lang]['t8']?></p>
      <p><?=$texts[$lang]['t9']?></p>
      <p><?=$texts[$lang]['t10']?></p>
      <a href="prog.php"><?=$texts[$lang]['t11']?></a>
    </div>
  </div>

  <div class="card">
    <img src="img/12.jfif" alt="Спортивный кружок">
    <div class="card-content">
      <h3><?=$texts[$lang]['t12']?></h3>
      <p><?=$texts[$lang]['t13']?></p>
      <p><?=$texts[$lang]['t14']?></p>
      <p><?=$texts[$lang]['t15']?></p>
      <a href="economy.php"><?=$texts[$lang]['t16']?></a>
    </div>
  </div>

  <div class="card">
    <img src="img/13.jfif" alt="Научный кружок">
    <div class="card-content">
      <h3><?=$texts[$lang]['t17']?></h3>
      <p><?=$texts[$lang]['t18']?></p>
      <p><?=$texts[$lang]['t19']?></p>
      <p><?=$texts[$lang]['t20']?></p>
      <a href="chemistry.php"><?=$texts[$lang]['t21']?></a>
    </div>
  </div>
</div>
    <script>
const slides = [
  {
    text: "Следи за посещаемостью, успеваемостью и статистикой учеников в реальном времени.",
    icon: "📊",
    bg: "url('img/2.jpg')",
    
  },
  {
    text: "Присутствует интуитивный интерфейс, графики и аналитика для каждого класса.",
    icon: "📈",
    bg: "url('img/3.jpg')",
  
  },
  {
    text: "Все данные — аккуратно в одном месте!",
    icon: "🗂️",
    bg: "url('img/4.jpg')",

  },
  {
    text: "Управляй классами и журналами легко и быстро.",
    icon: "📝",
    bg: "url('img/5.jpg')",
    type: "jpg"
  },
  {
    text: "Анализ успеваемости и посещаемости — прямо на главной странице.",
    icon: "🎯",
    bg: "url('img/6.jpg')",
    type: "jpg"
  }
];

let index = 0;
const quoteElement = document.getElementById("poster-quote");
const iconElement = document.querySelector(".quote-icon");
const posterElement = document.querySelector(".poster");

function showNextSlide() {
  quoteElement.style.opacity = 0;
  quoteElement.style.transform = "translateY(-20px)";
  iconElement.style.transform = "scale(0.5)";

  setTimeout(() => {
    index = (index + 1) % slides.length;
    quoteElement.innerText = slides[index].text;
    iconElement.innerText = slides[index].icon;
    posterElement.style.backgroundImage = slides[index].bg;

    quoteElement.style.opacity = 1;
    quoteElement.style.transform = "translateY(0)";
    iconElement.style.transform = "scale(1)";
  }, 1000);
}

posterElement.style.backgroundImage = slides[0].bg;
setInterval(showNextSlide, 6000);
</script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    let attendanceChart;

    const limit = 10;
    const showAllBtn = document.getElementById("showAllBtn");
    const collapseBtn = document.getElementById("collapseBtn");

    showAllBtn.addEventListener("click", function() {
      document.querySelectorAll(".extra-row").forEach(tr => tr.style.display = "");
      showAllBtn.style.display = "none";
      collapseBtn.style.display = "inline-block";
    });

    collapseBtn.addEventListener("click", function() {
      let i = 0;
      document.querySelectorAll("#attendanceTable tbody tr").forEach(tr => {
        i++;
        if (i > limit) tr.style.display = "none";
      });
      collapseBtn.style.display = "none";
      showAllBtn.style.display = "inline-block";
    });

    function submitAttendance() {
      const table = document.getElementById('attendanceTable');
      const rows = table.tBodies[0].rows;
      let report = 'Отчёт по посещаемости:\n\n';
      let counts = {
        'Присутствует': 0,
        'Отсутствует': 0,
        'Опоздал': 0
      };

      for (let i = 0; i < rows.length; i++) {
        const studentName = rows[i].cells[0].innerText;
        const studentClass = rows[i].cells[1].innerText;
        const arrivalTime = rows[i].querySelector('input[type="time"]').value;
        const radios = rows[i].querySelectorAll('input[type="radio"]');
        let status = '';
        radios.forEach(radio => {
          if (radio.checked) status = radio.value;
        });
        report += `${studentName} (класс ${studentClass}), время прихода: ${arrivalTime}, статус: ${status}\n`;
        if (counts[status] !== undefined) {
          counts[status]++;
        }
      }

      document.getElementById('result').innerText = report;

      updateChart(counts);
    }

    function updateChart(counts) {
      const data = {
        labels: ['Присутствует', 'Отсутствует', 'Опоздал'],
        datasets: [{
          label: 'Количество учеников',
          data: [counts['Присутствует'], counts['Отсутствует'], counts['Опоздал']],
          backgroundColor: [
            'rgba(46, 204, 113, 0.7)', 
            'rgba(231, 76, 60, 0.7)', 
            'rgba(241, 196, 15, 0.7)'  
          ],
          borderColor: [
            'rgba(46, 204, 113, 1)',
            'rgba(231, 76, 60, 1)',
            'rgba(241, 196, 15, 1)'
          ],
          borderWidth: 1,
          hoverOffset: 20
        }]
      };

      const options = {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              font: {
                size: 14,
                weight: '600'
              }
            }
          },
          tooltip: {
            enabled: true
          }
        }
      };

      if (attendanceChart) {
        attendanceChart.data = data;
        attendanceChart.options = options;
        attendanceChart.update();
      } else {
        attendanceChart = new Chart(ctx, {
          type: 'doughnut',
          data: data,
          options: options
        });
      }
    }
    updateChart({ 'Присутствует': <?php echo $in_time; ?>, 'Отсутствует': 0, 'Опоздал': <?php echo $late; ?> });
  </script>
</body>
</html>
