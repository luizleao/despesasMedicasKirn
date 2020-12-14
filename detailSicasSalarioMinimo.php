<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasSalarioMinimo();

$oSicasSalarioMinimo = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasSalarioMinimo <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_salario_minimo</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasSalarioMinimo->cd_salario_minimo?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Valor</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasSalarioMinimo->valor?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_cadastro</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataBancoForm($oSicasSalarioMinimo->dt_cadastro)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasSalarioMinimo->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>