app.controller('SicasLotacaoController', function ($scope, $http) {
    $scope.aSicasLotacao = [];
    $scope.busca = "";
    
    $scope.getAllLotacao = function(){
        $http.get('retornoJson.php?acao=consultarSicasLotacao&busca='+$scope.busca).success(function(data){
            if(data === 'false'){
                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Nenhuma Lotação encontrada');
                $('#modalResposta').modal('show');
                $scope.aSicasLotacao = [];
            } else {
                $scope.aSicasLotacao = data;
            }
            //console.log($scope.aSicasLotacao);
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