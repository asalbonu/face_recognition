    <?php
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "face_recognition"; 
session_start();
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);

if(!isset($_POST['ot'])){
    $sql = "
       WITH ranked AS (
        SELECT 
            u.id,
            u.surname,
            u.name,
            u.grade,
            u.class,
            ROUND(SUM(v.visit = 'visited') / COUNT(v.visit) * 100, 2) AS attendance,
            ROUND(AVG(g.grade_value), 2) AS avg_grade,
            ROUND( ( (SUM(v.visit = 'visited') / COUNT(v.visit) * 100) + (AVG(g.grade_value) * 10) ) / 2, 2) AS rating,
            ROW_NUMBER() OVER (ORDER BY ((SUM(v.visit = 'visited') / COUNT(v.visit) * 100) + (AVG(g.grade_value) * 10)) / 2 DESC) AS rank_num
        FROM users u
        LEFT JOIN visits v ON u.id = v.user_id
        LEFT JOIN grades g ON u.id = g.user_id
        GROUP BY u.id
    )
    SELECT *
    FROM ranked
    WHERE rank_num BETWEEN 1 AND 10
    ORDER BY rank_num;
    ";
} else {
    $ot = (int)$_POST['ot'];
    $do = (int)$_POST['do'];
    $sql = "
     WITH ranked AS (
        SELECT 
            u.id,
            u.surname,
            u.name,
            u.grade,
            u.class,
            ROUND(SUM(v.visit = 'visited') / COUNT(v.visit) * 100, 2) AS attendance,
            ROUND(AVG(g.grade_value), 2) AS avg_grade,
            ROUND( ( (SUM(v.visit = 'visited') / COUNT(v.visit) * 100) + (AVG(g.grade_value) * 10) ) / 2, 2) AS rating,
            ROW_NUMBER() OVER (ORDER BY ((SUM(v.visit = 'visited') / COUNT(v.visit) * 100) + (AVG(g.grade_value) * 10)) / 2 DESC) AS rank_num
        FROM users u
        LEFT JOIN visits v ON u.id = v.user_id
        LEFT JOIN grades g ON u.id = g.user_id
        GROUP BY u.id
    )
    SELECT *
    FROM ranked
    WHERE rank_num BETWEEN $ot AND $do
    ORDER BY rank_num;
    ";
}

$result = $conn->query($sql);
date_default_timezone_set("Asia/Dushanbe"); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <title>🏆 Рейтинг учеников</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
    h1 { text-align: center; color: #333; }

    form { text-align: center; margin-bottom: 20px; }
    input[type=number] { padding: 5px; margin: 5px; width: 80px; }
    input[type=submit] { padding: 5px 15px; }

    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background: #007BFF; color: white; }

    .good { background-color: #c8f7c5; }     
    .warn { background-color: #ffe7a0; }     
    .bad  { background-color: #ffb3b3; }     
  </style>
</head>
<body>
    <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
 
  <h1>🏆 Рейтинги учеников по успеваемости</h1>

  <form action="rating_students2.php" method="POST">
    <span>От:</span>
    <input type="number" name="ot" value="<?= !empty($_POST['ot']) ? $_POST['ot'] : 1 ?>">
    <span>До:</span>
    <input type="number" name="do" value="<?= !empty($_POST['do']) ? $_POST['do'] : 10 ?>">
    <input type="submit" value="Показать">
  </form>

  <table>
    <tr>
      <th>Место</th>
      <th>ФИО</th>
      <th>Класс</th>
      <th>Посещаемость (%)</th>
      <th>Средняя оценка</th>
      <th>Рейтинг</th>
      <th>Статус</th>
    </tr>
    <?php
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $rank = $row['rank_num'];
            $fio = $row["surname"]." ".$row["name"];
            $class = $row["grade"].$row["class"];
            $attendance = $row["attendance"] ?? 0;
            $avg_grade = $row["avg_grade"] ?? 0;
            $rating = $row["rating"] ?? 0;

            if ($rating < 20 || $attendance < 50) {
                $status = "<span style='color:red;font-weight:bold'>Будет исключён</span>";
                $row_class = "bad";
            } elseif ($rating < 40 || $attendance < 70) {
                $status = "<span style='color:orange;font-weight:bold'>Приближается к исключению</span>";
                $row_class = "warn";
            } else {
                $status = "<span style='color:green;font-weight:bold'>Хорошо учится</span>";
                $row_class = "good";
            }

            echo "<tr class='$row_class'>
                    <td>$rank</td>
                    <td>$fio</td>
                    <td>$class</td>
                    <td>$attendance%</td>
                    <td>$avg_grade</td>
                    <td>$rating</td>
                    <td>$status</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Нет данных</td></tr>";
    }
    ?>
  </table>
</body>
</html>
