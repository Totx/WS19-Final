
var local = true;
var URL_game;
$("button#nextQ").click(function(){
  if (local){
    URL_game = 'http://localhost/dashboard/WS19G14/ProyectoSW2019/php/PlayGame.php';
  } else {
    URL_game = 'https://ws19g14.000webhostapp.com/ProyectoSW2019/php/PlayGame.php';
  }
  window.location.replace(URL_game);
});

$("button#leaveQ").click(function(){
  var respuesta;
  var nickname = $('input#nickname').val();
  $.ajax({
    url : "../php/EndGameSession.php",
    type: "post",
    data: { nick : nickname },
    cache: false
  }).done(function(response){
    alert(response);
    if (local){
      URL_game = 'http://localhost/dashboard/WS19G14/ProyectoSW2019/php/Layout.php';
    } else {
      URL_game = 'https://ws19g14.000webhostapp.com/ProyectoSW2019/php/Layout.php';
    }
    window.location.replace(URL_game);
  });
});
