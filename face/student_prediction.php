<?php
function FileRead($file_path) {
    if (!file_exists($file_path)) {
        return false;
    }
    return file_get_contents($file_path);
}

$python_path = "C:\\Users\\User\\AppData\\Local\\Programs\\Python\\Python311\\python.exe";
$ans_file = "C:\\OpenServer\\domains\\face\\ans.txt";  

$host = "localhost";
$user = "v98577nf_face";
$pass = "v98577nf_facee";
$db   = "v98577nf_face"; 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);

$classes = $conn->query("SELECT DISTINCT CONCAT(grade, class) as class_name FROM users ORDER BY grade, class");

$report = "";
$avg_subjects = [];
$good_subjects = [];
$bad_subjects = [];
$overall_avg = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $surname = $conn->real_escape_string($_POST["surname"]);
    $name    = $conn->real_escape_string($_POST["name"]);
    $class   = $conn->real_escape_string($_POST["class"]);

    $sql = "
        SELECT 
            u.id,
            u.surname,
            u.name,
            u.grade,
            u.class,
            g.subject,
            g.grade_value,
            v.visit
        FROM users u
        LEFT JOIN grades g ON u.id = g.user_id
        LEFT JOIN visits v ON u.id = v.user_id
        WHERE u.surname LIKE '%$surname%'
          AND u.name LIKE '%$name%'
          AND CONCAT(u.grade, u.class) = '$class'
    ";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $csv_file = "student_data.csv";
        $fp = fopen($csv_file, "w");
        fputcsv($fp, ["id","surname","name","grade","class","subject","grade_value","visit"]);

        $subject_grades = [];

        while ($row = $result->fetch_assoc()) {
            fputcsv($fp, [
                $row["id"],
                $row["surname"],
                $row["name"],
                $row["grade"],
                $row["class"],
                $row["subject"],
                $row["grade_value"],
                $row["visit"]
            ]);

            if (!empty($row["subject"]) && $row["grade_value"] > 0) {
                $subject_grades[$row["subject"]][] = $row["grade_value"];
            }
        }
        fclose($fp);

        foreach ($subject_grades as $sub => $grades) {
            $avg = round(array_sum($grades) / count($grades), 2);
            $avg_subjects[$sub] = $avg;
            if ($avg >= 7) {
                $good_subjects[$sub] = $avg;
            } else {
                $bad_subjects[$sub] = $avg;
            }
        }

        if (count($avg_subjects) > 0) {
            $overall_avg = round(array_sum($avg_subjects) / count($avg_subjects), 2);
        }

        $cmd = $python_path." predict_student.py ".$csv_file." 2>&1";
        shell_exec($cmd);
        $report = FileRead($ans_file);
    } else {
        $report = "Нет данных по этому ученику.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Прогноз успеваемости</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; }
        .form-box, .result-box { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .good-box { background: #eafbea; border-left: 5px solid #2ecc71; }
        .bad-box { background: #fdecea; border-left: 5px solid #e74c3c; }
        .recommend-box { background: #eaf2fb; border-left: 5px solid #3498db; }
        .overall { background: #fff3cd; border-left: 5px solid #f1c40f; font-size: 18px; padding: 15px; margin-bottom: 20px; }
        select, input, button { padding: 8px; margin-top: 10px; }
        pre { background: #fff; padding: 15px; border-radius: 10px; }
    </style>
</head>
<body>
    <?php require_once("pages/header.php");?>
    <?php require_once("pages/sidebar.php");?>


    <h1>📊 Прогноз успеваемости ученика</h1>
    <div class="form-box">
        <form method="POST">
            <label>Фамилия:</label><br>
            <input type="text" name="surname" required><br>
            <label>Имя:</label><br>
            <input type="text" name="name" required><br>
            <label>Класс:</label><br>
            <select name="class" required>
                <option value="">-- выберите класс --</option>
                <?php while($row = $classes->fetch_assoc()): ?>
                    <option value="<?=$row['class_name']?>"><?=$row['class_name']?></option>
                <?php endwhile; ?>
            </select><br>
            <button type="submit">Показать прогноз</button>
        </form>
    </div>

    <?php if ($report): ?>
        <div class="result-box">
            <h2>📖 Общий прогноз:</h2>
            <pre><?=$report?></pre>
        </div>

        <?php if ($overall_avg > 0): ?>
        <div class="result-box overall">
            📌 Общая успеваемость: <b><?=$overall_avg?></b> / 10
        </div>
        <?php endif; ?>

        <?php if (!empty($good_subjects)): ?>
        <div class="result-box good-box">
            <h2>🌟 Сильные стороны ученика:</h2>
            <ul>
                <?php foreach($good_subjects as $sub => $avg): ?>
                    <li><?=$sub?> — <b><?=$avg?></b></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($bad_subjects)): ?>
        <div class="result-box bad-box">
            <h2>⚠️ Слабые стороны (нуждаются в доработке):</h2>
            <ul>
                <?php foreach($bad_subjects as $sub => $avg): ?>
                    <li><?=$sub?> — <b><?=$avg?></b></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="result-box recommend-box">
            <h2>💡 Рекомендации:</h2>
            <ul>
                <li>Уделить внимание предметам со средним баллом ниже 7.</li>
                <li>Развивать сильные стороны (<?=count($good_subjects)?> предметов уже на хорошем уровне!).</li>
                <li>Следить за регулярным посещением занятий.</li>
                <li>Использовать дополнительные материалы для повышения успеваемости.</li>
            </ul>
        </div>

        <?php if (!empty($avg_subjects)): ?>
        <div class="result-box">
            <h2>📊 Диаграмма средней успеваемости:</h2>
            <canvas id="chart" width="400" height="200"></canvas>
            <script>
            const ctx = document.getElementById('chart');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?=json_encode(array_keys($avg_subjects))?>,
                    datasets: [{
                        label: 'Средний балл по предмету',
                        data: <?=json_encode(array_values($avg_subjects))?>,
                        backgroundColor: 'rgba(46, 204, 113, 0.7)'
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, max: 10 }
                    }
                }
            });
            </script>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
