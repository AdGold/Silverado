<?php
session_start();
include_once("moviedetails.php");
if (isset($_POST['cinema']))
{
    if (isset($_SESSION['cart']))
    {
        $_SESSION['totalPrice'] += $_POST['price'];
    }
    else
    {
        $_SESSION['cart'] = 'woo';
        $_SESSION['totalPrice'] = $_POST['price'];
    }

    $day = $_POST['day'];
    $cinema = $_POST['cinema'];
    $time = $_POST['time'];
    $ticketTypes = $ticketPrices[$cinema][$day][$time];

    // STORING EVERYTHING IN TICKET
    // $_SESSION['tickets']
    // day=>
    // 	cinema=>
    // 		time=>
    // 			seat

    if (!isset($_SESSION['tickets']))
        $_SESSION['tickets'] = [];

    if (!isset($_SESSION['tickets'][$day]))
        $_SESSION['tickets'][$day] = array();

    if (!isset($_SESSION['tickets'][$day][$cinema]))
        $_SESSION['tickets'][$day][$cinema] = array();

    if (!isset($_SESSION['tickets'][$day][$cinema][$time]))
        $_SESSION['tickets'][$day][$cinema][$time] = array();

    if (!isset($_SESSION['tickets'][$day][$cinema][$time]['seats']))
        $_SESSION['tickets'][$day][$cinema][$time]['seats'] = array();

    foreach ($ticketTypes as $type => $ignore)
    {
        if (!isset($_SESSION['tickets'][$day][$cinema][$time][$type]))
            $_SESSION['tickets'][$day][$cinema][$time][$type] = 0;
        if (isset($_POST[$type]))
            $_SESSION['tickets'][$day][$cinema][$time][$type] += $_POST[$type];
    }

    $tickets = trim($_POST['tickets']);
    $tickets = explode(' ', $tickets);
    foreach ($tickets as &$ticket) {
        array_push($_SESSION['tickets'][$day][$cinema][$time]['seats'], $ticket);
    }

    /*
    $splitTickets = [];

    foreach ($tickets as &$ticket) {
        $tempTicket = explode(':', $ticket);
        array_push($splitTickets, $tempTicket);
    }

    foreach ($splitTickets as &$splitTicket) {
        array_push($_SESSION['tickets'][$_POST['day']][$_POST['cinema']][$_POST['time']], $splitTicket);
    }*/
}
$page_title = "Reserve Tickets";
include_once("header.php");
?>

<h3>RESERVE TICKETS</h3>
<hr />

<form method="POST" action="reserve-tickets.php">
<p class="subtitle">You can choose to reserve your tickets right now if you wish. <br/>You can also browse the website and add more tickets or return to your cart if you wish!</p>
<p>Enter promotional code (optional): <input data-ng-model="voucher" data-ng-change="validate()" type='text' id="code" name='code' placeholder='Enter code'/></p>
<p>{{result}}</p>
<hr/>

<p class="subtitle">NAME<br/><input ng-change="fullValidate()" type='text' name="name" data-ng-model='name' placeholder='John Doe'/></p><br/>
<p class="subtitle">PHONE NUMBER<br/><input ng-change="fullValidate()" type='text' name="phone" data-ng-model='phone' placeholder='04 9090 8080'/></p><br/>
<p class="subtitle">EMAIL ADDRESS<br/><input ng-change="fullValidate()" type='email' name="email" data-ng-model="email" placeholder="me@gmail.com"/></p><br/>

<div class="error" data-ng-repeat="error in errors">
    {{error}}
</div>
<hr>
<br/>
<div class="caption">
    SELECTED TICKETS
</div>
<br/>
<?php 
$count = 0;
foreach ($_SESSION['tickets'] as $day => $dayVal) {
    foreach ($dayVal as $cinema => $cinemaVal) {
        foreach ($cinemaVal as $time => $timeVal) {
            $count = $count + 1;
            echo "<p class='subtitle'>$count. $day, $time" . "pm at Cinema $cinema:</p>";
            foreach ($ticketPrices[$cinema][$day][$time] as $type => $ignore)
            {
                $num = $timeVal[$type];
                if ($num > 0)
                {
                    $price = $ticketPrices[$cinema][$day][$time][$type] * $num;
                    echo "<p>$type: " . $timeVal[$type] . " x $" . $ticketPrices[$cinema][$day][$time][$type] . " = $$price</p>";
                }
            }
            //echo '<p class="subtitle">', $count, '. ', $day, ', ', $time, 'pm at Cinema ', $cinema, ': Seat ',  $seat[0], ' - ', $seat[1], " --------- $", $ticketPrices[$cinema][$day][$time][$seat[1]],  '</p>';
        }
    }
} ?>
<br>
<hr>
<div class="subtitle">TOTAL PRICE: 
    <div class="hero enlarge" id="price">$<?php echo $_SESSION['totalPrice']; ?></div>
</div>
<br/>
<input class="last" data-ng-disabled="!isValid" type="submit" value="Reserve tickets"/>
</form>

<?php include_once("footer.php"); ?>
