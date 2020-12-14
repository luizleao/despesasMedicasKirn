<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasTipoDespesa();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_tipo_despesa'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasTipoDespesa = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_tipo_despesa.cd_tipo_despesa"], $_REQUEST['pag']);
//Util::trace($aSicasTipoDespesa);
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
			<li class="active">Administrar Tipo de Despesa</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Tipo de Despesa" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasTipoDespesa.php" class="btn btn-success btn-sm" title="Cadastrar SicasTipoDespesa"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasTipoDespesa){
?>	
			<thead>
				<tr>
					<th>Despesa</th>
					<th>Credenciado</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasTipoDespesa as $oSicasTipoDespesa){
?>
				<tr>
					<td><?=$oSicasTipoDespesa->nm_despesa?></td>
					<td><?=Util::getSimNao($oSicasTipoDespesa->credenciado)?></td>
					<td><?=Util::getStatus($oSicasTipoDespesa->status)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasTipoDespesa->cd_tipo_despesa;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasTipoDespesa"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasTipoDespesa.php?cd_tipo_despesa=<?=$oSicasTipoDespesa->cd_tipo_despesa;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_tipo_despesa" data-id-valor="<?=$oSicasTipoDespesa->cd_tipo_despesa;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
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
if(!$aSicasTipoDespesa){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasTipoDespesa" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>