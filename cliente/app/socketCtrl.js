app.controller('socketCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $window, $interval, $timeout) 
{


    $scope.getData = function(){
        Data.get('actualizar_taxistas').then(function (results) {
            console.log('Fetched data!');
        });
    };

    // Function to replicate setInterval using $timeout service.
    $scope.intervalFunction = function(){
        $timeout(function() {
            $scope.getData();
            $scope.intervalFunction();
        }, 5000)
    };

     $scope.intervalFunction();

});