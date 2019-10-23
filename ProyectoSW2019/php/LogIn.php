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

      <form action="LogIn.php" method="post">
        <fieldset style="background-color:lightblue">
          <legend style="background-color:white;border-style: solid; border-width: 2px">DATOS DE INICIO DE SESIÓN</legend>
          <table style="margin-left:auto;margin-right:auto;">
            <tr>
              <td><label for="email">Correo:</label></td>
              <td><input type="email" name="correo" id="email" pattern="[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es)|([a-z]+\.)?[a-z]+@ehu\.(eus|es)$" required autofocus value="<?php echo isset($_POST['correo']) ? clean_form_data($_POST['correo']) : '' ?>" /></td>
            </tr>
            <tr>
              <td><label for="pass">Contraseña:</label></td>
              <td><input type="password" name="password" id="pass" minlength=6 required/></td>
            </tr>
            <tr>
              <td colspan="2">
                <input type="submit" name="send" value="Login" />
              </td>
            </tr>
          </table>
        </fieldset>
      </form>

      <?php

        if (isset($_GET["email"])) echo "<script>window.location.replace('" . $url_path . "php/LogIn.php');</script>";

        function inform(){
          echo "<span style='color:red'>Ha ocurrido un error: Los datos son incorrectos.</span>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){

          if(!empty($_POST["correo"]) && !empty($_POST["password"])){
            $correo = clean_form_data($_POST["correo"]);
            $password = clean_form_data($_POST["password"]);

            include '../php/DbConfig.php';
            $conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor, vuelvelo a intentar mas tarde");
            $sql_query = "SELECT * FROM usuarios WHERE Correo='$correo' AND Contrasena='$password'";
            if ($result = $conn->query($sql_query)){
              if ($result->num_rows > 0){
                $row_value = $result->fetch_assoc();
                $parameterURLLogin = "?email=" . $row_value["Correo"];
                echo "<script>";
                $variable_link = $url_path . 'php/Layout.php' . $parameterURLLogin;
                $link_val = 'window.location.replace("' . $variable_link . '");';
                echo $link_val;
                echo "</script>";
              } else {
                inform();
              }
            } else {
              inform();
            }
            mysqli_close($conn);

          } else {
            inform();
          }

        }

      ?>

    </div>
  </section>

</body>
</html>
