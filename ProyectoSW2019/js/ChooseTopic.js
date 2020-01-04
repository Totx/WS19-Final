
$("input:checkbox").on('click', function() {
  var $box = $(this);
  if ($box.is(":checked")) {
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
  //alert("Tema seleccionado: " + $("input:checkbox.only:checked").val());
});

$("button#topic_check").click(function (){
  var topic = $("input:checkbox.only:checked").val();
  if (topic){
    $.ajax({
      url : "../php/SetTopic.php",
      type: "post",
      data: { topic : topic },
      cache: false
    }).done(function(response){
      //alert(response);
      if (response == "VALIDO"){
        if (confirm("¿Comenzar a jugar con el tema seleccionado?")){
          var local = true;
          var URL_game;
          if (local){
            URL_game = 'http://localhost/dashboard/WS19G14/ProyectoSW2019/php/PlayGame.php';
          } else {
            URL_game = 'https://ws19g14.000webhostapp.com/ProyectoSW2019/php/PlayGame.php';
          }
          window.location.replace(URL_game);
        }
      } else {
        alert("El tema seleccionado no es válido");
      }
    }).fail(function(){
      alert("Ha ocurrido un error al contactar con el servidor");
    });
} else {
  alert("No se ha seleccionado ningun tema");
}
});
