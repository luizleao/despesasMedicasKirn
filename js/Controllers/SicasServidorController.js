app.controller('SicasServidorController', function ($scope, $http) {
    $scope.aSicasServidor = [];
    $scope.busca = "";
    $scope.servidor_ativo = "";
    
    $scope.consultarSicasServidor = function(){
        $http.get('retornoJson.php?acao=consultarSicasServidor&nm_pessoa='+$scope.busca+"&servidor_ativo="+$scope.servidor_ativo).success(function(data){
            if(data === 'false'){
                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Nenhum Servidor encontrado');
                $('#modalResposta').modal('show');
                $scope.aSicasServidor = [];
            } else {
                $scope.aSicasServidor = data;
            }
            console.log($scope.aSicasServidor);
        }).error(function(data, status){
            switch(status){
                case 404: 
                	msg = 'Página não encontrada'; 
                break;
                case 500:
                    msg = 'Erro no servidor';
                break;
            }
            alert("Error: "+ msg);
            //console.log(data);
        });
    };
    
    $scope.verDetalhesServidor = function (cd_servidor){
    	$('#modalRemote').find('.modal-body').load('frmDetailSicasPessoa.php?cd_servidor='+cd_servidor);
	    $('#modalRemote').modal('show');
    };
    
    $scope.frequenciaServidor = function (cd_servidor){
    	var win = window.open('resFrequenciaMensal.php?cd_servidor='+cd_servidor, '_blank');
    	win.focus();
    };
});