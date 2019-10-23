<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
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

        if (isset($_GET["email"])) echo "<script>window.location.replace('" . $url_path . "php/SignUp.php');</script>";

        $required = array();
        $values = array();

        if ($_SERVER["REQUEST_METHOD"] == "POST"){

          if(empty($_POST["correo"])){
            $required["semail"] = "No se ha incluído el correo";
          } else {
            $email = clean_form_data($_POST["correo"]);
            if (empty($_POST["ocupacion"])) {
              $required["socupation"] = "No se ha elegido una ocupación que identifique al correo";
            } else {
              $ocupation = clean_form_data($_POST["ocupacion"]);
              if (($ocupation == "profesor" && preg_match("/([a-z]+\.)?[a-z]+@ehu\.(eus|es)$/", $email)) || ($ocupation == "estudiante" && preg_match("/^[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es)$/", $email))){
                $values["correo"] = $email;
              } else {
                $required["semail"] = "El formato del correo no es adecuado para ocupación elegida";
              }
            }
          }

          if (empty($_POST["name_surname"])){
            $required["snombre"] = "No se ha especificado el nombre y apellidos";
          } else {
            $name_sur = clean_form_data($_POST["name_surname"]);
            if (preg_match('/^[A-Za-z]+(\s[A-Za-z]+){1,}$/', $name_sur)) {
              $values["name_surname"] = $name_sur;
            } else {
              $required["snombre"] = "El nombre y apellido deben ser mínimo dos palabras compuestas por carácteres";
            }
          }

          if (empty($_POST["password"])){
            $required["spass"] = "No se ha especificado el password";
          } else {
            $pass = clean_form_data($_POST["password"]);
            if (!filter_var($pass, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\w\s]{6,}$/")))){
              $required["spass"] = "La longitud de la contraseña debe tener 6 carácteres alfanuméricos al menos";
            } else {
              $values["password"] = $pass;
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

          $targetDir = "../images/";
          $name = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME);
          $fileType = pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION);
          $values["imagen"] = NULL;

          if(!empty($_FILES["imagen"]["name"])){
              $allowTypes = array('jpg','png','jpeg','gif');
              if(in_array($fileType, $allowTypes)){
                $increment = 0;
                 $pname = $name . '.' . $fileType;
                 while(is_file($targetDir . $pname)) {
                   $increment++;
                   $pname = $name . $increment . '.' . $fileType;
                 }
                 $targetDir =  $targetDir . $pname;
                  if(move_uploaded_file($_FILES["imagen"]["tmp_name"], $targetDir)){
                    $values["imagen"] = $pname;
                  }else{
                  // echo $_FILES["imagen"]["tmp_name"];
                    $required["sim"] = "Ha ocurrido un error al subir la imagen";
                  }
              }else{
                $required["sim"] = "El formato del archivo no es aceptado";
              }
          }

          if (empty($required)){
            //Every field was correctly filled
            include '../php/DbConfig.php';
            $conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor");
            if(!$sql_query = $conn->prepare("INSERT INTO usuarios(Correo, Nombre_Apellidos, Contrasena, Imagen) VALUES (?, ?, ?, ?)")){
              echo "La petición al servidor no se puede procesar";
            } else {
              $sql_query->bind_param("ssss", $values["correo"], $values["name_surname"], $values["password"], $values["imagen"]);
              if ($result = $sql_query->execute()) {
                $welcome = "Bienvenido seas a la comunidad " . $values["name_surname"];
                echo "<script type='text/javascript'> alert('$welcome');window.location.href='" . $url_path . "php/LogIn.php" . $parameterURL . "';</script>";
              } else {
                echo "<p>El servidor ha tenido problemas al procesar su registro. Probablemente se deba a que ya existe un usuario registrado con el mismo correo.</p>";
                //echo "Error: No se ha podido realizar la insercón de los datos<br>" . mysqli_error($conn);
              }
            }
            mysqli_close($conn);
          }

        }

      ?>

      <form method="post" id="fquestion" name="fquestion" action="SignUp.php" enctype="multipart/form-data">
        <fieldset style="background-color:lightblue">
          <legend style="background-color:white;border-style: solid; border-width: 2px">DATOS DE REGISTRO</legend>
          <table style="margin-left:auto;margin-right:auto;">
            <tr>
              <td class="label">
                <label for="radioChoice" id="ocupation" >Ocupación:</label>
              </td>
              <td>
                <table id="radioChoice">
                  <tr>
                    <td><label for="teacher">Profesor</label></td><td>
                    <input type="radio" id="teacher" name="ocupacion" value="profesor" <?php echo (isset($_POST["ocupacion"]) && clean_form_data($_POST['ocupacion']) == "profesor") ? 'checked' : '' ?> /></td></tr><tr>
                    <td><label for="student">Estudiante</label></td><td>
                    <input type="radio" id="student" name="ocupacion" value="estudiante" <?php echo (isset($_POST["ocupacion"]) && clean_form_data($_POST['ocupacion']) == "estudiante") ? 'checked' : '' ?> /></td>
                  </tr>
                </table>
              </td>
              <td>
                <span id="socupation"><?php if(!empty($required["socupation"])) echo $required["socupation"]; ?></span>
              </td>
            </tr>
            <tr>
              <td class="label">
                <label for="email">Correo:</label>
              </td>
              <td>
                <input type="text" id="email" name="correo" value="<?php echo isset($_POST['correo']) ? clean_form_data($_POST['correo']) : '' ?>"/>
              </td>
              <td>
                <span id="semail"><?php if(!empty($required["semail"])) echo $required["semail"]; ?></span>
              </td>
            </tr>
            <tr>
              <td class="label">
                <label for="nombre">Nombre y apellidos:</label>
              </td>
              <td>
                <input type="text" name="name_surname" id="nombre" value="<?php echo isset($_POST['name_surname']) ? clean_form_data($_POST['name_surname']) : '' ?>"/>
              </td>
              <td>
                <span id="snombre"><?php if(!empty($required["snombre"])) echo $required["snombre"]; ?></span>
              </td>
            </tr>
            <tr>
              <td class="label">
                <label for="pass">Password:</label>
              </td>
              <td>
                <input type="password" name="password" id="pass"/> <br>
                <input type="checkbox" id="cpass1"/>Mostrar password
              </td>
              <td>
                <span id="spass"><?php if(!empty($required["spass"])) echo $required["spass"]; ?></span>
              </td>
            </tr>
            <tr>
              <td class="label">
                <label for="pass2">Confirmar password:</label>
              </td>
              <td >
                <input type="password" name="passcheck" id="pass2" /> <br>
                <input type="checkbox" id="cpass2"/>Mostrar password
              </td>
              <td>
                <span id="spass2"><?php if(!empty($required["spass2"])) echo $required["spass2"]; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <label for="" class="label">Imagen:</label>
              </td>
              <td>
                <input type="file" name="imagen" id="im">
              </td>
              <td>
                <span id="sim"><?php if(!empty($required["sim"])) echo $required["sim"]; ?></span>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <input type="submit" name="envio" value="Registrarse" />
              </td>
            </tr>
          </table>
        </fieldset>

      </form>

    </div>
  </section>

  <?php include '../html/Footer.html' ?>
  <script type="text/javascript">
    $("#cpass1").click(function(){
      var tipo = ""
      if ($("#pass").attr("type") == "password"){
        tipo = "text";
      } else if ($("#pass").attr("type") == "text"){
        tipo = "password";
      }
      $("#pass").attr("type", tipo);
    });
    $("#cpass2").click(function(){
      var tipo = ""
      if ($("#pass2").attr("type") == "password"){
        tipo = "text";
      } else if ($("#pass2").attr("type") == "text"){
        tipo = "password";
      }
      $("#pass2").attr("type", tipo);
    });
  </script>
  <script src='../js/ShowImageInForm.js'></script>
</body>
</html>
