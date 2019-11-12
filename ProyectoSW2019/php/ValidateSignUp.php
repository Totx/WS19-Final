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
