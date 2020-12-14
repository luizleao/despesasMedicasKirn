app.controller('RhRamalController', function ($scope, $http) {
	$scope.aSicasServidor   = [];
	$scope.aRhServidorRamal = [];
	$scope.oSicasServidor   = {};
	$scope.cd_lotacao 		= "";
	
	// Alimentando o combo de Servidores
	$scope.consultarServidores = function (){
		$http.get('retornoJson.php?acao=getAllSicasServidorLotacao&cd_lotacao='+$scope.cd_lotacao).then(
			function(response){
				$scope.aSicasServidor = (angular.isObject(response.data)) ? response.data : [];
			},
			function(response){
				switch(response.status){
			           case 404: msg = 'Página não encontrada'; break;
			           case 500: msg = 'Erro no servidor'; break;
				}
		        $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Error: '+ msg);
		        $('#modalResposta').modal('show');
			}
		);
	};

	$scope.addServidor = function() {
		if(angular.isObject($scope.oSicasServidor))
			$scope.aRhServidorRamal.push($scope.oSicasServidor);
		//console.log($scope.aRhServidorRamal);
	};
 
	$scope.delServidor = function(obj) {
		var aTemp = $scope.aRhServidorRamal;
		$scope.aRhServidorRamal = [];
		
		angular.forEach(aTemp, function(aux) {
			if (!angular.equals(aux, obj))
				$scope.aRhServidorRamal.push(aux);
		});
	};
});