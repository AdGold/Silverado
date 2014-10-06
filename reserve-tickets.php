<?php
session_start();
//* test stuff...
// $email = $_GET['email'];
// $phone = $_GET['phone'];
// $name = $_GET['name'];
// $code = $_GET['code'];

$email = $_POST['email'];
$phone = $_POST['phone'];
$name = $_POST['name'];
$code = $_POST['code'];

$page_title = "Tickets Reserved";
$hide_cart = true;
include_once("header.php");
include_once("moviedata.php");
include_once("moviedetails.php");
include_once("codevalidation.php");

//test stuff...
//$_SESSION['tickets'] = array('Monday'=>array('Maxima'=>array('9'=>array(array('A01', 'Beanbag'), array('E07', 'FirstClass-Adult')))),'Saturday'=>array('Rivola'=>array('4'=>array(array('D05','Conc')))));
                            
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
<p>Thank you for reserving your tickets, your receipt is below.</p>

<div class='majorTicket'>
<p class="logo">SILVERADO CINEMA</p>
<?php echo "<p class='name'>", $name, "</p>"; ?>
<p class="logoCaption">Visit us again soon!</p>
<?php echo "<p class='email'>", $email, "</p>"; ?>
<?php echo "<p class='phone'>", $phone, "</p>"; ?>

<?php
$total = 0;
foreach($_SESSION['tickets'] as $day => $daytickets)
{
    foreach($daytickets as $cinema => $cinematickets)
    {
        foreach ($cinematickets as $time => $timetickets)
        {
            $movietotal = 0;
            $movietickets = array();
            echo "<p class='date'>" . getMovie($time, $titles) . " on $day at $time" . "pm at Cinema $cinema</p>\n";
            foreach ($timetickets as $ticket)
            {
                if (isset($movietickets[$ticket[1]]))
                    $movietickets[$ticket[1]] += 1;
                else
                    $movietickets[$ticket[1]] = 1;
            }
            foreach ($movietickets as $ticket => $count)
            {
                $price = $ticketPrices[$cinema][$day][$time][$ticket];
                $tickettotal = $price * $count;
                echo "<p class='ticketCount'> $ticket x $count</p><p class='price'> at $" . $price . " each = $$tickettotal</p>\n";
                $movietotal += $tickettotal;
            }
            echo "<p class='subtotal'>Movie Subtotal: $$movietotal</p>\n";
            $total += $movietotal;
        }
    }
}
if (checkcode($code))
{
    echo "<p class='total'>SubTotal: $$total</p>\n";
    echo "<p class='promo'>Promotional code: $code - 20% off</p>\n";
    $total *= 0.8;
}
echo "<p class='total'>Total: $$total</p></div>\n";


foreach($_SESSION['tickets'] as $day => $daytickets)
{
    foreach($daytickets as $cinema => $cinematickets)
    {
        foreach ($cinematickets as $time => $timetickets)
        {
            foreach ($timetickets as $ticket)
            {
                echo "<div class='ticket'>TICKET\n";
                echo "<p class='mono'>Cinema $cinema</p>\n<p class='mono'>$day $time:00pm</p>\n<p class='mono'>" . getMovie($time, $titles) . "</p>\n";
                echo "<p class='mono'>$ticket[1] Ticket</p>\n<p class='mono'>Seat $ticket[0]</p><br/><p class='logoCaption'>For the best viewing experience,</p><p class='logoCaption indented'>Visit Silverado!</p></div>\n";
            }
        }
    }
}

?>
</p>
<?php session_destroy(); include_once("footer.php"); ?>
