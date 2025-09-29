<style>
    .sidebar {
      position: fixed;
      top: 0;
      right: 0;
      width: 220px;
      height: 100%;
      background: #f8f9fa;
      border-left: 1px solid #ddd; 
      box-shadow: -2px 0 5px rgba(0,0,0,0.1); 
      padding-top: 60px;
      z-index: 1000;
    }

    .sidebar ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .sidebar ul li a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: background 0.3s, color 0.3s;
    }

    .sidebar ul li a:hover {
      background: #2980b9;
      color: #fff;
    }

    .sidebar .icon {
      font-size: 18px;
    }

    
    .content {
      margin-right: 40px; 
      padding: 20px;
    }
    .login-link {
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      padding-top: 30px;
    }
    .login-link a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      text-decoration: none;
      color: #2980b9;
      font-weight: bold;
      transition: background 0.3s, color 0.3s;
    }
    .login-link a:hover {
      background: #2980b9;
      color: #fff;
    }

    .info-bar span {
      margin: 0 10px;
    }

.content {
  margin-top: 80px; 
  padding: 20px;
}
</style>
<aside class="sidebar">
     
    <div class="login-link">
      <?php
  
      if(isset($_SESSION['id1'])){
      ?>
      <a href="profile.php"><i class="icon">🔑</i><?=$_SESSION['username1'] ?></a>
      <?php } else{?>
         <a href="login.php"><i class="icon">🔑</i><?= $texts[$lang]['login'] ?></a>
         <?php } ?>
    </div>
    <ul>

       <li><a href="schedule.php"><i class="icon">📅</i><?= $texts[$lang]['menu_schedule'] ?></a></li>
      <li><a href="rating_student.php"><i class="icon">⭐️</i> <?= $texts[$lang]['menu_rating'] ?></a></li>
      <li><a href="rating_students2.php"><i class="icon">⭐️</i> <?= $texts[$lang]['menu_rating_status'] ?></a></li>
      <li><a href="statistics.php"><i class="icon">📊</i> <?= $texts[$lang]['menu_stats'] ?></a></li>
      <li><a href="student_prediction.php"><i class="icon">📈</i> <?= $texts[$lang]['menu_predict'] ?></a></li>
      <li><a href="profile.php"><i class="icon">👤</i> <?= $texts[$lang]['menu_profile'] ?></a></li>
      <li><a href="statistics1.php"><i class="icon">📋</i> <?= $texts[$lang]['menu_current_attendance'] ?></a></li>
      <li><a href="lesson.php"><i class="icon">📘</i> <?= $texts[$lang]['menu_current_lesson'] ?></a></li>
       <?php
       if(isset($_SESSION['id1'])){
      ?>
     <li> <a href="logout.php" style="color: red;"><i class="icon"></i> <?= $texts[$lang]['logout'] ?></a></li>
      <?php } ?>
    </ul>
    
  </aside>