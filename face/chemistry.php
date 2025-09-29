<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Кружок по химии</title>
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background: #eaf6f6;
      color: #1e2a2f;
      line-height: 1.6;
    }
    header {
      background: linear-gradient(120deg, #006466, #065a60, #144552);
      color: #fff;
      text-align: center;
      padding: 60px 20px;
    }
    header h1 {
      margin: 0;
      font-size: 2.6rem;
      letter-spacing: 1px;
    }
    header p {
      margin-top: 12px;
      font-size: 1.2rem;
      color: #d9f8f8;
    }
    .section {
      max-width: 1100px;
      margin: 50px auto;
      padding: 0 20px;
      display: flex;
      align-items: center;
      gap: 40px;
      flex-wrap: wrap;
    }
    .section img {
      flex: 1;
      max-width: 424px;
      width: 100%;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    }
    .text {
      flex: 2;
      min-width: 280px;
      background: #ffffff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      border-left: 6px solid #06b6d4;
    }
    .text h2 {
      margin-top: 0;
      color: #065a60;
    }
    ul {
      padding-left: 20px;
    }
    ul li {
      margin-bottom: 10px;
    }
    footer {
      text-align: center;
      padding: 20px;
      background: #144552;
      margin-top: 40px;
      color: #d9f8f8;
      border-top: 2px solid #06b6d4;
    }
  </style>
</head>
<body>
  <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
  <header>
    <h1>Кружок по химии</h1>
    <p>Открой тайны науки вместе с нами!</p>
  </header>

  <div class="section">
    <div class="text" style="display:flex;">
      <img src="img/13.jfif" alt="Химия">
      <div style="margin-left: 20px;">
      <h2>О кружке</h2>
      <p>Наш кружок по химии создан для тех, кто хочет глубже понять устройство мира.  
      На занятиях мы проводим эксперименты, учимся безопасно работать с реактивами и открываем увлекательный мир химических реакций. В кружке ученики готовятся к школьным и международным олимпиадам по химии. Ученики каждый год учавствуют на олимпиадах по химии и показывают хорошие результаты. В прошлом году 6 учеников из нашей школы и нашего кружка приняли участие на республиканской предметной олимпиаде по химии и показали хорошие результаты. Ученики остались довольными своими знаниями, получившие в этом кружке.</p>

      <h2>Чему вы научитесь</h2>
      <ul>
        <li>Проводить простые и увлекательные эксперименты</li>
        <li>Понимать основы химии и строение веществ</li>
        <li>Работать в лаборатории и соблюдать технику безопасности</li>
        <li>Готовиться к олимпиадам и конкурсам</li>
      </ul>
    </div>
  </div>
  </div>

  <footer>
    📍 Каждую среду и пятницу c 13:30 до 15:00, кабинет 210 <br>
  </footer>
</body>
</html>
