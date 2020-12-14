app.controller('SicasPessoaController', function ($scope, $http) {
    $scope.aSicasPessoa = [];
    $scope.busca = "";
    $scope.pessoa_ativa = "";
    $scope.cd_categoria = "";
    
    $http.get('retornoJson.php?acao=getAllSicasPessoaCategoria').success(function(data){
        if(data === 'false'){
            $scope.aSicasPessoaCategoria = [];
        } else {
            $scope.aSicasPessoaCategoria = data;
        }
        //console.log($scope.aSicasPessoa);
    }).error(function(data, status){
        switch(status){
            case 404: msg = 'Página não encontrada'; break;
            case 500:
                msg = 'Erro no servidor';
            break;
        }
        alert("Error: "+ msg);
        //console.log(data);
    });
    
    $scope.getAllPessoa = function(){
        $http.get('retornoJson.php?acao=consultarSicasPessoa&busca='+$scope.busca).success(function(data){
            if(data === 'false'){
                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Nenhuma Pessoa encontrada');
                $('#modalResposta').modal('show');
                $scope.aSicasPessoa = [];
            } else {
                $scope.aSicasPessoa = data;
            }
            //console.log($scope.aSicasPessoa);
        }).error(function(data, status){
            switch(status){
                case 404: msg = 'Página não encontrada'; break;
                case 500:
                    msg = 'Erro no servidor';
                break;
            }
            alert("Error: "+ msg);
            //console.log(data);
        });
    };
    
    $scope.verDetalhesPessoa = function (cd_servidor){
    	$('#modalRemote').find('.modal-body').load('frmDetailSicasPessoa.php?cd_servidor='+cd_servidor);
	    $('#modalRemote').modal('show');
    };
});