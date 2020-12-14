<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasTipoAtendimento();

$oSicasTipoAtendimento = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasTipoAtendimento <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_tipo_atendimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasTipoAtendimento->cd_tipo_atendimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Nm_tipo_atendimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasTipoAtendimento->nm_tipo_atendimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Fl_atendimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasTipoAtendimento->fl_atendimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Pericia</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasTipoAtendimento->pericia?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasTipoAtendimento->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>