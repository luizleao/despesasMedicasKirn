<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasConsultaMedicaCid();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir()) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasConsultaMedicaCid = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_consulta_medica_cid."], $_REQUEST['pag']);
//Util::trace($aSicasConsultaMedicaCid);
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
			<li class="active">Administrar SicasConsultaMedicaCid</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar SicasConsultaMedicaCid" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasConsultaMedicaCid.php" class="btn btn-success btn-sm" title="Cadastrar SicasConsultaMedicaCid"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasConsultaMedicaCid){
?>	
			<thead>
				<tr>
					<th>SicasCid</th>
					<th>Cd_consulta_medica</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasConsultaMedicaCid as $oSicasConsultaMedicaCid){
?>
				<tr>
					<td><?=$oSicasConsultaMedicaCid->oSicasCid->desc_cid?></td>
					<td><?=$oSicasConsultaMedicaCid->cd_consulta_medica?></td>
					
					
					
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="5">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasConsultaMedicaCid){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasConsultaMedicaCid" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>