<?php

include '../php/SessionStart.php';
if (isset($_SESSION["email"])){
  header('Location: ../php/Layout.php');
}

$mistake = '';
function inform($s){
  global $mistake;
  $mistake = "<span style='color:red'>$s</span>";
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
        // Obtener todos los temas disponibles
        $temas = array();

        include '../php/DbConfig.php';
        $conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor");
        $sql_query = "SELECT * FROM preguntas";
        if ($result = $conn->query($sql_query)){
          if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
              if (!in_array($row["Tema"], $temas)){
                $temas[] = $row["Tema"];
              }
            }
          } else {
            inform("No hay ninguna pregunta disponible");
          }
        } else {
          inform("No se ha podido procesar la petición");
        }

        mysqli_close($conn);

      ?>

      <h2>Ponte a prueba jugando al juego de Quiz</h2><br>
      <h4>Para empezar elige uno de los temas disponibles</h4><br>

      <?php

        echo $mistake;

        echo "<table id='data' style='width:50%;margin-left:25%;'><caption style'font-weight:bold;' >Lista de temas</caption><thead><th>Tema</th><th>Elegir</th></thead><tbody>";
        $count = 0;
        foreach ($temas as $tema){
          echo "<tr><td><span>" .
          "<label for='topic_" . $count . "'>" . $tema . "</label></span></td><td><span>" .
          "<input type='checkbox' class='only' name='question_topic' value='" . $tema . "' id='topic_" . $count . "' ></span></td></tr>";
          $count++;
        }
        echo "</tbody></table>";
        echo "<br>";
        if ($count > 0){
          echo "<button type='button' id='topic_check'>Elegir tema</button>";
        }

      ?>

    </div>
  </section>
  <?php include '../html/Footer.html' ?>
  <script src='../js/ChooseTopic.js'></script>
</body>
</html>
