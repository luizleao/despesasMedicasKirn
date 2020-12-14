<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasDespesa();

$oSicasDespesa = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasDespesa <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_despesa</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasDespesa->cd_despesa?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasProcedimentoAutorizado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasDespesa->oSicasProcedimentoAutorizado->cd_procedimento_autorizado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasSalario</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasDespesa->oSicasSalario->cd_salario?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Qtd_servico_realizado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasDespesa->qtd_servico_realizado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Val_servico_realizado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasDespesa->val_servico_realizado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_atendimento</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataBancoForm($oSicasDespesa->dt_atendimento)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_cadastro</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataHoraBancoForm($oSicasDespesa->dt_cadastro)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Desconto_servidor</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasDespesa->desconto_servidor?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasDespesa->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>