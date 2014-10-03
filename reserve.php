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
<hr/>

<p class="subtitle">NAME<br/><input ng-change="fullValidate()" type='text' data-ng-model='name' placeholder='John Doe'></p><br/>
<p class="subtitle">PHONE NUMBER<br/><input ng-change="fullValidate()" type='text' data-ng-model='phone' placeholder='04 9090 8080'></p><br/>
<p class="subtitle">EMAIL ADDRESS<br/><input ng-change="fullValidate()" type='text' data-ng-model="email" placeholder="me@me.com"></p><br/>

<div class="error" data-ng-repeat="error in errors">
    {{error}}
</div>
<hr>

<div class="subtitle">TOTAL PRICE: 
    <div class="hero enlarge" id="price">$<?php echo $_SESSION['totalPrice']; ?></div>
</div>
<br/>
<form method="POST" action="reserve-tickets.php">
<input data-ng-disabled="!isValid" type="submit" value="Reserve tickets"/>
</form>

<?php include_once("footer.php"); ?>
