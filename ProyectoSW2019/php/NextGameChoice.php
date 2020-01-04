<?php

session_start();
if ( isset($_SESSION["email"]) || !(isset($_SESSION['topic']) && ($_SESSION["current_question"] == ($_SESSION["correctas"] + $_SESSION["erroneas"])))){
  header('Location: ../php/Layout.php');
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type='text/css' href="../styles/QuestionTable.css">
  <script src='../js/jquery-3.4.1.min.js'></script>
</head>
<body>
  <?php include '../php/Menus.php'?>
  <section class="main" id="s1">
    <div>
      <?php

      echo '<div class="qCount" name="answeredQ" id="aQ" style="border-style: double;">Preguntas respondidas/Total de preguntas: ' . $_SESSION["current_question"] . '/' . $_SESSION["total_number_questions"] . '</div><br>' .
      '<div class="topicClass" name="topic" id="topic" style="border-style: double;">Tema: ' . $_SESSION['topic'] . '</div><br>' .
      '<div class="correctClass" name="correctAns" id="correctAns" style="border-style: double;">Respuestas correctas/erróneas: ' . $_SESSION["correctas"] . '/' . $_SESSION["erroneas"] . '</div><br>';

      if ($_SESSION["current_question"] < $_SESSION["total_number_questions"]){
        echo "<h2>Puedes elegir entre responder a otra pregunta del mismo tema restante o abandonar la sesión de juego</h2>";
        echo "<h4>Si quieres responder a otra pregunta, pulsa el botón de abajo</h4>";
        echo "<button name='nextQ' id='nextQ'>Próxima pregunta</button>";
      } else {
        echo "<h2>Has respondido a todas las preguntas sobre '" . $_SESSION['topic'] . "'</h2>";
      }

      echo "<h4>Para guardar (opcionalmente) el resultado introduce un nick y para finalizar la sesión de juego, pulsa el boton de abajo</h4>";
      echo "<label for='nickname'>Nick del jugador: </label><input type='text' name='nickname' id='nickname'>";
      echo "<button name='leaveQ' id='leaveQ'>Terminar sesión de juego</button>";

      ?>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
  <script src='../js/NextQuestion.js'></script>
</body>
</html>
