reserve = angular.module('reserve', []);

reserve.controller('reserveController', function($scope, $http) {
    var originalPrice = $("#price").text();
    $scope.name = '';
    $scope.phone = '';
    $scope.email = '';
    $scope.errors = [];

    $scope.validate = function() {
        var check = $("#code").val();
        if (/\d{5}-\d{5}-[A-Z]{2}/g.test(check))
        {
            $scope.result = "Checking code...";
            $http.post("checkcode.php", 'code='+check, {headers: {'Content-Type': 'application/x-www-form-urlencoded'} }).success(function(data) {
                if (data == "1") {
                    $scope.result = "Success :)";
                    var price = originalPrice;
                    price = price.replace("$", '');
                    price = parseInt(price) * 0.8;
                    $("#price").html("$" + price);
                }
                else
                    $scope.result = "Invalid code";
            });
        }
        else if (check.length == 0)
            $scope.result = "";
        else 
        {
            $("#price").html(originalPrice);
            $scope.result = "Wrong format";
        }
    };

    $scope.fullValidate = function() {
        $scope.errors = [];
        $scope.isValid = true;

        var phoneRegex = /^(\(04\)|04|\+614) ?\d{4} ?\d{4}$/;

        if ($scope.name.length == 0)
            $scope.errors.push('You must provide a name.');

        if (!phoneRegex.test($scope.phone) || $scope.phone.length == 0)
            $scope.errors.push('You must enter a valid Australian mobile phone number (e.g. 04 9090 8080).');

        if ($scope.email.length == 0)
            $scope.errors.push('You must enter a valid email address.');

        if ($scope.errors.length > 0)
            $scope.isValid = false;
    };

    $scope.fullValidate();
});
