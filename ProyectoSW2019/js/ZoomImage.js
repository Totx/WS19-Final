
var modal = document.getElementById("myModal");
var captionText = document.getElementById("caption");
function clickImage(imagen_src, imagen_topic){
  modal.style.display = "block";
  // URL_image_directory must be specified as a global variable
  var URL_image = URL_image_directory + imagen_src;
  $("#imagen_zoom1").attr("src", URL_image);
  captionText.innerHTML = imagen_topic;
}

var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
  modal.style.display = "none";
}
