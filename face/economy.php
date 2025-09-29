<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Кружок по экономике</title>
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background: #f0f2f5;
      color: #142315ff;
      line-height: 1.6;
    }
    header {
      background: linear-gradient(120deg, #243949, #517fa4);
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
      width: auto;   
      height: 530px;   
      flex: 1;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    }
    .text {
      flex: 1;
      min-width: 280px;
      background: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }
    .text h2 {
      margin-top: 0;
      color: #355c7d;
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
      background: #243949;
      margin-top: 40px;
      color: #d9e2ec;
      border-top: 2px solid #517fa4;
    }
  </style>
</head>
<body>
  <?php require_once("pages/header.php");?>
   <?php require_once("pages/sidebar.php");?>
  <header>
    <h1>Кружок по экономике</h1>
    <p>Разбираемся в мире финансов и бизнеса</p>
  </header>

  <div class="section">
    <div class="text" style="display: flex;">
      <img src="img/12.jfif" alt="Экономика">
      <div style="margin-left: 20px;">
        <h2>О кружке</h2>
      <p>Наш кружок помогает школьникам разобраться в основах экономики: 
      как устроены деньги, банки и бизнес, какие законы действуют на рынке и как принимать правильные финансовые решения. Наши ученики часто учавствуют в разных конкурсах по экономике и показывают хорошие рехудьтат. Круужок направлен для того чтобы ученики могли со школьных лет понимать что такое финансовая грамотность и правильно пользоваться денежными средствами.</p>

      <h2>Чему вы научитесь</h2>
      <ul>
        <li>Понимать основы экономики и финансов</li>
        <li>Планировать личный бюджет</li>
        <li>Разбираться в рыночных механизмах</li>
        <li>Анализировать бизнес-идеи</li>
      </ul>
    </div>
  </div>
  </div>

  <footer>
    📍 Каждый понедельник и среду  с 13:30 до 15:00, кабинет 204 <br>
  </footer>
</body>
</html>
