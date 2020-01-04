<?php

function orderByScore($a, $b){
  if ($a["Puntuacion"] == $b["Puntuacion"]){
    return 0;
  }
  return ($a["Puntuacion"] > $b["Puntuacion"]) ? -1 : 1;
}

include '../php/DbConfig.php';
$conn = mysqli_connect($server, $user, $pass, $basededatos) or die("No se puede comunicar con el servidor");
$sql_query = "SELECT * FROM nicknames";
$result = $conn->query($sql_query);
$nick_list = array();
if ($result->num_rows > 0) {
  echo "<table id='data'><caption style'font-weight:bold;' >Lista de los mejores 10 quizers</caption><thead><tr><th>Nick</th><th>Aciertos</th><th>Fallos</th><th>Puntuación</th></tr></thead><tbody>";
  while($row = $result->fetch_assoc()) {
    $nick_list[] = $row;
  }
  usort($nick_list, "orderByScore");
  $total = min(count($nick_list), 10);
  for ($i = 0; $i < $total; $i++){
    echo "<tr><td><span style='color:brown;font-size:x-large;'>" .
    $nick_list[$i]["Nick"] .  "</span></td><td><span style='color:green;font-size:x-large;'>" .
    $nick_list[$i]["Aciertos"] .  "</span></td><td><span style='color:red;font-size:x-large;'>" .
    $nick_list[$i]["Fallos"] .  "</span></td><td><span style='color:purple;font-size:x-large;'>" .
    $nick_list[$i]["Puntuacion"] .  "</span></td></tr>";
  }
  echo "</tbody></table>";
}

?>
