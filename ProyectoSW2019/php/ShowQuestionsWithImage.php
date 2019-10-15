<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src='../js/jquery-3.4.1.min.js'></script>
  <style media="screen">
    table, th, td {
      border: 1px solid grey;
      border-collapse: collapse;
    }
    #data {
      table-layout: fixed;
      width: 100%;
      background-color: white;
    }
    #data td {
      overflow: hidden;
      text-overflow: ellipsis;
      word-break: keep-all;
    }
    #data td:hover{
    white-space: normal;
    overflow: visible;
    position: relative;
    }
    #data td:hover span {
    background-color: white;
    border: 2px solid grey;
    display: inline-block;
    height: 100%;
    }
    #data tr:nth-child(even) {
    background-color: lightgrey;
    }

    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      padding-top: 100px; /* Location of the box */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    .modal-content {
      margin: auto;
      display: block;
      width: 80%;
      max-width: 700px;
    }

    #caption {
      margin: auto;
      display: block;
      width: 80%;
      max-width: 700px;
      text-align: center;
      color: #ccc;
      padding: 10px 0;
      height: 150px;
    }

    .modal-content, #caption {
      -webkit-animation-name: zoom;
      -webkit-animation-duration: 0.6s;
      animation-name: zoom;
      animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
      from {-webkit-transform:scale(0)}
      to {-webkit-transform:scale(1)}
    }

    @keyframes zoom {
      from {transform:scale(0)}
      to {transform:scale(1)}
    }

    .close {
      position: absolute;
      top: 15px;
      right: 35px;
      color: #f1f1f1;
      font-size: 40px;
      font-weight: bold;
      transition: 0.3s;
    }

    .close:hover,
    .close:focus {
      color: #bbb;
      text-decoration: none;
      cursor: pointer;
    }

    @media only screen and (max-width: 700px){
      .modal-content {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>

      <?php

      include '../php/DbConfig.php';

      $conn = mysqli_connect($server, $user, $pass, $basededatos);
      if (!$conn) {
        die("Conexión fallida con la base de datos: " . mysqli_connect_error());
      }

      $sql_query = "SELECT * FROM preguntas";
      $result = $conn->query($sql_query);

      if ($result->num_rows > 0) {
        echo "<table id='data'><caption style'font-weight:bold;' >Lista de preguntas</caption><thead><tr><th>Correo</th><th>Pregunta</th><th>R_correcta</th><th>R_errónea_1</th><th>R_errónea_2</th><th>R_errónea_3</th><th>Complejidad</th><th>Tema</th><th>Imagen<br><span style='color:red'>(Haz click en la imagen para agrandarlo)</span></th></tr></thead><tbody>";
        while($row = $result->fetch_assoc()) {
          $imagen = "";
          if (!empty($row["Imagen"])){
            $imagen = "<img src='../images/" . addslashes($row["Imagen"]) . "' alt='" . addslashes($row["Tema"]) . "' style='display:block;' width='100%' onclick='clickImage(". "\"" . addslashes($row["Imagen"]) . "\"," . "\"" . addslashes($row["Tema"]) . "\"" . ")'/>";
          }
          echo "<tr><td><span>" .
          $row["Correo"] . "</span></td><td><span>" .
          $row["Pregunta"] . "</span></td><td><span>" .
          $row["Respuesta_correcta"] . "</span></td><td><span>" .
          $row["R_Erronea_1"] . "</span></td><td><span>" .
          $row["R_Erronea_2"] . "</span></td><td><span>" .
          $row["R_Erronea_3"] . "</span></td><td><span>" .
          $row["Complejidad"] . "</span></td><td><span>" .
          $row["Tema"] . "</span></td><td><span>" .
          $imagen . "</span></td></tr>";
        }
        echo "</tbody></table>";
      } else {
        echo "No hay ninguna preguntas";
      }

      $conn->close();

      ?>

      <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="imagen_zoom1" src=''>
        <div id="caption"></div>
      </div>

      <script>
      var modal = document.getElementById("myModal");
      var captionText = document.getElementById("caption");
      function clickImage(imagen_src, imagen_topic){
        modal.style.display = "block";
        var URL_image = "http://localhost/dashboard/WS19G14/ProyectoSW2019/images/" + imagen_src;
        $("#imagen_zoom1").attr("src", URL_image);
        captionText.innerHTML = imagen_topic;
      }

      var span = document.getElementsByClassName("close")[0];

      span.onclick = function() {
        modal.style.display = "none";
      }
      </script>

      <script type="text/javascript">
        $(document).ready(function(){
          $('#data').after('<div id="nav"></div>');
          var rowsShown = 8;
          var rowsTotal = $('#data tbody tr').length;
          var numPages = rowsTotal/rowsShown;
          for(i = 0;i < numPages;i++) {
              var pageNum = i + 1;
              $('#nav').append('<a href="#" rel="'+i+'">'+pageNum+'</a> ');
          }
          $('#data tbody tr').hide();
          $('#data tbody tr').slice(0, rowsShown).show();
          $('#nav a:first').addClass('active');
          $('#nav a').bind('click', function(){
              $('#nav a').removeClass('active');
              $(this).addClass('active');
              var currPage = $(this).attr('rel');
              var startItem = currPage * rowsShown;
              var endItem = startItem + rowsShown;
              $('#data tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
                      css('display','table-row').animate({opacity:1}, 300);
          });
        });
      </script>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
