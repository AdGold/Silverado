<?php $page_title="Prices"; include_once("header.php"); ?>
<?php include_once("moviedata.php"); ?>
<h3>PRICES</h3>
<hr/>
<p class="hero caption">
    CINEMA MAXIMA
</p>
<table>
    <thead>
        <tr>
            <th>Price List</th>
            <th>Mon - Tue</th>
            <th>Wed - Sun</th>
            <th>Schedule</th>
        </tr>
    </thead>
    <tr>
        <td>Full</td>
        <td>$12</td>
        <td>$18</td>
        <td rowspan="6">Monday - Friday:<br/>
            2 movies per day: 6pm & 9pm.<br/>
            Saturday - Sunday:<br/>
            3 movies a day: 3pm, 6pm & 9pm.</td>
    </tr>
    <tr>
        <td>Concession</td>
        <td>$10</td>
        <td>$15</td>
    </tr>
    <tr>
        <td>Child</td>
        <td>$8</td>
        <td>$12</td>
    </tr>
    <tr>
        <td>First Class - Adult</td>
        <td>$25</td>
        <td>$30</td>
    </tr>
    <tr>
        <td>First Class - Child</td>
        <td>$20</td>
        <td>$25</td>
    </tr>
    <tr>
        <td>Beanbag*</td>
        <td>$20</td>
        <td>$30</td>
    </tr>
    <tr>
        <td colspan="4" class="disclaimer">* Beanbag price allows 2 adults OR 1 adult + 1 child OR up to 3 children! One ticket fits all!</td>
    </tr>
</table>

<br/>
<p class="hero caption">
    CINEMA RIVOLA
</p>
<table>
    <thead>
        <tr>
            <th>Price List</th>
            <th>Wed - Fri (12pm)</th>  
            <th>Wed - Fri (7pm)<br/>Sat - Sun (4pm & 7pm)</th>
            <th>Schedule</th>
        </tr>
    </thead>
    <tr>
        <td>Adult</td>
        <td>$12</td>
        <td>$18</td>
        <td rowspan="3">Monday - Tuesday:<br/>
        Closed (or open for private functions)<br/>
        Wednesday - Friday:<br/>
        2 movies per day: 12pm & 7pm.<br/>
        Saturday - Sunday:<br/>
        2 movies a day: 4pm & 7pm.</td>
    </tr>
    <tr>
        <td>Concession</td>
        <td>$10</td>
        <td>$15</td>
    </tr>
    <tr>
        <td>Child</td>
        <td>$8</td>
        <td>$12</td>
    </tr>
</table>

<br/>
<p class="hero caption">
    SCHEDULE
</p>
<table class="bottom">
    <thead>
        <tr>
            <th>Cinema</th>
            <th>Mon - Tue</th>
            <th>Wed - Fri</th>
            <th>Sat - Sun</th>
        </tr>
    </thead>
    <tr>
        <th scope="row">Maxima</th>
        <td>6pm - <?php echo $titles['RC']; ?><br/>
        9pm - <?php echo $titles['AC']; ?></td>
        <td>6pm - <?php echo $titles['RC']; ?><br/>
        9pm - <?php echo $titles['AC']; ?></td>
        <td>3pm - <?php echo $titles['CH']; ?><br/>
        6pm - <?php echo $titles['RC']; ?><br/>
        9pm - <?php echo $titles['AC']; ?></td>
    </tr>
    <tr>
        <th scope="row">Rivola</th>
        <td>Closed</td>
        <td>12pm - <?php echo $titles['CH']; ?><br>
        7pm - <?php echo $titles['FO']; ?></td>
        <td>4pm - <?php echo $titles['AC']; ?><br>
        7pm - <?php echo $titles['FO']; ?></td>
    </tr>
</table>
<?php include_once("footer.php"); ?>
