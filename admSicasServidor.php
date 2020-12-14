<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasServidor();
//$aSicasServidor = $oController->getAllSicasServidor();
// print "<pre>";print_r($aSicasServidor);print "</pre>";

if ($_REQUEST['acao'] == 'exibir') {
	print json_encode ($aSicasServidor); exit ();
}

if ($_REQUEST['acao'] == 'excluir') {
	print ($oController->excluir($_REQUEST['cd_servidor'])) ? "" : $oController->msg; exit ();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body ng-app="app">
    <?php require_once("includes/modals.php");?>
    <div class="container">
        <?php require_once("includes/titulo.php");?>
        <?php require_once("includes/menu.php");?>
        <ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li class="active">Administrar Servidor</li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
        <div ng-controller="SicasServidorController">
			<form ng-submit="consultarSicasServidor()">
				<div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<input type="text" ng-model="busca" class="form-control" placeholder="Buscar Servidor" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-search"></i></button>
								<a href="frmSicasServidor.php" class="btn btn-primary" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>
							</span>
						</div>
					</div>
					<div class="col-md-2">
						<div class="checkbox">
							<input type="checkbox" value="1" name="servidor_ativo" id="servidor_ativo" ng-model="servidor_ativo" /> 
							<label for="servidor_ativo">Servidor Ativo</label>
						</div>
					</div>
					<div class="col-md-2">	
						
					</div>
				</div>
				<table class="table table-striped" ng-show="aSicasServidor.length > 0">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Matrícula</th>
							<th>Lotação</th>
							<th>Categoria</th>
							<th>Servidor Efetivo?</th>
							<th>Cargo</th>
							<th>Sld Odonto (R$)</th>
							<th>Status</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="oSicasServidor in aSicasServidor | filter: search | orderBy:'oSicasPessoa.nm_pessoa'">
							<td>{{oSicasServidor.oSicasPessoa.nm_pessoa}}</td>
							<td>{{oSicasServidor.cd_matricula}}</td>
							<td>{{oSicasServidor.oSicasLotacao.sigla}}</td>
							<td>{{oSicasServidor.oSicasPessoa.oSicasPessoaCategoria.desc_categoria}}</td>
							<td>{{oSicasServidor.serv_efetivo == 1 && "Sim" || "Não"}}</td>
							<td>{{oSicasServidor.oRhCargo.descricao_cargo_abrev}}</td>
							<td>{{oSicasServidor.vl_saldo_odonto}}</td>
							<td>{{oSicasServidor.status == 1 && "Ativo" || "Inativo"}}
							<td><button type="button" class="btn btn-warning btn-sm" id="btnFrequenciaMensal" title="Frequência Mensal" ng-click="frequenciaServidor(oSicasServidor.cd_servidor)"><i class="glyphicon glyphicon-calendar"></i></button></td>
							<td><button type="button" class="btn btn-info btn-sm" id="btnDetalhesPessoa" title="Detalhes do Servidor" ng-click="verDetalhesServidor(oSicasServidor.cd_servidor)"><i class="glyphicon glyphicon-search"></i></button></td>
							<td><a class="btn btn-success btn-sm" href="frmSicasServidor.php?cd_servidor={{oSicasServidor.cd_servidor}}" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
							<td><a class="btn btn-success btn-sm" target="_blank" href="frmCarteirinha.php?cd_servidor={{oSicasServidor.cd_servidor}}" title="Gerar Carteirinhas"><i class="glyphicon glyphicon-credit-card"></i></a></td>
							<td><a class="btn btn-danger btn-sm" href="admSicasEncaminhamentoServidor.php?cd_servidor={{oSicasServidor.cd_servidor}}" title="Encaminhamentos Médicos Servidor"><i class="glyphicon glyphicon-plus"></i></a></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
    <?php require_once("includes/footer.php")?>   
</body>
</html>