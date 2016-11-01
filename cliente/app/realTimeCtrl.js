app.controller('realTimeCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $window, uiGmapGoogleMapApi) 
{  

	$scope.listaCoordenadas = {};

	$scope.map = { center: { latitude: 24.79, longitude: -107.4 }, zoom: 12 };

	uiGmapGoogleMapApi.then(function(maps) {

    });

	$scope.get_cabbies_coordinates = function () {
        Data.get('get_cabbies_coordinates').then(function (results) {
            if (results.Message == "OK") {
                $scope.listaCoordenadas = results.Data;
            } 
        });
    };

});