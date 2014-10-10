<?php
session_start();
$cinema = $_POST['cinema'];
$day = $_POST['day'];
$time = $_POST['time'];
$xml = simplexml_load_file("seats.xml");

$result = $xml->xpath("/seats/$day/$cinema/x$time");
$xmlseats = $result[0];

$incart = array();
if (isset($_SESSION['tickets'][$day][$cinema][$time]['seats']))
    $incart = $_SESSION['tickets'][$day][$cinema][$time]['seats'];

foreach($xmlseats->children() as $xmlseat)
{
    if ($xmlseat['full'] == 'false')
    {
        //echo "checking " . $xmlseat->getName() . "<br>";
        $good = true;
        foreach ($incart as $beingbooked)
        {
            //echo $beingbooked . " in cart <br>";
            if ($beingbooked == $xmlseat->getName())
                $good = false;
        }
        if ($good)
            echo $xmlseat->getName() . ' ';
    }
}
?>
