<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasCredenciamento();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_credenciamento'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasCredenciamento = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_credenciado.nm_credenciado"], $_REQUEST['pag']);
//Util::trace($aSicasCredenciamento);
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
			<li class="active">Administrar Credenciamento</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Credenciamento" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasCredenciamento.php" class="btn btn-success btn-sm" title="Cadastrar Credenciamento"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasCredenciamento){
?>	
			<thead>
				<tr>
					<th>Credenciado</th>
					<th>Data Início</th>
					<th>Data Fim</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasCredenciamento as $oSicasCredenciamento){
?>
				<tr>
					<td><?=$oSicasCredenciamento->oSicasCredenciado->nm_credenciado?></td>
					<td><?=Util::formataDataBancoForm($oSicasCredenciamento->dt_ini_credenciamento)?></td>
					<td><?=Util::formataDataBancoForm($oSicasCredenciamento->dt_fim_credenciamento)?></td>
					<td><?=Util::getStatus($oSicasCredenciamento->status)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasCredenciamento->cd_credenciamento;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasCredenciamento"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasCredenciamento.php?cd_credenciamento=<?=$oSicasCredenciamento->cd_credenciamento;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_credenciamento" data-id-valor="<?=$oSicasCredenciamento->cd_credenciamento;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="8">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasCredenciamento){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasCredenciamento" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>