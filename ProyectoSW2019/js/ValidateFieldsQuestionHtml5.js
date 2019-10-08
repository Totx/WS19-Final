
function isImage(file){
   return file['type'].split('/')[0]=='image';
 }

function validate(){
  var email = $("#email");
  var expAlumnos = /^[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es)$/;
  var expProfesores = /([a-z]+\.)?[a-z]+@ehu\.(eus|es)$/;
  var isValid = true;

  if (!(expAlumnos.test(email.val()) || expProfesores.test(email.val()))) {
    isValid = false;
    $("#sEmail").html("El formato del correo no es válido");
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
