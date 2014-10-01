<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><php? echo $page_title; ?></title>
        <link rel=stylesheet href="css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        if ($page_title == "movie")
        {
            <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js'></script>
            <script scr="movie.js"></script>
        }
    </head>
    <body>
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
            </nav>
            <main class="wrapper">
