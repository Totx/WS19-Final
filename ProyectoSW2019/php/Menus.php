<?php
$local = 1;
if ($local == 1){
  $url_path = "http://localhost/dashboard/WS19G14/ProyectoSW2019/";
} else {
  $url_path = "https://ws19g14.000webhostapp.com/ProyectoSW2019/";
}
$registrado = (isset($_GET["email"]) && isset($_GET["name_surname"])) ? "Registrado" : "Visitante";

?>
<div id='page-wrap'>
<header class='main' id='h1'>
  <?php

  function clean_form_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if($registrado == "Registrado"){
    $parameterURL = "?email=" . $_GET["email"] . "&name_surname=" . $_GET["name_surname"] . "&imagen=" . $_GET["imagen"];
    echo "<span class='right' style='padding-right:10px'><a href='LogOut.php" . $parameterURL . "'>Logout</a></span>";
    echo '<span class="right" style="padding-right:10px">' . clean_form_data(urldecode($_GET["email"])) . '</span>';
    if (!empty($_GET["imagen"])){
      $imagen = "<img src='../images/" . clean_form_data(addslashes(urldecode($_GET["imagen"]))) . "' alt='Foto de perfil' style='display:inline;max-height:100px;' />";
    } else {
      $imagen = "<img src='../images/anonimo.jpeg' alt='Foto de perfil' style='display:inline;max-height:100px;'/>";
    }
    echo '<span class="right">' . $imagen . '</span>';
  } else {
    echo '<span class="right" style="padding-right:10px"><a href="SignUp.php">Registro</a></span>';
    echo '<span class="right" style="padding-right:10px"><a href="LogIn.php">Login</a></span>';
    echo 'Anónimo <img src="../images/anonimo.jpeg" alt="Foto de perfil" style="display:inline;max-height:100px;" />';
  }

  ?>
</header>
<nav class='main' id='n1' role='navigation'>
  <?php

  $parameterURL = "";
  if ($registrado == "Registrado"){
    $parameterURL = "?email=" . $_GET["email"] . "&name_surname=" . $_GET["name_surname"] . "&imagen=" . $_GET["imagen"];
    echo "<span><a href='Layout.php" . $parameterURL . "'>Inicio</a></span>";
    echo "<span><a href='QuestionFormWithImage.php" . $parameterURL . "'> Insertar Pregunta</a></span>";
    echo "<span><a href='ShowQuestionsWithImage.php" . $parameterURL . "' >Visualizar las preguntas</a></span>";
    echo "<span><a href='Credits.php" . $parameterURL . "'>Creditos</a></span>";
  } else {
    echo "<span><a href='Layout.php'>Inicio</a></span>";
    echo "<span><a href='Credits.php'>Creditos</a></span>";
  }

  ?>
</nav>
