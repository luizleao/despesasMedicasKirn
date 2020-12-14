app.controller('RhCargoComissaoController', function ($scope, $http) {
    $scope.aRhCargoComissao = [];
    $scope.busca = "";
    $scope.classe;
    $scope.getAllCargoComissao = function(){
        $http.get('retornoJson.php?acao=consultarRhCargoComissao&busca='+$scope.busca).success(function(data){
            if(data === 'false'){
                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Nenhum Cargo encontrado');
                $('#modalResposta').modal('show');
                $scope.aRhCargoComissao = [];
            } else {
                $scope.aRhCargoComissao = data;
            }
            //console.log($scope.aRhCargoComissao);
        }).error(function(data, status){
            switch(status){
                case 404: msg = 'Página não encontrada'; break;
                case 500: msg = 'Erro no servidor';break;
            }
            alert("Error: "+ msg);
            //console.log(data);
        });
    };

    $scope.excluir = function (obj){
        console.log(obj);
        //'cd_cargo_comissao', oRhCargoComissao.cd_cargo_comissao,oRhCargoComissao.oSicasServidor.oSicasPessoa.nm_pessoa
        //var classe = $("#classe").val();
	
        $('#modalExcluir').modal('show');
        $('#modalExcluir').find('.modal-body').html('Deseja excluir o cadastro de '+obj.oSicasServidor.oSicasPessoa.nm_pessoa +'?');
    
        $('#btnSim').click(function () {
            $.ajax({
                url        : 'adm'+$scope.classe+'.php?acao=excluir&cd_cargo_comissao='+obj.cd_cargo_comissao,
                type       : 'get',
                beforeSend : function(){
                    $('#btnCadastrar').button('loading');
                },
                timeout    : timeout,
                success    : function(retorno){
                    $('#modalExcluir').modal('hide');
                    $('#modalResposta').find('.modal-body').html((retorno !== '') ? '<img src="img/ico_error.png" /> '+retorno : '<img src="img/ico_success.png" /> Excluido com sucesso');
                    $('#modalResposta').modal('show');
                    $('#modalResposta').on('hide.bs.modal', function () {
                        //window.location = 'adm'+$scope.classe+'.php';
                        //$scope.aRhCargoComissao.push(obj);
                        $scope.getAllCargoComissao();
                    });
                },
                error	   : function(retorno){
                    $('#modalExcluir').modal('hide');
                    $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> ERRO: '+retorno);
                    $('#modalResposta').modal('show');
                }
            });
        });
    };
/*
    $scope.excluir = function (campo, valor, nome){
        //var classe = $("#classe").val();
	
        $('#modalExcluir').modal('show');
        $('#modalExcluir').find('.modal-body').html('Deseja excluir o cadastro de '+nome +'?');
    
        $('#btnSim').click(function () {
            $.ajax({
                url        : 'adm'+$scope.classe+'.php?acao=excluir&'+campo+'='+valor,
                type       : 'get',
                beforeSend : function(){
                    $('#btnCadastrar').button('loading');
                },
                timeout    : timeout,
                success    : function(retorno){
                    $('#modalExcluir').modal('hide');
                    $('#modalResposta').find('.modal-body').html((retorno !== '') ? '<img src="img/ico_error.png" /> '+retorno : '<img src="img/ico_success.png" /> Excluido com sucesso');
                    $('#modalResposta').modal('show');
                    $('#modalResposta').on('hide.bs.modal', function () {
                        window.location = 'adm'+$scope.classe+'.php';
                    });
                },
                error	   : function(retorno){
                    $('#modalExcluir').modal('hide');
                    $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> ERRO: '+retorno);
                    $('#modalResposta').modal('show');
                }
            });
        });
    };
*/        
});