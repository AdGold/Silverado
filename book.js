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
        for (var ticket in $scope.tprices)
        {
            $scope.tcounts[ticket] = 0;
        }
        $scope.resetSeats();
        var data = 'cinema='+$scope.cinema+'&day='+$scope.day+'&time='+$scope.time;
        var header = {headers: {'Content-Type': 'application/x-www-form-urlencoded'} };
        $http.post('seatsleft.php', data, header).success(function(data) {
            var seats = data.trim().split(' ');
            $scope.cinemaCapacity = { Maxima:{b:13, f:12, n:40}, Rivola:{b:0, f:0, n:40} }
            for (var i in seats)
            {
                if (seats[i].length == 0) continue;
                var type = $scope.getTicketType(seats[i], $scope.cinema);
                $scope.cinemaCapacity[$scope.cinema][type] -= 1;
                $scope.seatClasses[$scope.cinema][seats[i]][type+'taken'] = true;
                $scope.seatClasses[$scope.cinema][seats[i]][type+'empty'] = false;
                $scope.seatClasses[$scope.cinema][seats[i]][type+'selected'] = false;
            }
            $scope.calculateValidate();
        });
    };
    $scope.seatClick = function(seat)
    {
        var type = $scope.getTicketType(seat, $scope.cinema);
        if ($scope.seatClasses[$scope.cinema][seat][type+'taken']) return;
        if ($scope.seatClasses[$scope.cinema][seat][type+'empty'])
        {
            $scope.seatClasses[$scope.cinema][seat][type+'empty'] = false;
            $scope.seatClasses[$scope.cinema][seat][type+'selected'] = true;
        }
        else
        {
            $scope.seatClasses[$scope.cinema][seat][type+'empty'] = true;
            $scope.seatClasses[$scope.cinema][seat][type+'selected'] = false;
        }
    }
    $scope.getTicketType = function(seatName, cinema)
    {
        if (cinema == 'Rivola') return 'n';
        else if (seatName[0] <= 'D') return 'b';
        else if (seatName[1] == '0' && '6' <= seatName[2]) return 'f';
        else return 'n';
    }
    $scope.calculateValidate = function() {
        $scope.totalPrice = 0;
        $scope.normalSeats = 0;
        $scope.firstClassSeats = 0;
        $scope.beanbagSeats = 0;
        $scope.isValid = true;
        for (var ticket in $scope.tprices)
        {
            if ($scope.tcounts[ticket] % 1 != 0) $scope.isValid=false;
            $scope.totalPrice += $scope.tprices[ticket] * $scope.tcounts[ticket];
            if (ticket == 'Beanbag')
                $scope.beanbagSeats += $scope.tcounts[ticket];
            else if (ticket.indexOf('FirstClass') > -1)
                $scope.firstClassSeats += $scope.tcounts[ticket];
            else
                $scope.normalSeats += $scope.tcounts[ticket];
        }
        $scope.errors = [];
        if ($scope.normalSeats > $scope.cinemaCapacity[$scope.cinema]['n'])
        {
            $scope.errors.push('Too many standard seats booked');
            $scope.isValid = false;
        }
        if ($scope.firstClassSeats > $scope.cinemaCapacity[$scope.cinema]['f'])
        {
            $scope.errors.push('Too many First Class seats booked');
            $scope.isValid = false;
        }
        if ($scope.beanbagSeats > $scope.cinemaCapacity[$scope.cinema]['b'])
        {
            $scope.errors.push('Too many beanbag seats booked');
            $scope.isValid = false;
        }
    }
    $scope.$watch('tcounts', function(newValue, oldValue) {
        $scope.calculateValidate();
    }, true);
    $scope.movies = {};
    $scope.tcounts = {};
    maxPriceMon_Tue = {
        'Adult':12, 'Conc':10, 'Child':8, 'FirstClass-Adult':25, 'FirstClass-Child':20, 'Beanbag':20
    };
    maxPriceWed_Sun = {
        'Adult':18, 'Conc':15, 'Child':12, 'FirstClass-Adult':30, 'FirstClass-Child':25, 'Beanbag':30
    };
    rivPriceWed_Fri12 = { 'Adult':12, 'Conc':10, 'Child':8 };
    rivPriceWed_Fri = { 'Adult':18, 'Conc':15, 'Child':12 };
    rivPriceSat_Sun = { 'Adult':18, 'Conc':15, 'Child':12 };
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
    $scope.resetSeats = function()
    {
        var rows = "ABCDEFGH";
        for (var i in rows)
        {
            for (var col = 1; col < 15; col++)
            {
                var seat = rows[i] + ((col < 10)?'0':'') + col.toString();
                var cinemas = ['Maxima', 'Rivola'];
                for (var c in cinemas)
                {
                    var type = $scope.getTicketType(seat, cinemas[c]);
                    $scope.seatClasses[cinemas[c]][seat] = {};
                    $scope.seatClasses[cinemas[c]][seat][type+'seat'] = true;
                    $scope.seatClasses[cinemas[c]][seat][type+'empty'] = true;
                    $scope.seatClasses[cinemas[c]][seat][type+'selected'] = false;
                    $scope.seatClasses[cinemas[c]][seat][type+'taken'] = false;
                }
            }
        }
    }

    //startup
    $scope.movie = 'RC';
    $scope.seatClasses = {'Maxima':{}, 'Rivola':{}};
    $scope.movieChange();
    $scope.resetSeats();
});
