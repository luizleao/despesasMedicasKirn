<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasSalarioMinimo();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_salario_minimo'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasSalarioMinimo = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_salario_minimo.cd_salario_minimo"], $_REQUEST['pag']);
//Util::trace($aSicasSalarioMinimo);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<?php require_once("includes/header.php");?>
</head>
<body>
	<div class="container">
		<?php require_once("includes/titulo.php");?>
		<?php require_once("includes/menu.php");?>
		<ol class="breadcrumb">
			<li><a href="home.php">Home</a></li>
			<li class="active">Administrar Salario Mínimo</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar SicasSalarioMinimo" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasSalarioMinimo.php" class="btn btn-success btn-sm" title="Cadastrar SicasSalarioMinimo"><i class="glyphicon glyphicon-plus"></i></a>
					</span>
					</div>
				</div>
			</div>
		</form>

<?php 
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
		<table class="table table-condensed table-striped">
<?php
if($aSicasSalarioMinimo){
?>	
			<thead>
				<tr>
					<th>Valor</th>
					<th>Data</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasSalarioMinimo as $oSicasSalarioMinimo){
?>
				<tr>
					<td><?=Util::formataMoeda($oSicasSalarioMinimo->valor)?></td>
					<td><?=Util::formataDataBancoForm($oSicasSalarioMinimo->dt_cadastro)?></td>
					<td><?=Util::getStatus($oSicasSalarioMinimo->status)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasSalarioMinimo->cd_salario_minimo;?>" class="btn btn-info btn-xs" href="#" title="Detalhes Salario Minimo"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasSalarioMinimo.php?cd_salario_minimo=<?=$oSicasSalarioMinimo->cd_salario_minimo;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_salario_minimo" data-id-valor="<?=$oSicasSalarioMinimo->cd_salario_minimo;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="7">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasSalarioMinimo){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasSalarioMinimo" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>