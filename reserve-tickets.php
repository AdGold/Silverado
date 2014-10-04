<?php
session_start();
$email = $_POST['email'];
$phone = $_POST['phone'];
$name = $_POST['name'];
$code = $_POST['code'];
$page_title = "Tickets Reserved";
$hide_cart = true;
include_once("header.php");

$xml = simplexml_load_file("seats.xml");
foreach($_SESSION['tickets'] as $day => $daytickets)
{
    $xday = $xml->xpath($day);
    foreach($daytickets as $cinema => $cinematickets)
    {
        $xcinema = $xday->xpath($cinema);
        foreach ($cinematickets as $time => $timetickets)
        {
            $xtime = $xcinema->xpath('x' . $time);
            foreach ($timetickets as $ticket)
            {
                $xseat = $xtime->xpath($ticket[0]);
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
