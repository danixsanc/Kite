app.controller('requestCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $window) 
{  

	$scope.listRequests = [];

    $scope.getRequests = function () {
        Data.get('get_Requests').then(function (results) {
            if (results.Message == "OK") {
                $scope.listRequests = results.Data;
            } 
        }); 
    };

    $scope.saveRequests = function (data){
    	Data.post('save_requests', {data:data}).then(function (results){
    		$location.path('requests');
    	});
    };

    $scope.saveRequestsMod = function (data){
        var id = $routeParams.idRequests;
        Data.post('update_requests/'+id, {data:data}).then(function (results){
            $location.path('requests');
        });
    };

    
    $scope.detailRequests = function () {
        var id = $routeParams.idRequests;
        Data.get('get_requests_by_id/'+id).then(function (results) 
        {
            if (results.Message) {
                $scope.requests = results.Data[0];
            } 
        });
    };

    $scope.editRequests = function () {
        $scope.checked = false;
    }



    
    $scope.deleteRequests = function(data) {
        var deleteRequests = $window.confirm('¿SEGURO QUE DESEA ELIMINAR LA SOLICITUD "' + data.Name + '" ?');

        if (deleteRequests) {
            Data.get('delete_requests/'+data.idRequests).then(function (results) 
            {
                if (results.Message) {
                    $location.path('requests');
                } 
            });
        }
  }

});