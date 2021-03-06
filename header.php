<?php
if (session_status() == PHP_SESSION_NONE) {
        session_start();
} ?>
<!DOCTYPE html>
<html<?php if ($page_title == "Book") { echo ' data-ng-app="booking"'; } elseif ($page_title == "Reserve Tickets") { echo ' data-ng-app="reserve"'; } ?>>
    <head>
        <meta charset="utf-8">
        <title><?php echo $page_title; ?></title>
        <link rel=stylesheet href="css/style.css">
        <?php if($page_title == "Book") { ?>
        <link rel=stylesheet href="css/seats.css">
        <?php } ?>
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js'></script>
        <script>
            <?php echo 'var server="' . $_SERVER['SERVER_NAME'] . '";'; ?>
        </script>
        <?php
        $file_name = str_replace(" ", "_", strtolower($page_title)) . ".js";
        if (file_exists($file_name))
        {
            echo "<script src='$file_name'></script>";
        }
        ?>
    </head>
    <body<?php if ($page_title == "Book") { echo ' data-ng-controller="bookingController"'; } elseif ($page_title == "Reserve Tickets") { echo ' data-ng-controller="reserveController"'; } ?>>
        <div class="container">
            <header>
                <div id="titleBar">
                        <a class="fadeIn" href="index.php">SILVERADO</a>
                </div>
            </header>
            <nav>
                <div class="navigation">
                    <ul>
                        <a class="fadeIn" href="index.php"><li>HOME</li></a>
                        <a class="fadeIn" href="prices.php"><li>PRICES</li></a>
                        <a class="fadeIn" href="movies.php"><li>MOVIES</li></a>
                        <a class="fadeIn" href="book.php"><li>BOOK</li></a>
                        <a class="fadeIn" href="contact.php"><li>CONTACT</li></a>
                    <?php 
                    if (isset($_SESSION['cart']) && !isset($hide_cart)) { ?>
                        <li id="cart"><a class="fadeIn" href="reserve.php">CART TOTAL: $<?php echo $_SESSION['totalPrice'] ?></a></li>
                    <?php } ?>
                    </ul>
                </div>
            </nav>
            <main class="wrapper">
