<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasFatura();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_fatura'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasFatura = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_fatura.cd_fatura"], $_REQUEST['pag']);
//Util::trace($aSicasFatura);
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
			<li class="active">Administrar SicasFatura</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar SicasFatura" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasFatura.php" class="btn btn-success btn-sm" title="Cadastrar SicasFatura"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasFatura){
?>	
			<thead>
				<tr>
					<th>Cd_fatura</th>
					<th>SicasCredenciado</th>
					<th>Num_nota</th>
					<th>Dt_cadastro</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasFatura as $oSicasFatura){
?>
				<tr>
					<td><?=$oSicasFatura->cd_fatura?></td>
					<td><?=$oSicasFatura->oSicasCredenciado->nm_credenciado?></td>
					<td><?=$oSicasFatura->num_nota?></td>
					<td><?=Util::formataDataBancoForm($oSicasFatura->dt_cadastro)?></td>
					<td><?=$oSicasFatura->status?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasFatura->cd_fatura;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasFatura"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasFatura.php?cd_fatura=<?=$oSicasFatura->cd_fatura;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_fatura" data-id-valor="<?=$oSicasFatura->cd_fatura;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
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
if(!$aSicasFatura){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasFatura" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>