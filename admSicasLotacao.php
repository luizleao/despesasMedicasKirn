<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasLotacao();
//$aSicasLotacao = $oController->getAllSicasLotacao ();
// print "<pre>";print_r($aSicasLotacao);print "</pre>";

if ($_REQUEST['acao'] == 'excluir'){
	print ($oController->excluir($_REQUEST['cd_lotacao'])) ? "" : $oController->msg; exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <?php require_once("includes/modals.php");?>
    <div ng-app="app" class="container">
        <?php require_once("includes/titulo.php");?>
        <?php require_once("includes/menu.php");?>
        <ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li class="active">Administrar <span>Lotação</span></li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg ($oController->msg, "erro");
?>
        <div ng-controller="SicasLotacaoController">
			<form ng-submit="getAllLotacao()">
				<div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<input type="text" ng-model="busca" class="form-control" placeholder="Buscar Lotação" />
							<div class="input-group-btn">
								<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-search"></i></button>
								<a href="frmSicasLotacao.php" class="btn btn-primary" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>			
							</div>
						</div>
					</div>
				</div>
				
				<table class="table table-striped" ng-show="aSicasLotacao.length > 0">
					<thead>
						<tr>
							<th>Cod.</th>
							<th>Lotação</th>
							<th>Sigla</th>
							<th>Cód. SIGED</th>
							<th>Status</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="oSicasLotacao in aSicasLotacao | filter: search | orderBy:'oSicasLotacao.nm_lotacao'">
							<td>{{oSicasLotacao.cd_lotacao}}</td>
							<td>{{oSicasLotacao.nm_lotacao}}</td>
							<td>{{oSicasLotacao.sigla}}</td>
							<td>{{oSicasLotacao.cd_siged}}</td>
							<td>{{oSicasLotacao.status==1  ? "Ativo" : "Inativo"}}</td>
							<td><a class="btn btn-success btn-sm" href="frmSicasLotacao.php?cd_lotacao={{oSicasLotacao.cd_lotacao}}" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
							<td><a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="excluir('cd_lotacao','{{oSicasLotacao.cd_lotacao}}')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>