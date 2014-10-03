<?php
session_start();
$cinema = $_POST['cinema'];
$day = $_POST['day'];
$time = $_POST['time'];
//$cinema = 'Rivola';
//$day = 'Monday';
//$time = '9';
$xml = simplexml_load_file("seats.xml");
$seats = array();

foreach($xml->children() as $xmlday)
{
    if ($xmlday->getName() == $day)
    {
        foreach($xmlday->children() as $xmlcinema)
        {
            if ($xmlcinema->getName() == $cinema)
            {
                foreach($xmlcinema->children() as $xmltime)
                {
                    if ($xmltime->getName() == "x" . $time)
                    {
                        foreach($xmltime->children() as $xmlseat)
                        {
                            if ($xmlseat['full'] == 'false')
                                array_push($seats, $xmlseat->getName());
                        }
                        break;
                    }
                }
                break;
            }
        }
        break;
    }
}
foreach($seats as $seat)
{
    echo $seat . " ";
}
?>
