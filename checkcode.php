<?php
include_once('codevalidation.php');
$code = $_POST['code'];
echo checkcode($code);
?>
