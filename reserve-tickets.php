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

//test stuff...
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
<p>Thank you for reserving your tickets, your receipt is below.</p>

<div class='majorTicket'>
<?php echo "<p class='name'>", $name, "</p>"; ?>
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
                echo "<p class='ticketCount'> $ticket x $count</p><p class='price'> at $" . $price . " each = $$tickettotal.</p>\n";
                $movietotal += $tickettotal;
            }
            echo "<p class='subtotal'>Movie Subtotal: $$movietotal</p>\n";
            $total += $movietotal;
        }
    }
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
                echo "<p class='ticket'>================TICKET================<br/>\n";
                echo "Cinema $cinema <br/>\n $day $time:00pm <br/>\n" . getMovie($time, $titles) . "<br/>\n";
                echo "$ticket[1] Ticket <br/>\nSeat $ticket[0]</p>\n";
            }
        }
    }
}

?>
</p>
<?php session_destroy(); include_once("footer.php"); ?>
