<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasConsultaMedica();

$oSicasConsultaMedica = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasConsultaMedica <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_consulta_medica</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->cd_consulta_medica?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasAtendimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->oSicasAtendimento->cd_atendimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_consulta</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataHoraBancoForm($oSicasConsultaMedica->dt_consulta)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasMedico</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->oSicasMedico->login?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Qp_paciente</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->qp_paciente?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Exame_fisico</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->exame_fisico?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Exame_solicitado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->exame_solicitado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Diag_paciente</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->diag_paciente?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasTipoAtendimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->oSicasTipoAtendimento->cd_tipo_atendimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Resultado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->resultado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Tratamento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->tratamento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasConsultaMedica->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>