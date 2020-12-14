<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasFatura();

$oSicasFatura = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasFatura <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_fatura</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasFatura->cd_fatura?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasCredenciado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasFatura->oSicasCredenciado->nm_credenciado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Num_nota</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasFatura->num_nota?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_cadastro</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataBancoForm($oSicasFatura->dt_cadastro)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasFatura->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>