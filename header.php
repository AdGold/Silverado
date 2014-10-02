<?php session_start() ?>
<!DOCTYPE html>
<html <?php if ($page_title == "Book") { ?> data-ng-app="booking" <?php } ?> >
    <head>
        <meta charset="utf-8">
        <title><?php echo $page_title; ?></title>
        <link rel=stylesheet href="css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script>
            <?php echo 'var server="' . $_SERVER['SERVER_NAME'] . '";'; ?>
        </script>
        <?php if ($page_title == "Book") { ?>
            <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js'></script>
            <script src="movie.js"></script>
        <?php } if ($page_title == "Movies") { ?>
            <script src="movies.js"></script>
        <?php } ?>
    </head>
    <body <?php if ($page_title == "Book") { ?> data-ng-controller="bookingController" <?php } ?> >
        <div class="container">
            <header>
                <div id="titleBar">
                        <a class="fadeIn" href="index.php">SILVERADO</a>
                </div>
            </header>
            <nav>
                <div class="navigation">
                    <ul>
                        <li><a class="fadeIn" href="index.php">HOME</a></li>
                        <li><a class="fadeIn" href="prices.php">PRICES</a></li>
                        <li><a class="fadeIn" href="movies.php">MOVIES</a></li>
                        <li><a class="fadeIn" href="movie.php">BOOK</a></li>
                        <li><a class="fadeIn" href="contact.php">CONTACT</a></li>
                    </ul>
                </div>
                <?php if (isset($_SESSION['cart'])) { ?>
                <div class="cart">
                    <a href="movie.php">Cart Total: $<?php echo $_SESSION['totalPrice'] ?></a>
                </div>
                <?php } ?>
            </nav>
            <main class="wrapper">
