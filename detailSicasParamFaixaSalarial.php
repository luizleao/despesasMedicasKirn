<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasParamFaixaSalarial();

$oSicasParamFaixaSalarial = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasParamFaixaSalarial <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_param_faixa_sal</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamFaixaSalarial->cd_param_faixa_sal?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Val_faixa_inicial</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamFaixaSalarial->val_faixa_inicial?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Flg_faixa_ini_inclusive</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamFaixaSalarial->flg_faixa_ini_inclusive?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Val_faixa_final</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamFaixaSalarial->val_faixa_final?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Flg_faixa_fin_inclusive</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamFaixaSalarial->flg_faixa_fin_inclusive?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Percentagem_desconto</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamFaixaSalarial->percentagem_desconto?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamFaixaSalarial->status?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Servidor_efetivo</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamFaixaSalarial->servidor_efetivo?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>