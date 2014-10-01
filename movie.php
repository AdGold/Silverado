<?php include_once("header.php"); ?>
<h3>BOOK A MOVIE</h3>
<hr/>
<div class="columns">
    <div class="left_column">
        <p class="subtitle">Use the form below to book tickets to our films!</p>
        <form method="POST" action="http://titan.csit.rmit.edu.au/~e54061/wp/form-tester-2.php">
            <div class="subsection">
                <div class="subtitle gap hero">CINEMA</div>
                <input type="radio" name="cinema" value="Maxima" data-ng-model="cinema" data-ng-change="cinemaChange()"/>Cinema Maxima
                <input type="radio" name="cinema" value="Rivola" data-ng-model="cinema" data-ng-change="cinemaChange()"/>Cinema Rivola
            </div>

            <div class="subsection">
                <div class="subtitle gap hero">DAY</div>
                    <select data-ng-model='day' data-ng-options='d.day for d in days' data-ng-change='dayChange()'>
                    </select>
                    <input type="hidden" name="day" data-ng-value='day.day'/>
            </div>

            <div class="subsection">
                <div class="subtitle gap hero">TIME</div>
                    <select data-ng-model='time' data-ng-options='t.time+"pm - "+movies[t.genre] for t in times' data-ng-change='timeChange()'>
                    </select>
                    <input type="hidden" name="time" data-ng-value='time.time'/>
            </div>

            <div class="subsection">
                <b></b>
                <div class="caption gap hero">{{movies[time.genre]}} ({{time.genre}}) - Tickets</div>
                <table>
                    <tr data-ng-repeat='ticket in tprices'>
                        <td>{{ticket.type}}</td>
                        <td>${{ticket.price}}</td>
                        <td><input type="number" name="{{ticket.type}}" min="0" max="100" step="1" data-ng-model='ticket.count'></td>
                    </tr>
                </table>
                <input type="hidden" name="normal-seats" data-ng-value="normalSeats"/>
                <input type="hidden" name="first-class-seats" data-ng-value="firstClassSeats"/>
                <input type="hidden" name="beanbag-seats" data-ng-value="beanbagSeats"/>
                <input type="hidden" name="price" data-ng-value="totalPrice"/>
                <br>
                <div class="subtitle">TOTAL PRICE: 
                    <div class="hero enlarge">${{totalPrice}}</div>
                </div>
                <div class="error" data-ng-repeat="error in errors track by $index">
                    {{error}}
                </div>
                <br/>
                <input class="bottom big_submit" type="submit" value="Book tickets" data-ng-disabled="!isValid"/>
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
