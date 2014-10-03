reserve = angular.module('reserve', []);

reserve.controller('reserveController', function($scope) {
    var originalPrice = $("#price").text();

    $scope.validate = function() {
        var check = $("#code").val();
        if (/\d{5}-\d{5}-[A-Z]{2}/g.test(check))
        {
            $http.post("checkcode.php", { code: check }).success(function(data) {
                if (data == "1") {
                    $scope.result = "Success :)";
                    var price = originalPrice;
                    price = price.replace("$", '');
                    price = parseInt(price) * 0.8;
                    $("#price").html(price);
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
});
