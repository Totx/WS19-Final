
<?php

$d = "../xml/Counter.xml";
$xml=simplexml_load_file($d) or die("<p>El fichero XML no esta accesible</p>");
$xml->counter--;
$xml->asXML($d);

 ?>
