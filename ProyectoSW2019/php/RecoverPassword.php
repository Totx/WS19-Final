<?php

  include '../php/SessionStart.php';
  if(isset($_SESSION['email'])){
    header('Location: ../php/Layout.php');
  }

?>

<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type='text/css' href="../styles/FormTable.css">
  <script src='../js/jquery-3.4.1.min.js'></script>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>
      <?php
        /*
        if (isset($_SESSION['email_recovery'])){
          echo $_SESSION['email_recovery'];
          echo $_SESSION['code'];
        }
        */
        $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
          if(!empty($_POST["email"])){
            $email = clean_form_data($_POST["email"]);
            if (preg_match("/^[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es)$/", $email) || preg_match("/([a-z]+\.)?[a-z]+@ehu\.(eus|es)$/", $email)){
              include '../php/DbConfig.php';
              $conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor, vuelvelo a intentar mas tarde");
              $sql_query = "SELECT * FROM usuarios WHERE Correo='$email'";
              if ($result = $conn->query($sql_query)){
                if ($result->num_rows > 0){
                  $codigo = rand(100000, 999999);
                  $_SESSION['email_recovery'] = $email;
                  $_SESSION['code'] = $codigo;
                  $to = $email;
                  $subject = "Restablecer contraseña";
                  $msg = '
                  <html>
                    <head>
                      <title>Recuperación de la contraseña</title>
                    </head>
                    <body>
                      <h1>RESTABLECER SU CONTRASEÑA</h1>
                      <h2>Restablezca su contraseña en el siguiente enlace</h2>
                      <h3><a href="https://ws19g14.000webhostapp.com/ProyectoSW2019/php/ChangePassword.php?email=' . $email . '">Enlace a la pagina de recuperación de contraseña</a></h3>
                      <h2>Código de recuperación</h2>
                      <h3>' . $codigo . '</h3>
                    </body>
                  </html>';
                  $headers = "MIME-Version: 1.0" . "\r\n" .
                              "Content-type: text/html; charset=UTF-8" . "\r\n";
                  if (mail($to, $subject, $msg, $headers)){
                    $error = "Mensaje de recuperación de contraseña enviado exitosamente";
                  } else {
                    $error = "Ha ocurrido un error al enviar el mensaje de recuperación al correo";
                  }
                } else {
                  $error = "El correo no corresponde a un usuario registrado";
                }
              } else {
                $error = "La base de datos no ha podido procesar la petición";
              }
              mysqli_close($conn);
            } else {
              $error = "El correo no cumple con el formato adecuado";
            }
          } else {
            $error = "No se ha especificado ningún correo";
          }
        }
      ?>
      <form method="post" id="fquestion" name="fquestion" action="RecoverPassword.php">
        <fieldset style="background-color:lightblue">
          <legend style="background-color:white;border-style: solid; border-width: 2px">RESTABLECER CONTRASEÑA</legend>
          <table class="fquest" style="margin-left:auto;margin-right:auto;">
            <tr>
              <td class="label"><label for="email">Email de la cuenta a restablecer: </label></td>
              <td class="input"><input type="email" class="qInput" name="email" id="email" pattern="(([a-z]+\.)?[a-z]+@ehu\.(eus|es)|[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es))$" required /></td>
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

  <?php include '../html/Footer.html' ?>
</body>
</html>
