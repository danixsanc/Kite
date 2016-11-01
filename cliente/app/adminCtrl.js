app.controller('adminCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $window) 
{  

	$scope.listAdmins = [];

    $scope.getAdmins = function () {
        Data.get('get_Admins').then(function (results) {
            if (results.Message == "OK") {
                $scope.listAdmins = results.Data;
            } 
        }); 
    };

    $scope.saveAdmins = function (data){
    	Data.post('save_admins', {data:data}).then(function (results){
    		$location.path('admins');
    	});
    };

    $scope.saveAdminsMod = function (data){
        var id = $routeParams.idCliente;
        Data.post('update_admins/'+id, {data:data}).then(function (results){
            $location.path('admins');
        });
    };

    
    $scope.detailAdmins = function () {
        var id = $routeParams.idCars;
        Data.get('get_admins_by_id/'+id).then(function (results) 
        {
            if (results.Message) {
                $scope.admins = results.Data[0];
            } 
        });
    };

    $scope.editAdmins = function () {
        $scope.checked = false;
    }



    
    $scope.deleteAdmins = function(data) {
        var deleteAdmins = $window.confirm('¿SEGURO QUE DESEA ELIMINAR EL ADMINISTRADOR "' + data.Name + '" ?');

        if (deleteAdmins) {
            Data.get('delete_admins/'+data.idAdmins).then(function (results) 
            {
                if (results.Message) {
                    $location.path('admins');
                } 
            });
        }
  }

});