<?php

session_start();
if (isset($_SESSION["email"]) || !(isset($_SESSION['topic']) && (($_SESSION["current_question"] - 1) == ($_SESSION["correctas"] + $_SESSION["erroneas"])) )){
  header('Location: ../php/Layout.php');
}

function clean_form_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$answer = clean_form_data($_POST["answer"]);
$rate = clean_form_data($_POST["rating"]);
if ($answer == "0"){
  $_SESSION["correctas"]++;
  echo "Respuesta_correcta";
} else {
  $_SESSION["erroneas"]++;
  echo "Respuesta_incorrecta";
}

$id = $_SESSION['identifiers'][$_SESSION["question_order"][$_SESSION["current_question"] - 1]];
$likes = $_SESSION["likes"][$_SESSION["question_order"][$_SESSION["current_question"] - 1]] + 1;
$dislikes = $_SESSION["dislikes"][$_SESSION["question_order"][$_SESSION["current_question"] - 1]] + 1;
if ($rate != "0"){
  include '../php/DbConfig.php';
  $conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor");
  if ($rate > 0){
    if(!$sql_query = $conn->prepare("UPDATE preguntas SET Like_Count=? WHERE Identificador=?")){
      echo "<p>No se ha podido actualizar el contador de likes</p>";
    } else {
      $id_number = intval($id);
      $sql_query->bind_param("ii", $likes, $id_number);
      if ($result = $sql_query->execute()) {
        echo "<p>Gracias por la valoración positiva</p>";
      } else {
        echo "<p>No se ha podido actualizar el contador de likes</p>";
        //echo "Error: No se ha podido realizar la insercón de los datos<br>" . mysqli_error($conn);
      }
    }
  } else {
    if(!$sql_query = $conn->prepare("UPDATE preguntas SET Dislike_Count=? WHERE Identificador=?")){
      echo "<p>No se ha podido actualizar el contador de dislikes</p>";
    } else {
      $id_number = intval($id);
      $sql_query->bind_param("ii", $dislikes, $id_number);
      if ($result = $sql_query->execute()) {
        echo "<p>Gracias por la valoración</p>";
      } else {
        echo "<p>No se ha podido actualizar el contador de dislikes</p>";
        //echo "Error: No se ha podido realizar la insercón de los datos<br>" . mysqli_error($conn);
      }
    }
  }
  mysqli_close($conn);
}

?>
