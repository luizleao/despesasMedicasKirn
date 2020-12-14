<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasConsultaMedicaCid();

$oSicasConsultaMedicaCid = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasConsultaMedicaCid <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>SicasCid</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedicaCid->oSicasCid->desc_cid?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Cd_consulta_medica</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedicaCid->cd_consulta_medica?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>