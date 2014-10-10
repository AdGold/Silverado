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
            foreach ($timetickets['seats'] as $ticket)
            {
                $result = $xml->xpath("$day/$cinema/x$time/$ticket");
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
$all = "";
foreach($_SESSION['tickets'] as $day => $daytickets)
{
    foreach($daytickets as $cinema => $cinematickets)
    {
        foreach ($cinematickets as $time => $timetickets)
        {
            $movietotal = 0;
            $line = getMovie($time, $titles) . " on $day at $time" . "pm at Cinema $cinema";
            $all .= $line . "\n";
            echo "<p class='date'>$line</p>\n";
            foreach ($timetickets as $ticket => $count)
            {
                if ($ticket == 'seats' || $count == 0) continue;
                $price = $ticketPrices[$cinema][$day][$time][$ticket];
                $tickettotal = $price * $count;
                $line1 = "$ticket x $count ";
                $line2 = " at $" . $price . " each = $$tickettotal";
                $all .= $line1 . $line2 . "\n";
                echo "<p class='ticketCount'>$line1</p><p class='price'>$line2</p>\n";
                $movietotal += $tickettotal;
            }
            $line = "Movie Subtotal: $$movietotal";
            $all .= $line . "\n";
            echo "<p class='subtotal'>$line</p>\n";
            $total += $movietotal;
        }
    }
}
if (checkcode($code))
{
    $line = "SubTotal: $$total";
    $all .= $line . "\n";
    echo "<p class='total'>$line</p>\n";
    $line = "Promotional code: $code - 20% off";
    $all .= $line . "\n";
    echo "<p class='promo'>Promotional code: $code - 20% off</p>\n";
    $total *= 0.8;
}
$line = "Total: $" . number_format($total, 2);
$all .= $line . "\n";
echo "<p class='total'>Total: $$total</p></div>\n";


foreach($_SESSION['tickets'] as $day => $daytickets)
{
    foreach($daytickets as $cinema => $cinematickets)
    {
        foreach ($cinematickets as $time => $timetickets)
        {
            foreach ($timetickets['seats'] as $ticket)
            {
                $movie = getMovie($time, $titles);
                $fileTicket = "\n" . 
"==============TICKET==============\n" . 
" Cinema $cinema, $day $time:00pm\n" . 
"            $movie\n" . 
"Seat $ticket\n" .
"For the best viewing experience,\n" .
"    Visit Silverado!\n" .
"\n";
                $all .= $fileTicket . "\n";
                echo "<div class='ticket'>TICKET\n";
                echo "<p class='mono'>Cinema $cinema</p>\n<p class='mono'>$day $time:00pm</p>\n<p class='mono'>" . getMovie($time, $titles) . "</p>\n";
                echo "<p class='mono'>Ticket</p>\n<p class='mono'>Seat $ticket</p><br/><p class='logoCaption'>For the best viewing experience,</p><p class='logoCaption indented'>Visit Silverado!</p></div>\n";
            }
        }
    }
}
$filename = $name . "_" . date('Y-m-d_H:i:s');
file_put_contents("receipts/$filename.txt", $all);
?>
<?php session_destroy(); include_once("footer.php"); ?>
