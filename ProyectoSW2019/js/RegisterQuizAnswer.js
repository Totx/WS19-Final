
$("button#sendQ").click(function(){
  var respuesta = $("input:radio[name='question']:checked").val();
  var valoración = $("input:radio[name='rate']:checked").val();
  if (!valoración){
    valoración = "0";
  }
  if (respuesta){
    //alert(respuesta);
    $.ajax({
      url : "../php/CheckQuizAnswer.php",
      type: "post",
      data: { answer : respuesta,
              rating: valoración},
      cache: false
    }).done(function (response){
      if (response.includes("Respuesta_correcta")){
        alert("Respuesta correcta");
      } else {
        alert("Respuesta incorrecta");
      }
      var local = true;
      var URL_game;
      if (local){
        URL_game = 'http://localhost/dashboard/WS19G14/ProyectoSW2019/php/NextGameChoice.php';
      } else {
        URL_game = 'https://ws19g14.000webhostapp.com/ProyectoSW2019/php/NextGameChoice.php';
      }
      window.location.replace(URL_game);
    }).fail(function(){
      alert("Ha ocurrido un error al contactar con el servidor");
    });
  } else {
    alert("No se ha elegido ninguna respuesta");
  }
});
