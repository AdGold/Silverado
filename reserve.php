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

<h3>Reserve tickets</h3>
<hr />
<p>Either reserve tickets here or continue browsing and add more to your cart</p>
<p>Enter promotional code: <input type='text' id='code' placeholder='Enter code'/></p>
<p id="result"></p>

<form method="POST" action="reserve-tickets.php">
<input type="submit" value="Reserve tickets"/>
</form>

<?php include_once("footer.php"); ?>
