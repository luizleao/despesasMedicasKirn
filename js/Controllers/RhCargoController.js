app.controller('RhCargoController', function ($scope, $http) {
    $scope.aRhCargo = [];
    $scope.busca = "";
    
    $scope.getAllCargo = function(){
        $http.get('retornoJson.php?acao=consultarRhCargo&busca='+$scope.busca).success(function(data){
            if(data === 'false'){
                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Nenhum Cargo encontrado');
                $('#modalResposta').modal('show');
                $scope.aRhCargo = [];
            } else {
                $scope.aRhCargo = data;
            }
            //console.log($scope.aRhCargo);
        }).error(function(data, status){
            switch(status){
                case 404: msg = 'Página não encontrada'; break;
                case 500: msg = 'Erro no servidor';break;
            }
            alert("Error: "+ msg);
            //console.log(data);
        });
    };
});