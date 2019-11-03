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
  </style>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <?php if(empty($_GET["email"])) echo "<script>window.location.replace('" . $url_path . "php/Layout.php');</script>"; ?>
  <section class="main" id="s1">
    <div>

      <?php

      $directory = "../xml/Questions.xml";
      $xml=simplexml_load_file($directory) or die("El fichero XML no esta accesible");

      echo "<table id='data'><caption style'font-weight:bold;' >Lista de preguntas</caption><thead><tr><th>Autor</th><th>Pregunta</th><th>R_correcta</th></tr></thead><tbody>";
      foreach ($xml->children() as $child){
        echo "<tr>";
        echo "<td><span>" . $child['author'] . "</span></td>";
        echo "<td><span>" . $child->itemBody->p . "</span></td>";
        echo "<td><span>" . $child->correctResponse->value . "</span></td>";
        echo "</tr>";
      }
      echo "</tbody></table>";

      ?>

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
