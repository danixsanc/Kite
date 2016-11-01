app.controller('carCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $window) 
{  

	$scope.listCars = [];

    $scope.getCars = function () {
        Data.get('get_Cars').then(function (results) {
            if (results.Message == "OK") {
                $scope.listCars = results.Data;
            } 
        }); 
    };

    $scope.saveCars = function (data){
    	Data.post('save_cars', {data:data}).then(function (results){
    		$location.path('cars');
    	});
    };

    $scope.saveCarsMod = function (data){
        var id = $routeParams.idCliente;
        Data.post('update_cars/'+id, {data:data}).then(function (results){
            $location.path('cars');
        });
    };

    
    $scope.detailCars = function () {
        var id = $routeParams.idCars;
        Data.get('get_cars_by_id/'+id).then(function (results) 
        {
            if (results.Message) {
                $scope.cars = results.Data[0];
            } 
        });
    };

    $scope.editCars = function () {
        $scope.checked = false;
    }



    
    $scope.deleteCars = function(data) {
        var deleteCars = $window.confirm('¿SEGURO QUE DESEA ELIMINAR EL AUTOMOVIL "' + data.Name + '" ?');

        if (deleteCars) {
            Data.get('delete_cars/'+data.idCars).then(function (results) 
            {
                if (results.Message) {
                    $location.path('cars');
                } 
            });
        }
  }
});