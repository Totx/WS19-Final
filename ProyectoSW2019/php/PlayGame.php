<?php

session_start();
if ( isset($_SESSION["email"]) || !(isset($_SESSION['topic']) && ($_SESSION["current_question"] == ($_SESSION["correctas"] + $_SESSION["erroneas"])) && ($_SESSION["current_question"] < $_SESSION["total_number_questions"]))){
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

        $i = $_SESSION["question_order"][$_SESSION["current_question"]];
        $_SESSION["current_question"]++;
        $total = $_SESSION["total_number_questions"];
        $answers = array($_SESSION['correct_answer'][$i], $_SESSION['incorrect_answer_1'][$i], $_SESSION['incorrect_answer_2'][$i], $_SESSION['incorrect_answer_3'][$i]);
        $answer_index = array(0, 1, 2, 3);
        shuffle($answer_index);
        echo '<div class="qCount" name="answeredQ" id="aQ" style="border-style: double;">Preguntas respondidas/Total de preguntas: ' . ($_SESSION["current_question"] - 1) . '/' . $total . '</div><br>' .
        '<div class="topicClass" name="topic" id="topic" style="border-style: double;">Tema: ' . $_SESSION['topic'] . '</div><br>' .
        '<div class="correctClass" name="correctAns" id="correctAns" style="border-style: double;">Respuestas correctas/erróneas: ' . $_SESSION["correctas"] . '/' . $_SESSION["erroneas"] . '</div><br>' .
        '<div class="rateClass" name="rateQ" id="rateQ" style="border-style: double;">Likes/dislikes: <span style="color:green;">' . $_SESSION["likes"][$i] . '</span>/<span style="color:red;">' . $_SESSION["dislikes"][$i] . '</span></div><br>';

        echo '<button name="sendQ" id="sendQ">Enviar respuesta</button>';

        echo "<table id='data' style='width:80%;margin-left:10%;'><caption style='font-weight:bold;' >Pregunta número " . $_SESSION["current_question"] . "</caption><tbody>";
        echo "<tr><td><span style='font-weight:bold;'>" . "Pregunta: " . "</span></td></tr><tr><td><span>" . $_SESSION['questions'][$i] . "</span></td></tr>" .
        "<tr><td><span style='font-weight:bold;'>" . "Respuestas: " . "</span></td></tr><tr><td style='width:50%;text-align:left'>";
        foreach($answer_index as $val_key){
          echo "<span><input type='radio' name='question' value='" . $val_key . "'>  " . $answers[$val_key] . "</span><br>";
        }
        echo "</td></tr><tr><td><span style='font-weight:bold;'>Valoración de la pregunta (opcional): </span>";
        echo "</td></tr><tr><td><span>" . "<input type='radio' name='rate' value='1'> Like" . "</span><br>";
        echo "<span>" . "<input type='radio' name='rate' value='-1'> Dislike" . "</span>";
        if (!empty($_SESSION['image_question'][$i])){
          $imagen = "<img src='../images/" . $_SESSION['image_question'][$i] . "' alt='" . $_SESSION['topic'] . "' style='display:block;' width='100%'/>";
          echo "</td></tr><tr><td><span>" .  $imagen . "</span>";
        }
        echo "</td></tr></tbody></table>";


      ?>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
  <script src='../js/RegisterQuizAnswer.js'></script>
</body>
</html>
