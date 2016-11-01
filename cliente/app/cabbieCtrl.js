app.controller('cabbieCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $window) 
{

	$scope.listaCabbies = {};
    $scope.ClienteById = {};
    $scope.checked = true;

	$scope.getCabbies = function () {
        Data.get('get_Cabbies').then(function (results) {
            if (results.Message == "OK") {
                $scope.listaCabbies = results.Data;
            } });
    };

    $scope.saveCabbies = function (data){
    	Data.post('save_cabbies', {data:data}).then(function (results){
    		$location.path('cabbies');
    	});
    };

    $scope.saveCabbiesMod = function (data){
        var id = $routeParams.idCliente;
        Data.post('update_cabbies/'+id, {data:data}).then(function (results){
            $location.path('cabbies');
        });
    };

    
    $scope.detailCabbies = function () {
        var id = $routeParams.idCliente;
        Data.get('get_cabbies_by_id/'+id).then(function (results) 
        {
            if (results.Message) {
                $scope.cabbies = results.Data[0];
            } 
        });
    };

    $scope.editCabbies = function () {
        $scope.checked = false;
    }



    
    $scope.deleteCabbies = function(data) {
        var deleteCabbies = $window.confirm('¿SEGURO QUE DESEA ELIMINAR AL TAXISTA "' + data.Name + '" ?');

        if (deleteCabbies) {
            Data.get('delete_cabbies/'+data.idCabbies).then(function (results) 
            {
                if (results.Message) {
                    $location.path('cabbies');
                } 
            });
        }
  }


   


});