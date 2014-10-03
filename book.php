<?php $page_title = "Book"; include_once("header.php"); ?>
<?php

function http_post_flds($url, $data, $headers=null) {   
    $data = http_build_query($data);    
    $opts = array('http' => array('method' => 'POST', 'content' => $data, 'header' => "Content-Type: application/x-www-form-urlencoded\r\n"));

    if($headers) {
        $opts['http']['header'] = $headers;
    }
    $st = stream_context_create($opts);
    $fp = fopen($url, 'rb', false, $st);

    if(!$fp) {
        return false;
    }
    return stream_get_contents($fp);
}

$titles = array();
$types = array("RC", "CH", "FO", "AC");
foreach ($types as $type)
{
    $response=http_post_flds("http://" . $_SERVER['SERVER_NAME'] . "/~e54061/wp/movie-service.php",
            array("CRC" => "s3493577", "filmID" => $type));
    preg_match('/MS-title\'>(.*?)</', $response, $matches);
    $titles[$type] = $matches[1];
}

?>
<h3>BOOK A MOVIE</h3>
<hr/>
<div class="columns">
    <div class="left_column">
        <p class="subtitle">Use the form below to book tickets to our films!</p>
        <form method="POST" action="reserve.php">
            <div class="subsection">
                <div class="subtitle gap hero">MOVIE</div>
                <select name="film" data-ng-model="movie" data-ng-change="movieChange()">
                    <?php
                    foreach($types as $type) { 
                        echo '<option value="' . $type . '">' . $titles[$type] . "</option>\n";
                    }
                    ?>
                </select>
            </div>
            <div class="subsection">
                <div class="subtitle gap hero">CINEMA</div>
                <input type="radio" name="cinema" value="Maxima" data-ng-model="cinema" data-ng-change="cinemaChange()" data-ng-disabled="!details[movie].hasOwnProperty('Maxima')">Cinema Maxima</input>
                <input type="radio" name="cinema" value="Rivola" data-ng-model="cinema" data-ng-change="cinemaChange()" data-ng-disabled="!details[movie].hasOwnProperty('Rivola')">Cinema Rivola</input>
            </div>

            <div class="subsection">
                <div class="subtitle gap hero">DAY</div>
                    <select data-ng-model='day' data-ng-options='d+" "+time+"pm" for d in days' data-ng-change='dayChange()'>
                    </select>
                    <input type="hidden" name="day" data-ng-value='day'/>
                    <input type="hidden" name="time" data-ng-value='time'/>
            </div>

            <div class="subsection">
                <div class="caption gap hero">Seats</div>
                <table id="ticket-table">
                    <tr data-ng-repeat='(seat,info) in seatsLeft'>
                        <td>{{seat}}</td>
                        <td>${{info.price}}</td>
                        <td>
                            <select data-ng-model="info.type" data-ng-options="type+' - $'+tprices[type] for type in info.types" data-ng-change="seatChange(seat)">
                            </select>
                        </td>
                    </tr>
                </table>
                <br>
                <input type="hidden" name="price" data-ng-value="totalPrice"/>
                <input type="hidden" name="tickets" data-ng-value="ticketString"/>
                <div class="subtitle">TOTAL PRICE: 
                    <div class="hero enlarge">${{totalPrice}}</div>
                </div>
                <div class="error" data-ng-repeat="error in errors track by $index">
                    {{error}}
                </div>
                <br/>
                <input class="bottom big_submit" type="submit" value="Add to cart" data-ng-disabled="!isValid"/>
            </div>
        </form>
    </div>
    <div class="right_column">
        <p class="caption">Cheapest prices in town.</p>
        <p class="subtitle small">We have the cheapest prices anywhere, we won't be beaten on value!</p>
        <hr>
        <p class="caption">Change your seat to your desire.</p>
        <p class="subtitle small">Our variety of special seats will have you craving for more!</p>
    </div>
</div>
<?php include_once("footer.php"); ?>
