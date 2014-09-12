booking = angular.module('booking', []);

booking.controller('bookingController', function($scope) {
    $scope.cinemaChange = function() {
        $scope.days = $scope.details[$scope.cinema];
        $scope.day = $scope.days[0];
        $scope.dayChange();
    };
    $scope.dayChange = function() {
        $scope.times = $scope.day.times;
        $scope.time = $scope.times[0];
        $scope.timeChange();
    };
    $scope.timeChange = function() {
        $scope.tprices = $scope.prices[$scope.cinema][$scope.day.day][$scope.time.time];
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
        'Romantic Comedy': 'The Other Woman',
        'Childrens': 'Teenage Mutant Ninja Turtles',
        'Action': 'Guardians of the Galaxy',
        'Art/Foreign': 'Grand Illusion'
    }
    maxPriceMon_Tue = [
        {'type':'Full','price':12,'count':0},
        {'type':'Conc','price':10,'count':0},
        {'type':'Child','price':8,'count':0},
        {'type':'FirstClass-Adult','price':25,'count':0},
        {'type':'FirstClass-Child','price':20,'count':0},
        {'type':'Beanbag','price':20,'count':0}
    ];
    maxPriceWed_Sun = [
        {'type':'Full','price':18,'count':0},
        {'type':'Conc','price':15,'count':0},
        {'type':'Child','price':12,'count':0},
        {'type':'FirstClass-Adult','price':30,'count':0},
        {'type':'FirstClass-Child','price':25,'count':0},
        {'type':'Beanbag','price':30,'count':0}
    ];
    rivPriceWed_Fri12 = [
        {'type':'Adult','price':12,'count':0},
        {'type':'Conc','price':10,'count':0},
        {'type':'Child','price':8,'count':0}
    ];
    rivPriceWed_Fri = [
        {'type':'Adult','price':18,'count':0},
        {'type':'Conc','price':15,'count':0},
        {'type':'Child','price':12,'count':0}
    ];
    rivPriceSat_Sun = [
        {'type':'Adult','price':18,'count':0},
        {'type':'Conc','price':15,'count':0},
        {'type':'Child','price':12,'count':0}
    ];
    maxMon_Fri = [
        {'time':'6','genre':'Romantic Comedy'},
        {'time':'9','genre':'Action'}
    ];
    maxSat_Sun = [
        {'time':'3','genre':'Childrens'},
        {'time':'6','genre':'Romantic Comedy'},
        {'time':'9','genre':'Action'}
    ];
    rivWed_Fri = [
        {'time':'12','genre':'Childrens'},
        {'time':'7','genre':'Art/Foreign'}
    ];
    rivSat_Sun = [
        {'time':'4','genre':'Action'},
        {'time':'7','genre':'Art/Foreign'}
    ];
    $scope.details = {
        'Maxima':[
            {'day':'Monday','times':maxMon_Fri},
            {'day':'Tuesday','times':maxMon_Fri},
            {'day':'Wednesday','times':maxMon_Fri},
            {'day':'Thursday','times':maxMon_Fri},
            {'day':'Friday','times':maxMon_Fri},
            {'day':'Saturday','times':maxSat_Sun},
            {'day':'Sunday','times':maxSat_Sun}
        ],
        'Rivola':[
            {'day':'Wednesday','times':rivWed_Fri},
            {'day':'Thursday','times':rivWed_Fri},
            {'day':'Friday','times':rivWed_Fri},
            {'day':'Saturday','times':rivSat_Sun},
            {'day':'Sunday','times':rivSat_Sun}
        ]
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
    $scope.cinema = 'Maxima';
    $scope.cinemaChange();
});
