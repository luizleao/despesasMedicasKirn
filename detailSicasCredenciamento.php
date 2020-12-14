<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasCredenciamento();

$oSicasCredenciamento = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasCredenciamento <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_credenciamento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciamento->cd_credenciamento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasCredenciado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciamento->oSicasCredenciado->nm_credenciado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_ini_credenciamento</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataBancoForm($oSicasCredenciamento->dt_ini_credenciamento)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_fim_credenciamento</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataBancoForm($oSicasCredenciamento->dt_fim_credenciamento)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciamento->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>