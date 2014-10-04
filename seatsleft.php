<?php
session_start();
$cinema = $_POST['cinema'];
$day = $_POST['day'];
$time = $_POST['time'];
//$cinema = 'Maxima';
//$day = 'Monday';
//$time = '9';
$xml = simplexml_load_file("seats.xml");

$result = $xml->xpath("/seats/$day/$cinema/x$time");
$xmlseats = $result[0];
foreach($xmlseats->children() as $xmlseat)
{
    if ($xmlseat['full'] == 'false')
        echo $xmlseat->getName() . ' ';
}
?>
