app.controller('reservationCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $window) 
{  

	$scope.listReservations = [];

    $scope.getReservations = function () {
        Data.get('get_Reservations').then(function (results) {
            if (results.Message == "OK") {
                $scope.listReservations = results.Data;
            } 
        }); 
    };

        $scope.saveReservations = function (data){
    	Data.post('save_reservations', {data:data}).then(function (results){
    		$location.path('reservations');
    	});
    };

    $scope.saveReservationsMod = function (data){
        var id = $routeParams.idCliente;
        Data.post('update_reservations/'+id, {data:data}).then(function (results){
            $location.path('reservations');
        });
    };

    
    $scope.detailReservations = function () {
        var id = $routeParams.idCliente;
        Data.get('get_reservations_by_id/'+id).then(function (results) 
        {
            if (results.Message) {
                $scope.reservations = results.Data[0];
            } 
        });
    };

    $scope.editReservations = function () {
        $scope.checked = false;
    }



    
    $scope.deleteReservations = function(data) {
        var deleteReservations = $window.confirm('¿SEGURO QUE DESEA ELIMINAR LA RESERVACION "' + data.Name + '" ?');

        if (deleteReservations) {
            Data.get('delete_reservations/'+data.idReservations).then(function (results) 
            {
                if (results.Message) {
                    $location.path('reservations');
                } 
            });
        }
  }

});