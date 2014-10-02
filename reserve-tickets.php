<?php
session_start();
session_destroy();
$page_title = "Tickets Reserved";
include_once("header.php");
?>
<h3>Tickets Reserved Successfully</h3>
<hr />
<p>Thank you for reserving tickets, your receipt is below</p>

<p>TODO: add receipt</p>

<?php include_once("footer.php"); ?>
