<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasEncaminhamento();

$oSicasEncaminhamento = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasEncaminhamento <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_encaminhamento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasEncaminhamento->cd_encaminhamento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_encaminhamento</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataHoraBancoForm($oSicasEncaminhamento->dt_encaminhamento)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasMedico</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasEncaminhamento->oSicasMedico->login?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasPessoa</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasEncaminhamento->oSicasPessoa->nm_pessoa?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasConsultaMedica</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasEncaminhamento->oSicasConsultaMedica->cd_consulta_medica?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasCredenciado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasEncaminhamento->oSicasCredenciado->nm_credenciado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Tipo_guia</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasEncaminhamento->tipo_guia?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasEncaminhamento->status?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasTipoDespesa</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasEncaminhamento->oSicasTipoDespesa->cd_tipo_despesa?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>