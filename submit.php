<?php
if (isset($_SESSION['cart']))
{
    $_SESSION['totalPrice'] += $_POST['price'];
}
else
{
    $_SESSION['cart'] = 'woo';
    $_SESSION['totalPrice'] = $_POST['price'];
}
$page_title = "Reserve tickets";
include_once("header.php");
?>

<p> TODO - add reserve ticket stuff here... </p>

<?php include_once("footer.php"); ?>
