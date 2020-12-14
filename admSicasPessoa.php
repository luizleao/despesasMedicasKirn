<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasPessoa();

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_pessoa'])) ? "" : $oController->msg; exit;
}
?>
<!DOCTYPE html>
<html lang="pt" ng-app="app">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <?php require_once("includes/modals.php");?>
    <div class="container">
        <?php require_once("includes/titulo.php");?>
        <?php require_once("includes/menu.php");?>
        <ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li class="active">Administrar Pessoa</li>
		</ol>
<?php 
if($oController->msg != "")
    $oController->componenteMsg($oController->msg, "erro");
?>
        <div ng-controller="SicasPessoaController">
			<form ng-submit="getAllPessoa()">
				<div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<input type="text" ng-model="busca" class="form-control" placeholder="Buscar Pessoa" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-search"></i></button>
								<a href="frmSicasPessoa.php" class="btn btn-primary" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>
							</span>
						</div>
					</div>
					<div class="col-md-2">
						<div class="checkbox">
							<input type="checkbox" value="1" name="pessoa_ativa" id="pessoa_ativa" ng-model="pessoa_ativa" /> 
							<label for="pessoa_ativa">Pessoa Ativa</label>
						</div>
					</div>
					<div class="col-md-2">	
						
					</div>
				</div>
				<table class="table table-striped" ng-show="aSicasPessoa.length > 0">
					<thead>
						<tr>
							<th>Nome</th>
							<th>E-mail</th>
							<th>Data Nascimento</th>
							<th>Gênero</th>
							<th>Estado Civil</th>
							<th>RG</th>
							<th>CPF</th>
							<th>Categoria</th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="oSicasPessoa in aSicasPessoa | filter: search | orderBy:'oSicasPessoa.nm_pessoa'">
							<td>{{oSicasPessoa.nm_pessoa}}</td>
							<td>{{oSicasPessoa.email}}</td>
							<td>{{oSicasPessoa.dt_nascimento | date: 'dd/MM/yyyy'}}</td>
							<td>{{oSicasPessoa.genero}}</td>
							<td>{{oSicasPessoa.oSicasEstadoCivil.nm_estado_civil}}</td>
							<td>{{oSicasPessoa.identidade}}</td>
							<td>{{oSicasPessoa.cpf}}</td>
							<td>{{oSicasPessoa.oSicasPessoaCategoria.desc_categoria}}</td>
							<td><button type="button" id="btnDetalhesPessoa" class="btn btn-info btn-sm" title="Detalhes" ng-click="verDetalhesPessoa(oSicasPessoa.cd_pessoa)"><i class="glyphicon glyphicon-search"></i></button></td>
							<td><a class="btn btn-success btn-sm" href="frmSicasPessoa.php?cd_pessoa={{oSicasPessoa.cd_pessoa}}" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
							<td><a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="excluir('cd_pessoa','{{oSicasPessoa.cd_pessoa}}')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" name="classe" id="classe" value="SicasPessoa" />
			</form>
		</div>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>
