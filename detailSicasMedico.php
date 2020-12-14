<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasMedico();

$oSicasMedico = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasMedico <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_medico</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasMedico->cd_medico?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Login</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasMedico->login?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasMedico->status?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Crm</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasMedico->crm?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasServidor</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasMedico->oSicasServidor->descricao_perfil?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>