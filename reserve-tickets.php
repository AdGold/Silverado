<?php
session_start();
//* test stuff...
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
<p>Thank you for reserving tickets, your receipt is below</p>

<p>TODO: style receipt</p>

<p>
<?php echo $name; ?><br/>
<?php echo $email; ?><br/>
<?php echo $phone; ?><br/>

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
            echo getMovie($time, $titles) . " on $day at $time" . "pm at Cinema $cinema <br/>\n";
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
                echo "$ticket x $count at $" . $price . " each = $tickettotal <br/>\n";
                $movietotal += $tickettotal;
            }
            echo "Movie subtotal = $movietotal <br/>\n";
            $total += $movietotal;
        }
    }
}
echo "Total: $total<br/>\n";


foreach($_SESSION['tickets'] as $day => $daytickets)
{
    foreach($daytickets as $cinema => $cinematickets)
    {
        foreach ($cinematickets as $time => $timetickets)
        {
            foreach ($timetickets as $ticket)
            {
                echo "================TICKET================<br/>\n";
                echo "Cinema $cinema <br/>\n $day $time:00pm <br/>\n" . getMovie($time, $titles) . "<br/>\n";
                echo "$ticket[1] Ticket <br/>\nSeat $ticket[0]<br/>\n";
            }
        }
    }
}

?>
</p>
<?php session_destroy(); include_once("footer.php"); ?>
