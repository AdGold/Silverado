<?php
session_start();
//*
$email = $_GET['email'];
$phone = $_GET['phone'];
$name = $_GET['name'];
$code = $_GET['code'];
/*/
$email = $_POST['email'];
$phone = $_POST['phone'];
$name = $_POST['name'];
$code = $_POST['code'];
*/
$page_title = "Tickets Reserved";
$hide_cart = true;
include_once("header.php");

$_SESSION['tickets'] = array('Monday'=>array('Maxima'=>array('9'=>array(array('A01', 'Beanbag'), array('E07', 'FirstClass-Adult')))),'Saturday'=>array('Rivola'=>array('4'=>array(array('D05','Conc')))));
                            
$xml = simplexml_load_file("seats.xml");
foreach($_SESSION['tickets'] as $day => $daytickets)
{
    foreach($daytickets as $cinema => $cinematickets)
    {
        foreach ($cinematickets as $time => $timetickets)
        {
            foreach ($timetickets as $ticket)
            {
                $result = $xml->xpath("$day/$cinema/x$time/$ticket[0]");
                $xseat = $result[0];
                $xseat['full'] = 'true';
                $xseat->addChild('name', $name);
                $xseat->addChild('phone', $phone);
                $xseat->addChild('email', $email);
                $xseat->addChild('code', $code);
            }
        }
    }
}

$xml->asXML("seats.xml");

?>
<h3>TICKETS RESERVED SUCCESSFULLY</h3>
<hr />
<p>Thank you for reserving tickets, your receipt is below</p>

<p>TODO: add receipt</p>

<?php session_destroy(); include_once("footer.php"); ?>
