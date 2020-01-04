<?php

include '../php/SessionStart.php';
function clean_form_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$tema = clean_form_data($_POST["topic"]);
if (isset($_SESSION["email"])){
  exit("INVALIDO");
}

include '../php/DbConfig.php';
$conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor");
$sql_query = "SELECT * FROM preguntas WHERE Tema='$tema'";
if ($result = $conn->query($sql_query)){
  if ($result->num_rows > 0){
    $_SESSION['topic'] = $tema;
    $_SESSION['identifiers'] = array();
    $_SESSION['questions'] = array();
    $_SESSION['correct_answer'] = array();
    $_SESSION['incorrect_answer_1'] = array();
    $_SESSION['incorrect_answer_2'] = array();
    $_SESSION['incorrect_answer_3'] = array();
    $_SESSION['image_question'] = array();
    $_SESSION["question_order"] = array();
    $_SESSION["likes"] = array();
    $_SESSION["dislikes"] = array();
    $_SESSION["current_question"] = 0;
    $_SESSION["correctas"] = 0;
    $_SESSION["erroneas"] = 0;
    $_SESSION["total_number_questions"] = 0;
    while($row = $result->fetch_assoc()){
      $_SESSION['identifiers'][] = $row["Identificador"];
      $_SESSION['questions'][] = $row["Pregunta"];
      $_SESSION['correct_answer'][] = $row["Respuesta_correcta"];
      $_SESSION['incorrect_answer_1'][] = $row["R_Erronea_1"];
      $_SESSION['incorrect_answer_2'][] = $row["R_Erronea_2"];
      $_SESSION['incorrect_answer_3'][] = $row["R_Erronea_3"];
      $_SESSION['image_question'][] = addslashes($row["Imagen"]);
      $_SESSION["likes"][] = $row["Like_Count"];
      $_SESSION["dislikes"][] = $row["Dislike_Count"];
      $_SESSION["question_order"][] = $_SESSION["total_number_questions"];
      $_SESSION["total_number_questions"]++;
    }
    shuffle($_SESSION["question_order"]);
    echo "VALIDO";
  } else {
    echo "INVALIDO";
  }
} else {
  echo "INVALIDO";
}

mysqli_close($conn);

?>
