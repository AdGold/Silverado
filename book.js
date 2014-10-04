booking = angular.module('booking', []);

booking.controller('bookingController', function($scope, $http) {
    $scope.movieChange = function() {
        if ($scope.movies.hasOwnProperty($scope.movie))
            $('#movieDescription').html($scope.movies[$scope.movie]);
        else
        {
            var data = "CRC=s3493577&filmID="+$scope.movie;
            var header = {headers: {'Content-Type': 'application/x-www-form-urlencoded'} };
            $http.post("http://"+server+"/~e54061/wp/movie-service.php" ,
                data, header).success(function(data) {
                    $scope.movies[$scope.movie] = data;
                    $('#movieDescription').html(data);
            });
        }
        if ($scope.cinema != 'Rivola' && $scope.cinema != 'Maxima' ||
            $scope.cinema == 'Rivola' && !$scope.details[$scope.movie].hasOwnProperty('Rivola') )
            $scope.cinema = 'Maxima';
        if ($scope.cinema == 'Maxima' && !$scope.details[$scope.movie].hasOwnProperty('Maxima'))
            $scope.cinema = 'Rivola';
        $scope.cinemaChange();
    }
    $scope.cinemaChange = function() {
        $scope.days = $scope.details[$scope.movie][$scope.cinema].days;
        $scope.time = $scope.details[$scope.movie][$scope.cinema].time;
        $scope.day = $scope.days[0];
        $scope.dayChange();
    };
    $scope.dayChange = function() {
        $scope.totalPrice = 0;
        $scope.tprices = $scope.prices[$scope.cinema][$scope.day][$scope.time];
        var data = 'cinema='+$scope.cinema+'&day='+$scope.day+'&time='+$scope.time;
        var header = {headers: {'Content-Type': 'application/x-www-form-urlencoded'} };
        $http.post('seatsleft.php', data, header).success(function(data) {
            var seats = data.trim().split(' ');
            $scope.seatsLeft = {};
            for (var i in seats)
            {
                if (seats[i].length == 0) continue;
                var tickets = $scope.getTicketTypes(seats[i], $scope.cinema);
                $scope.seatsLeft[seats[i]] = {types:tickets, type:tickets[0], price:$scope.tprices[tickets[0]]};
            }
            $scope.anySeatsLeft = Object.keys($scope.seatsLeft).length > 0;
            $scope.anySeatsLeft = Object.keys($scope.seatsLeft).length > 0;
        });
    };
    $scope.seatChange = function(seat)
    {
        var oldPrice = parseInt($scope.seatsLeft[seat].price);
        var newPrice = $scope.tprices[$scope.seatsLeft[seat].type];
        $scope.seatsLeft[seat].price = newPrice;
        newPrice = parseInt(newPrice);
        $scope.totalPrice += newPrice-oldPrice;
        $scope.isValid = true;
        $scope.updateTickets();
    }
    $scope.updateTickets = function()
    {
        $scope.ticketString = '';
        for (var seat in $scope.seatsLeft)
        {
            if ($scope.seatsLeft[seat].type != 'None')
            {
                $scope.ticketString += seat + ':' + $scope.seatsLeft[seat].type + ' ';
            }
        }
    }
    $scope.getTicketTypes = function(seatName, cinema)
    {
        if (cinema == 'Rivola') return ['None', 'Adult', 'Conc', 'Child'];
        else if (seatName[0] <= 'D') return ['None', 'Beanbag'];
        else if (seatName[1] == '0' && '6' <= seatName[2]) return ['None', 'FirstClass-Adult', 'FirstClass-Child'];
        else return ['None', 'Adult', 'Conc', 'Child'];
    }
    $scope.movies = {};
    maxPriceMon_Tue = {
        'Adult':12, 'Conc':10, 'Child':8, 'FirstClass-Adult':25, 'FirstClass-Child':20, 'Beanbag':20, 'None':0
    };
    maxPriceWed_Sun = {
        'Adult':18, 'Conc':15, 'Child':12, 'FirstClass-Adult':30, 'FirstClass-Child':25, 'Beanbag':30, 'None':0
    };
    rivPriceWed_Fri12 = { 'Adult':12, 'Conc':10, 'Child':8, 'None':0 };
    rivPriceWed_Fri = { 'Adult':18, 'Conc':15, 'Child':12, 'None':0 };
    rivPriceSat_Sun = { 'Adult':18, 'Conc':15, 'Child':12, 'None':0 };
    allDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    Wed_Sun  = ['Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    Wed_Fri  = ['Wednesday', 'Thursday', 'Friday'];
    Sat_Sun  = ['Saturday', 'Sunday'];
    $scope.details = {
        RC:{ Maxima:{time:'6', days:allDays} },
        CH:{ Maxima:{time:'3', days:Sat_Sun}, Rivola:{time:'12', days:Wed_Fri} },
        FO:{ Rivola:{time:'7', days:Wed_Sun} },
        AC:{ Maxima:{time:'9', days:allDays}, Rivola:{time:'4', days:Sat_Sun}  }
    };
    $scope.prices = {
        Maxima:{
            Monday:{'6':maxPriceMon_Tue, '9':maxPriceMon_Tue},
            Tuesday:{'6':maxPriceMon_Tue, '9':maxPriceMon_Tue},
            Wednesday:{'6':maxPriceWed_Sun, '9':maxPriceWed_Sun},
            Thursday:{'6':maxPriceWed_Sun, '9':maxPriceWed_Sun},
            Friday:{'6':maxPriceWed_Sun, '9':maxPriceWed_Sun},
            Saturday:{'3':maxPriceWed_Sun, '6':maxPriceWed_Sun, '9':maxPriceWed_Sun},
            Sunday:{'3':maxPriceWed_Sun, '6':maxPriceWed_Sun, '9':maxPriceWed_Sun}
        },
        Rivola:{
            Wednesday:{'12':rivPriceWed_Fri12, '7':rivPriceWed_Fri},
            Thursday:{'12':rivPriceWed_Fri12, '7':rivPriceWed_Fri},
            Friday:{'12':rivPriceWed_Fri12, '7':rivPriceWed_Fri},
            Saturday:{'4':rivPriceSat_Sun, '7':rivPriceSat_Sun},
            Sunday:{'4':rivPriceSat_Sun, '7':rivPriceSat_Sun}
        }
    };

    //startup
    $scope.movie = 'RC';
    $scope.movieChange();
});
