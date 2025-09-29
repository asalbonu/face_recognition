<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Кружок по программированию</title>
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background: #f3f6f9;
      color: #1e1e1e;
      line-height: 1.6;
    }
    header {
      background: linear-gradient(120deg, #0d3b66, #118ab2, #06d6a0);
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
      max-width: 350px;
      width: 100%;
      height: 400px;
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
      border-left: 6px solid #06d6a0;
    }
    .text h2 {
      margin-top: 0;
      color: #118ab2;
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
      background: #0d3b66;
      margin-top: 40px;
      color: #d9f8f8;
      border-top: 2px solid #06d6a0;
    }
    
    .section.reverse {
      flex-direction: row-reverse;
    }
  </style>
</head>
<body>
    <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
  <header>
    <h1>Кружок по программированию</h1>
    <p>Создаём технологии будущего своими руками</p>
  </header>

  
  <div class="section">
    <div class="text"style="display: flex;">
    <img src="img/11.jfif" alt="Программирование">
      <div style="margin-left: 20px;"> <h2>О кружке</h2>
      <p>Наш кружок по программированию помогает освоить основы кодинга и разработки.  
      Мы изучаем популярные языки программирования, создаём свои проекты и учимся мыслить логически, решая интересные задачи. Наши ученики ежегодно учавствуют в разных олимпиадах по программированию и показывают отличные результаты</p>

      <h2>Чему вы научитесь</h2>
      <ul>
        <li>Основы Python, C++, JavaScript и других языков</li>
        <li>Создавать программы и игры</li>
        <li>Разрабатывать веб-сайты и приложения</li>
        <li>Решать алгоритмические и логические задачи</li>
      </ul>
    </div>
  </div>
  </div>


  <footer>
    📍 Каждый вторник и субботу с 13:30 до 15:00, кабинет 301 <br>
  
  </footer>
</body>
</html>
