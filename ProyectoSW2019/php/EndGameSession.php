<?php

include '../php/SessionStart.php';
if (isset($_SESSION["email"]) || !(($_SESSION["current_question"] == ($_SESSION["correctas"] + $_SESSION["erroneas"])))){
  header('Location: ../php/Layout.php');
}
echo "Aciertos: " . $_SESSION["correctas"] . "  Errores: " . $_SESSION["erroneas"];

function clean_form_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$nick = clean_form_data($_POST["nick"]);

// If specified, the nick is stored or updated if there was a nick name with the same nick alredy in use
if (!empty($nick)){
  include '../php/DbConfig.php';
  $conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor");
  $sql_query = "SELECT * FROM nicknames WHERE Nick='$nick'";
  if ($result = $conn->query($sql_query)){
    if ($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $nick = $row["Nick"];
      $correct = $row["Aciertos"] + $_SESSION["correctas"];
      $mistakes = $row["Fallos"] + $_SESSION["erroneas"];
      $score = ($correct - intval(0.5*$mistakes));
      if($sql_query = $conn->prepare("UPDATE nicknames SET Aciertos=?, Fallos=?, Puntuacion=? WHERE Nick=?")){
        $sql_query->bind_param("iiis", $correct, $mistakes, $score, $nick);
        $sql_query->execute();
      }
    } else {
      $correct = $_SESSION["correctas"];
      $mistakes = $_SESSION["erroneas"];
      $score = ($_SESSION["correctas"] - intval(0.5*$_SESSION["erroneas"]));
      if($sql_query = $conn->prepare("INSERT INTO nicknames(Nick, Aciertos, Fallos, Puntuacion) VALUES (?, ?, ?, ?)")){
        $sql_query->bind_param("siii", $nick, $correct, $mistakes, $score);
        $sql_query->execute();
      }
    }
  }
  mysqli_close($conn);
}

?>
