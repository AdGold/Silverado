booking = angular.module('booking', []);

booking.controller('bookingController', function($scope) {
    $scope.movieChange = function() {
        if ($scope.cinema != 'Rivola' && $scope.cinema != 'Maxima')
            $scope.cinema = 'Maxima';
        if ($scope.cinema == 'Maxima' && !$scope.details[$scope.movie].hasOwnProperty('Maxima'))
            $scope.cinema = 'Rivola';
        if ($scope.cinema == 'Rivola' && !$scope.details[$scope.movie].hasOwnProperty('Rivola'))
            $scope.cinema = 'Maxima';
        $scope.cinemaChange();
    }
    $scope.cinemaChange = function() {
        $scope.days = $scope.details[$scope.movie][$scope.cinema].days;
        $scope.time = $scope.details[$scope.movie][$scope.cinema].time;
        $scope.day = $scope.days[0];
        $scope.dayChange();
    };
    $scope.dayChange = function() {
        $scope.tprices = $scope.prices[$scope.cinema][$scope.day][$scope.time];
        $scope.calculateValidate();
    };
    $scope.calculateValidate = function() {
        $scope.totalPrice = 0;
        $scope.normalSeats = 0;
        $scope.firstClassSeats = 0;
        $scope.beanbagSeats = 0;
        $scope.isValid = true;
        for (var i in $scope.tprices)
        {
            var ticket = $scope.tprices[i];
            if (ticket.price % 1 != 0) $scope.isValid=false;
            $scope.totalPrice += ticket.price * ticket.count;
            if (ticket.type == 'Beanbag')
                $scope.beanbagSeats += ticket.count;
            else if (ticket.type.indexOf('FirstClass') > -1)
                $scope.firstClassSeats += ticket.count;
            else
                $scope.normalSeats += ticket.count;
        }
        $scope.errors = [];
        if ($scope.normalSeats > $scope.cinemaCapacity[$scope.cinema]['normal'])
        {
            $scope.errors.push('Too many standard seats booked');
            $scope.isValid = false;
        }
        if ($scope.firstClassSeats > $scope.cinemaCapacity[$scope.cinema]['first-class'])
        {
            $scope.errors.push('Too many First Class seats booked');
            $scope.isValid = false;
        }
        if ($scope.beanbagSeats > $scope.cinemaCapacity[$scope.cinema]['beanbag'])
        {
            $scope.errors.push('Too many beanbag seats booked');
            $scope.isValid = false;
        }
    }
    $scope.$watch('tprices', function(newValue, oldValue) {
        $scope.calculateValidate();
    }, true);

    $scope.cinemaCapacity = {
        'Rivola':{'normal':40, 'first-class':0, 'beanbag':0},
        'Maxima':{'normal':40, 'first-class':12, 'beanbag':13}
    }
    $scope.movies = {
        'Romantic Comedy': 'Once a Princess',
        'Childrens': 'Planes: Fire and Rescue',
        'Action': 'Guardians of the Galaxy',
        'Art/Foreign': 'Mardaani'
    }
    maxPriceMon_Tue = [
        {'Full':12},
        {'Conc':10},
        {'Child':8},
        {'FirstClass-Adult':25},
        {'FirstClass-Child':20},
        {'Beanbag':20}
    ];
    maxPriceWed_Sun = [
        {'Full':18},
        {'Conc':15},
        {'Child':12},
        {'FirstClass-Adult':30},
        {'FirstClass-Child':25},
        {'Beanbag':30}
    ];
    rivPriceWed_Fri12 = [
        {'Adult':12},
        {'Conc':10},
        {'Child':8}
    ];
    rivPriceWed_Fri = [
        {'Adult':18},
        {'Conc':15},
        {'Child':12}
    ];
    rivPriceSat_Sun = [
        {'Adult':18},
        {'Conc':15},
        {'Child':12}
    ];
    allDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    Wed_Sun  = ['Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    Wed_Fri  = ['Wednesday', 'Thursday', 'Friday'];
    Sat_Sun  = ['Saturday', 'Sunday'];
    $scope.details = {
        'RC':{
            'Maxima':{time:'6', days:allDays}
        },
        'CH':{
            'Maxima':{time:'3', days:Sat_Sun},
            'Rivola':{time:'12', days:Wed_Fri}
        },
        'FO':{
            'Rivola':{time:'7', days:Wed_Sun}
        },
        'AC':{
            'Maxima':{time:'9', days:allDays},
            'Rivola':{time:'4', days:Sat_Sun}
        }
    };
    $scope.prices = {
        'Maxima':{
            'Monday':{'6':maxPriceMon_Tue, '9':maxPriceMon_Tue},
            'Tuesday':{'6':maxPriceMon_Tue, '9':maxPriceMon_Tue},
            'Wednesday':{'6':maxPriceWed_Sun, '9':maxPriceWed_Sun},
            'Thursday':{'6':maxPriceWed_Sun, '9':maxPriceWed_Sun},
            'Friday':{'6':maxPriceWed_Sun, '9':maxPriceWed_Sun},
            'Saturday':{'3':maxPriceWed_Sun, '6':maxPriceWed_Sun, '9':maxPriceWed_Sun},
            'Sunday':{'3':maxPriceWed_Sun, '6':maxPriceWed_Sun, '9':maxPriceWed_Sun}
        },
        'Rivola':{
            'Wednesday':{'12':rivPriceWed_Fri12, '7':rivPriceWed_Fri},
            'Thursday':{'12':rivPriceWed_Fri12, '7':rivPriceWed_Fri},
            'Friday':{'12':rivPriceWed_Fri12, '7':rivPriceWed_Fri},
            'Saturday':{'4':rivPriceSat_Sun, '7':rivPriceSat_Sun},
            'Sunday':{'4':rivPriceSat_Sun, '7':rivPriceSat_Sun}
        }
    };

    //startup
    $scope.movie = 'RC';
    $scope.movieChange();
});
