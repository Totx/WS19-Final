<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src='../js/jquery-3.4.1.min.js'></script>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>

    </div>
  </section>
</body>
</html>
<?php

include 'DecreaseGlobalCounter.php';

echo "<script>";
if (isset($_GET["email"])){
  $despedida = "Hasta la próxima " . $res["Nombre_Apellidos"];
  echo "alert('$despedida');";
}
echo 'window.location.replace("' . $url_path . 'php/Layout.php");';
echo "</script>";

?>
