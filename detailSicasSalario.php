<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasSalario();

$oSicasSalario = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasSalario <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_salario</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasSalario->cd_salario?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasServidor</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasSalario->oSicasServidor->descricao_perfil?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Val_salario</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasSalario->val_salario?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_ini_salario</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataBancoForm($oSicasSalario->dt_ini_salario)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_fim_salario</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataBancoForm($oSicasSalario->dt_fim_salario)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Serv_efetivo</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasSalario->serv_efetivo?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Obs</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasSalario->obs?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasSalario->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>