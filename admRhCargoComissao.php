<?php
require_once("classes/autoload.php");

$oController = new ControllerRhCargoComissao();

if ($_REQUEST['acao'] == 'excluir') {
	print ($oController->excluir($_REQUEST['cd_cargo_comissao'] )) ? "" : $oController->msg; exit();
}
?>
<!DOCTYPE html>
<html lang="pt" ng-app="app">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <?php require_once("includes/modals.php");?>
    <div ng-controller="RhCargoComissaoController" class="container">
        <?php require_once("includes/titulo.php");?>
        <?php require_once("includes/menu.php");?>
        <ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li class="active">Administrar Cargo em Comissão</li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg ( $oController->msg, "erro" );
?>
		<form ng-submit="getAllCargoComissao()">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
    					<input type="text" ng-model="busca" class="form-control" placeholder="Buscar Cargo em Comissão">					
    					<span class="input-group-btn">
    						<button type="submit" class="btn btn-success" title="Procurar"><i class="glyphicon glyphicon-search"></i></button>
							<a href="frmRhCargoComissao.php" class="btn btn-primary" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>						
    					</span>
    				</div>
				</div>
			</div>
		</form>
		<table class="table table-striped" ng-show="aRhCargoComissao.length > 0">
			<thead>
				<tr>
					<th>Unidade</th>
					<th>Descrição</th>
					<th>Cargo</th>
					<th>Servidor</th>
					<th>Status</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="oRhCargoComissao in aRhCargoComissao | filter: search | orderBy:'oRhCargoComissao.descricao'">
			        <td>{{ oRhCargoComissao.oSicasLotacao.sigla}}</td>
					<td>{{ oRhCargoComissao.descricao}}</td>
					<td>{{ oRhCargoComissao.das}}</td>
					<td>{{ oRhCargoComissao.oSicasServidor.oSicasPessoa.nm_pessoa}}</td>
					<td>{{ oRhCargoComissao.status==1 ? "Ativo" : "Inativo"}}</td>
					
					<td><a class="btn btn-success btn-sm" href="frmRhCargoComissao.php?cd_cargo_comissao={{oRhCargoComissao.cd_cargo_comissao}}" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-sm" href="javascript: void(0);" ng-click="excluir(oRhCargoComissao);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
			</tbody>
		</table>

		<input type="hidden" ng-model="classe" ng-value="classe = 'RhCargoComissao'"/>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>