<?php
// Warning suppression
error_reporting(E_ERROR | E_PARSE);
$local = 1;
if ($local == 1){
  $url_path = "http://localhost/dashboard/WS19G14/ProyectoSW2019/";
} else {
  $url_path = "https://ws19g14.000webhostapp.com/ProyectoSW2019/";
}
$registrado = (isset($_GET["email"])) ? "Registrado" : "Visitante";
$parameterURL = "";

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
    include '../php/DbConfig.php';
    $conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor");
    $email_val = clean_form_data(urldecode($_GET["email"]));
    $sql_query = "SELECT * FROM usuarios WHERE Correo='" . $email_val . "'";
    $result = $conn->query($sql_query);
    if($result->num_rows > 0){
      $res = $result->fetch_assoc();
    } else {
      echo "<script>";
      echo 'window.location.replace("' . $url_path . 'php/Layout.php");';
      echo "</script>";
      exit();
    }
    mysqli_close($conn);
    $parameterURL = "?email=" . $res["Correo"];
    echo "<span class='right' style='padding-right:10px'><a href='LogOut.php" . $parameterURL . "'>Logout</a></span>";
    echo '<span class="right" style="padding-right:10px">' . $res["Correo"] . '</span>';
    if (!empty($res["Imagen"])){
      $imagen = "<img src='../images/" . $res["Imagen"] . "' alt='Foto de perfil' style='display:inline;max-height:100px;' />";
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

  if ($registrado == "Registrado"){
    echo "<span><a href='Layout.php" . $parameterURL . "'>Inicio</a></span>";
    echo "<span><a href='HandlingQuizesAjax.php" . $parameterURL . "'>Gestionar Preguntas</a></span>";
    echo "<span><a href='Credits.php" . $parameterURL . "'>Creditos</a></span>";
  } else {
    echo "<span><a href='Layout.php'>Inicio</a></span>";
    echo "<span><a href='Credits.php'>Creditos</a></span>";
  }

  ?>
</nav>
