<?php
session_start();
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

    // STORING EVERYTHING IN TICKET
    // $_SESSION['tickets']
    // day=>
    // 	cinema=>
    // 		time=>
    // 			seat, ticket-type

    if (!isset($_SESSION['tickets']))
    	$_SESSION['tickets'] = [];

    if (!isset($_SESSION['tickets'][$_POST['day']]))
    	$_SESSION['tickets'][$_POST['day']] = array();

    if (!isset($_SESSION['tickets'][$_POST['day']][$_POST['cinema']]))
    	$_SESSION['tickets'][$_POST['day']][$_POST['cinema']] = array();

    if (!isset($_SESSION['tickets'][$_POST['day']][$_POST['cinema']][$_POST['time']]))
    	$_SESSION['tickets'][$_POST['day']][$_POST['cinema']][$_POST['time']] = array();

    $tickets = trim($_POST['tickets']);
    $tickets = explode(' ', $tickets);

    $splitTickets = [];

    foreach ($tickets as &$ticket) {
    	$tempTicket = explode(':', $ticket);
    	array_push($splitTickets, $tempTicket);
    }

    foreach ($splitTickets as &$splitTicket) {
    	array_push($_SESSION['tickets'][$_POST['day']][$_POST['cinema']][$_POST['time']], $splitTicket);
    }
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
<p class="subtitle">EMAIL ADDRESS<br/><input ng-change="fullValidate()" type='text' name="email" data-ng-model="email" placeholder="me@gmail.com"/></p><br/>

<div class="error" data-ng-repeat="error in errors">
    {{error}}
</div>
<hr>

<div class="subtitle">TOTAL PRICE: 
    <div class="hero enlarge" id="price">$<?php echo $_SESSION['totalPrice']; ?></div>
</div>
<hr>
<div class="caption">
	PURCHASED TICKETS
</div>
<?php 
foreach ($_SESSION['tickets'] as $day => $dayVal) {
	foreach ($dayVal as $cinema => $cinemaVal) {
		foreach ($cinemaVal as $time => $timeVal) {
			foreach ($timeVal as $seat) {
				echo '<p class="subtitle">', $day, ' ', $cinema, ' ', $time, ' ',  $seat[0], ' - ', $seat[1],  '</p>';
			}
		}
	}
} ?>
<br/>
<input class="last" data-ng-disabled="!isValid" type="submit" value="Reserve tickets"/>
</form>

<?php include_once("footer.php"); ?>
