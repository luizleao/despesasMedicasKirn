<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasProcedimento();

$oSicasProcedimento = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasProcedimento <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_procedimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->cd_procedimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Num_procedimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->num_procedimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Nm_procedimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->nm_procedimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Num_custo_operacional</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->num_custo_operacional?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Num_honorario</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->num_honorario?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Num_med_filme</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->num_med_filme?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Num_auxiliares</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->num_auxiliares?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Num_port_anest</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->num_port_anest?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Sigla</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->sigla?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Red_registro</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->red_registro?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimento->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>