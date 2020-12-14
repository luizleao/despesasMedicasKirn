app.controller('frmConsultaServidorSAMSController', function ($scope, $http) {
    $scope.aSicasServidor = [];
    $scope.cd_servidor = "";
    $scope.cd_lotacao = "";
    $scope.mesano = new Date();
    //$scope.oSicasServidor = {};
    
    $scope.getAllServidorLotacao = function(){
        $http.get('retornoJson.php?acao=getAllSicasServidorFolhaFrequencia&cd_lotacao='+$scope.cd_lotacao).success(function(data){
            if(data === 'false'){
                $scope.aSicasServidor = [];
            } else {
                $scope.aSicasServidor = data;
            }
            //console.log($scope.aSicasServidor);
        }).error(function(data, status){
            switch(status){
                case 404: msg = 'Página não encontrada'; break;
                case 500: msg = 'Erro no servidor'; break;
            }
            $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Error: '+ msg);
            $('#modalResposta').modal('show');
            //console.log(data);
        });
    };
});