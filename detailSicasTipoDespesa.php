<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasTipoDespesa();

$oSicasTipoDespesa = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasTipoDespesa <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_tipo_despesa</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasTipoDespesa->cd_tipo_despesa?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Nm_despesa</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasTipoDespesa->nm_despesa?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Credenciado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasTipoDespesa->credenciado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasTipoDespesa->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>