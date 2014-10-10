<?php $page_title = "Book"; include_once("header.php"); ?>
<?php include_once("moviedata.php"); ?>
<h3>BOOK A MOVIE</h3>
<hr/>
<div class="columns">
    <div class="left_column">
        <p class="subtitle">Use the form below to book tickets to our films!</p>
        <form method="POST" action="reserve.php">
            <div class="subsection">
                <div class="subtitle gap hero">MOVIE</div>
                <select name="film" class="film" data-ng-model="movie" data-ng-change="movieChange()">
                    <?php
                    foreach($types as $type) { 
                        echo '<option value="' . $type . '">' . $titles[$type] . "</option>\n";
                    }
                    ?>
                </select>
            </div>
            <div class="subsection">
                <div class="subtitle gap hero">CINEMA</div>
                <input type="radio" name="cinema" value="Maxima" data-ng-model="cinema" data-ng-change="cinemaChange()" data-ng-disabled="!details[movie].hasOwnProperty('Maxima')">Cinema Maxima
                <input type="radio" name="cinema" value="Rivola" data-ng-model="cinema" data-ng-change="cinemaChange()" data-ng-disabled="!details[movie].hasOwnProperty('Rivola')">Cinema Rivola
            </div>

            <div class="subsection">
                <div class="subtitle gap hero">DAY</div>
                    <select class="day" data-ng-model='day' data-ng-options='d+" "+time+"pm" for d in days' data-ng-change='dayChange()'>
                    </select>
                    <input type="hidden" name="day" data-ng-value='day'/>
                    <input type="hidden" name="time" data-ng-value='time'/>
            </div>

            <div class="subsection">
                <div class="caption gap hero">TICKETS</div>
                <table>
                    <tr data-ng-repeat='(ticket,price) in tprices'>
                        <td>{{ticket}}</td>
                        <td>${{price}}</td>
                        <td><input type="number" min="0" max="100" step="1" data-ng-model='tcounts[ticket]'></td>
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
            </div>
            <div class="subsection">
                <div class="caption gap hero">CHOOSE SEATS</div>
                {{cinemaCapacity}}
                [['{{left}}']]
                <table>
                    <tr>
                        <td rowspan='2'>Left to place</td>
                        <td>Standard seats</td>
                        <td>First Class seats</td>
                        <td>Beanbag seats</td>
                    </tr>
                    <tr>
                        <td>{{left['n']}}</td>
                        <td data-ng-if='cinema=="Maxima"'>{{left['f']}}</td>
                        <td data-ng-if='cinema=="Maxima"'>{{left['b']}}</td>
                    </tr>
                </table>
                <?php include_once("seats.php"); ?>
                <br>
                <input class="bottom big_submit" type="submit" value="Add to cart" data-ng-disabled="!isValid"/>
            </div>
        </form>
    </div>
    <div class="right_column">
        <div data-ng-bind="movieHTML" data-compile-template></div>
        <div id="movieDescription"></div>
    <!--
        <p class="caption">Cheapest prices in town.</p>
        <p class="subtitle small">We have the cheapest prices anywhere, we won't be beaten on value!</p>
        <hr>
        <p class="caption">Change your seat to your desire.</p>
        <p class="subtitle small">Our variety of special seats will have you craving for more!</p>
    -->
    </div>
</div>
<?php include_once("footer.php"); ?>
