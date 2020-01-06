<?php

  include "../php/SessionStart.php";
  if(isset($_SESSION['email'])){
    header('Location: ../php/Layout.php');
  }

  require_once '../google-api-php-client/vendor/autoload.php';

  $id_token = $_POST['id_token'];
  $CLIENT_ID = "777454740833-5tik35la3h6drveh1i5ke0jccr9iv6eo.apps.googleusercontent.com";
  $client = new Google_Client(['client_id' => $CLIENT_ID]);
  $payload = $client->verifyIdToken($id_token);
  if ($payload) {
    echo "La cuenta de Google se ha vinculado correctamente";
    $userid = $payload['sub'];
    $_SESSION['email'] = $payload['email'];
    $_SESSION['nombre'] = $payload['name'];
    $_SESSION['image_external'] = $payload['picture'];
    $_SESSION['role'] = 3;
    include 'IncreaseGlobalCounter.php';
  } else {
    echo "No se ha podido vincular la cuenta de Google";
  }

?>
