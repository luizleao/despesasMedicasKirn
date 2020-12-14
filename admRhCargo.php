<?php
require_once("classes/autoload.php");
$oController = new ControllerRhCargo();

if ($_REQUEST['acao'] == 'excluir') {
	print ($oController->excluir($_REQUEST['cd_cargo'])) ? "" : $oController->msg; exit ();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body ng-app="app">
    <?php require_once("includes/modals.php");?>
    <div ng-controller="RhCargoController" class="container">
        <?php require_once("includes/titulo.php");?>
        <?php require_once("includes/menu.php");?>
        <ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li class="active">Administrar Cargo</li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
		<form ng-submit="getAllCargo()">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
    					<input type="text" ng-model="busca" class="form-control" placeholder="Buscar cargo" />					
    					<span class="input-group-btn">
    						<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-search"></i></button>
    						<a href="frmRhCargo.php" class="btn btn-primary" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>						
    					</span>
    				</div>
				</div>
			</div>
		</form>
		<table class="table table-striped" ng-show="aRhCargo.length > 0">
			<thead>
				<tr>
					<th>Descrição do Cargo</th>
					<th>Abreviação</th>
					<th>Número SIAPE do Cargo</th>
					<th>Status</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="oRhCargo in aRhCargo | filter: search | orderBy:'oRhCargo.descricao_cargo'">
					<td>{{ oRhCargo.descricao_cargo}}</td>
					<td>{{ oRhCargo.descricao_cargo_abrev}}</td>
					<td>{{ oRhCargo.num_siape_cargo}}</td>
					<td>{{ oRhCargo.status == 1 ? 'Ativo' : 'Inativo'}}</td>
					<td><a class="btn btn-success btn-sm" href="frmRhCargo.php?cd_cargo={{ oRhCargo.cd_cargo}}" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="excluir('cd_cargo','{{ oRhCargo.cd_cargo}}')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
			</tbody>
		</table>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>