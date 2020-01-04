<?php

include '../php/SessionStart.php';
if (!(isset($_SESSION["email"]) && isset($_SESSION["nombre"]) && isset($_SESSION['role']) && ($_SESSION['role'] == 2 || $_SESSION['role'] == 3))){
  header('Location: ../php/Layout.php');
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>

  <script src='../js/jquery-3.4.1.min.js'></script>
</head>
<body>
  <?php include '../php/Menus.php'?>
  <section class="main" id="s1">
    <div>

    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
