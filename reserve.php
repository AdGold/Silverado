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
}
$page_title = "Reserve Tickets";
include_once("header.php");
?>

<h3>RESERVE TICKETS</h3>
<hr />

<p class="subtitle">You can choose to reserve your tickets right now if you wish. <br/>You can also browse the website and add more tickets or return to your cart if you wish!</p>
<p>Enter promotional code (optional): <input data-ng-model="voucher" data-ng-change="validate()" type='text' id='code' placeholder='Enter code'/></p>
<p>{{result}}</p>
<br/>
<div class="subtitle">TOTAL PRICE: 
    <div class="hero enlarge" id="price">$<?php echo $_SESSION['totalPrice']; ?></div>
</div>
<br/>
<form method="POST" action="reserve-tickets.php">
<input type="submit" value="Reserve tickets"/>
</form>

<?php include_once("footer.php"); ?>
