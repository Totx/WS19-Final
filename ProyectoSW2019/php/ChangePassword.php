<?php

  include '../php/SessionStart.php';
  if(!isset($_SESSION['email_recovery']) || !isset($_SESSION["code"]) || !isset($_REQUEST["email"]) || $_REQUEST["email"] != $_SESSION['email_recovery']){
    header('Location: ../php/Layout.php');
  }

?>

<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type='text/css' href="../styles/FormTable.css">
  <script src='../js/jquery-3.4.1.min.js'></script>
  <style media="screen">
    span {
      color: darkred;
    }
  </style>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>
      <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
          $required = array();
          $values = array();

          if (empty($_POST["code"])){
            $required["scode"] = "No se ha proporcionado el código";
          } else {
            $code = clean_form_data($_POST["code"]);
            if ($code != $_SESSION["code"]){
              $required["scode"] = "El código proporcionado no es correcto";
            }
          }

          if (empty($_POST["password"])){
            $required["spass"] = "No se ha especificado el password";
          } else {
            $pass = clean_form_data($_POST["password"]);
            if (!filter_var($pass, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\w\s]{6,}$/")))){
              $required["spass"] = "La longitud de la contraseña debe tener 6 carácteres alfanuméricos al menos";
            } else {
              include 'ClientVerifyPass.php';
              if($result_pass == "INVALIDA"){
                $required["spass"]  = "No es un password válido";
              } else if ($result_pass == "VALIDA"){
                $values["password"] = $pass;
              } else {
                $required["spass"] = "Fuera de servicio";
              }
            }
          }

          if (empty($_POST["passcheck"])){
            $required["spass2"] = "No se ha vuelto a introducir la contraseña";
          } else {
            $pass2 = clean_form_data($_POST["passcheck"]);
            if (!filter_var($pass2, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\w\s]{6,}$/")))){
              $required["spass2"] = "La longitud de la contraseña debe tener 6 carácteres alfanuméricos al menos";
            } else {
              $values["passcheck"] = $pass2;
            }
          }

          if(!empty($values["password"]) && !empty($values["passcheck"]) && strcmp($values["password"], $values["passcheck"]) !== 0){
            $required["spass2"] = "La contraseña no coincide";
          }

          if (empty($required)){
            //Every field was correctly filled
            include '../php/DbConfig.php';
            $conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor");
            if(!$sql_query = $conn->prepare("UPDATE usuarios SET Contrasena=? WHERE Correo=?")){
              echo "La petición al servidor no se puede procesar";
            } else {
              $sql_query->bind_param("ss", password_hash($values["password"], PASSWORD_DEFAULT), $_SESSION["email_recovery"]);
              if ($result = $sql_query->execute()) {
                unset($_SESSION['email_recovery']);
                unset($_SESSION["code"]);
                $welcome = "Tu contraseña se ha actualizado correctamente";
                echo "<script type='text/javascript'> alert('$welcome');window.location.href='" . $url_path . "php/LogIn.php';</script>";
              } else {
                echo "<p>El servidor ha tenido problemas al procesar la actualización de contraseña.</p>";
                //echo "Error: No se ha podido realizar la insercón de los datos<br>" . mysqli_error($conn);
              }
            }
            mysqli_close($conn);
          }

        }
      ?>
      <form method="post" id="fquestion" name="fquestion" action="ChangePassword.php" >
        <fieldset style="background-color:lightblue">
          <legend style="background-color:white;border-style: solid; border-width: 2px">RESTABLECER CONTRASEÑA</legend>
          <table class="fquest" style="margin-left:auto;margin-right:auto;">
            <tr>
              <td class="label"><label for="email">Email de la cuenta a restablecer: </label></td>
              <td class="input"><input type="email" class="qInput" name="email" id="email" pattern="(([a-z]+\.)?[a-z]+@ehu\.(eus|es)|[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es))$" required readonly value="<?php if(isset($_SESSION["email_recovery"])) echo $_SESSION["email_recovery"]; ?>"/></td>
              <td><span class="spanSingUp" id="semail"><?php if(!empty($required["semail"])) echo $required["semail"]; ?></span></td>
            </tr>
            <tr>
              <td class="label"><label for="code">Código: </label></td>
              <td class="input"><input type="number" class="qInput" name="code" id="code" required/></td>
              <td><span class="spanSingUp" id="scode"><?php if(!empty($required["scode"])) echo $required["scode"]; ?></span></td>
            </tr>
            <tr>
              <td class="label"><label for="pass">Nueva contraseña: </label></td>
              <td class="input"><input type="password" class="qInput" name="password" id="pass" required/></td>
              <td><span class="spanSingUp" id="spass"><?php if(!empty($required["spass"])) echo $required["spass"]; ?></span></td>
            </tr>
            <tr>
              <td class="label"><label for="pass2">Volver a introducir la contraseña: </label></td>
              <td class="input"><input type="password" class="qInput" name="passcheck" id="pass2" required/></td>
              <td><span class="spanSingUp" id="spass2"><?php if(!empty($required["spass2"])) echo $required["spass2"]; ?></span></td>
            </tr>
            <tr>
              <td colspan="2">
                <input type="submit" name="send" value="Enviar" />
              </td>
            </tr>
          </table>
        </fieldset>
      </form>
      <span style="color:red"><?php echo $error; ?></span>
    </div>
  </section>
</body>
</html>
