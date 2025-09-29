<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Кружок по шахмату</title>
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background: #f0f2f5;
      color: #2a2a2a;
      line-height: 1.6;
    }
    header {
      background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
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
      color: #d9e2ec;
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
      max-width: 350px; 
      width: 1000px;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    }
    .text {
      flex: 2;
      min-width: 600px;
      background: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }
    .text h2 {
      margin-top: 0;
      color: #2c5364;
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
      background: #203a43;
      margin-top: 40px;
      color: #d9e2ec;
      border-top: 2px solid #2c5364;
    }
  </style>
</head>
<body>
   <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
  <header>
    <h1>Кружок по шахмату</h1>
    <p>Искусство стратегии и мышления</p>
  </header>

  <div class="section">
    <div class="text" style="display: flex;">
       <img src="img/10.jfif" alt="Шахматы">
    <div style="margin-left: 20px;"> <h2>О кружке</h2>
      <p>Наш кружок по шахмату помогает детям и подросткам развивать логику, стратегическое мышление и терпение.  
      На занятиях мы изучаем правила игры, разбираем знаменитые партии и играем друг с другом, улучшая свои навыки. Наши школьники учавствуют в разных турнирах по шахмату. Показывают достойные результаты. Они каждый раз в конце недели проводят турнир между собой, представляя итоги прошедшей недели. Где учитель оценивает их навыки, полученные на этой неделе.</p>

      <h2>Чему вы научитесь</h2>
      <ul>
        <li>Правильно играть в шахматы с нуля</li>
        <li>Развивать стратегическое мышление</li>
        <li>Анализировать позиции и партии</li>
        <li>Играть в турнирах и побеждать</li>
      </ul>
    </div>
  </div>
</div>
  <footer>
    📍 Каждую среду и пятницу с 13:30 до 15:00, кабинет 105 <br>
  </footer>
</body>
</html>
