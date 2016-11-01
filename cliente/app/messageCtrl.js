app.controller('messageCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $window) 
{  

	$scope.listMessages = [];

    $scope.getMessages = function () {
        Data.get('get_Messages').then(function (results) {
            if (results.Message == "OK") {
                $scope.listMessages = results.Data;
            } 
        }); 
    };

    $scope.saveMessages = function (data){
    	Data.post('save_messages', {data:data}).then(function (results){
    		$location.path('messages');
    	});
    };

    $scope.saveMessagesMod = function (data){
        var id = $routeParams.idRequests;
        Data.post('update_messages/'+id, {data:data}).then(function (results){
            $location.path('messages');
        });
    };

    
    $scope.detailMessages = function () {
        var id = $routeParams.idRequests;
        Data.get('get_messages_by_id/'+id).then(function (results) 
        {
            if (results.Message) {
                $scope.requests = results.Data[0];
            } 
        });
    };

    $scope.editRequests = function () {
        $scope.checked = false;
    }



    
    $scope.deleteMessages = function(data) {
        var deleteMessages = $window.confirm('¿SEGURO QUE DESEA ELIMINAR El MENSAJE "' + data.Name + '" ?');

        if (deleteMessages) {
            Data.get('delete_messages/'+data.idMessages).then(function (results) 
            {
                if (results.Message) {
                    $location.path('messages');
                } 
            });
        }
  }

});