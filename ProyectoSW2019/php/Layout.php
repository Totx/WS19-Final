<?php
  include '../php/SessionStart.php';
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type='text/css' href="../styles/QuestionTable.css">
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>

      <h2>Quiz: el juego de las preguntas</h2>
      <!--<img style="align:center" src="../images/quiz-logo.jpg" alt="Quiz">-->
      <?php
        include "../php/TopTenQuizers.php";
      ?>

    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
