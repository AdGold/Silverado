reserve = angular.module('reserve', []);

reserve.controller('reserveController', function($scope, $http) {
    $scope.validate = function() {
        var check = $("#code").val();
        if (/\d{5}-\d{5}-[A-Z]{2}/g.test(check))
        {
            $scope.result = "Checking code...";

            $http.post("checkcode.php", { code: check }).success(function(data) {
                alert('wooo');
                if (data == "1")
                    $scope.result = "Success :)";
                else
                    $scope.result = "Invalid code";
            });
            alert('sent post :) ');
        }
        else if (check.length == 0)
            $scope.result = "";
        else
            $scope.result = "Wrong format";
    };
});
