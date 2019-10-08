
function isImage(file){
   return file['type'].split('/')[0]=='image';
 }

function validate(){
  var email = $("#email");
  var p = $("#qst");
  var c = $("#correct");
  var e1 = $("#error1");
  var e2 = $("#error2");
  var e3 = $("#error3");
  var s = $("#complexity");
  var t = $("#topic");
  var i = $("#im");
  var isValid = true;
  var vacio = "Campo obligatorio vacio";
  var expAlumnos = /^[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es)$/;
  var expProfesores = /([a-z]+\.)?[a-z]+@ehu\.(eus|es)$/

  if (!email.val()){
    isValid = false;
    $("#sEmail").html(vacio);
  } else if (!(expAlumnos.test(email.val()) || expProfesores.test(email.val()))) {
    isValid = false;
    $("#sEmail").html("El formato del correo no es válido");
  } else {
    $("#sEmail").html("");
  }

  if (!p.val()){
    isValid = false;
    $("#sqst").html(vacio);
  } else if (p.val().length < 10){
    isValid = false;
    $("#sqst").html("Longitud de la pregunta inferior a 10 caracteres");
  } else {
    $("#sqst").html("");
  }

  if (!c.val()){
    isValid = false;
    $("#scorrect").html(vacio);
  } else {
    $("#scorrect").html("");
  }

  if (!e1.val()){
    isValid = false;
    $("#serror1").html(vacio);
  } else {
    $("#serror1").html("");
  }

  if (!e2.val()){
    isValid = false;
    $("#serror2").html(vacio);
  } else {
    $("#serror2").html("");
  }

  if (!e3.val()){
    isValid = false;
    $("#serror3").html(vacio);
  } else {
    $("#serror3").html("");
  }

  if (!s.val()){
    isValid = false;
    $("#scomplexity").html(vacio);
  } else if (!(s.val()==1 || s.val()==2 || s.val()==3)) {
    isValid = false;
    $("#scomplexity").html("La complejidad tiene un valor inapropiado");
  } else {
    $("#scomplexity").html();
  }

  if (!t.val()){
    isValid = false;
    $("#stopic").html(vacio);
  } else {
    $("#stopic").html("");
  }

  if(document.getElementById("im").files[0] && !isImage(document.getElementById("im").files[0])){
    isValid = false;
  }

  return isValid;
}

$("#fquestion").submit(function(){
  return validate();
});

$("#reset").click(function(){
  $("#email").val("");
  $("#qst").val("");
  $("#correct").val("");
  $("#error1").val("");
  $("#error2").val("");
  $("#error3").val("");
  $("#complexity").val("");
  $("#topic").val("");
  $("#im").val("");
  $("#sim").html("");
})
