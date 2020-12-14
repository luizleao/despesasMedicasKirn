<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasCredenciado();

$oSicasCredenciado = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasCredenciado <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_credenciado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->cd_credenciado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Nm_credenciado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->nm_credenciado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Dt_nascimento</label>
	</div>
	<div class="col-md-9">
		<?=Util::formataDataBancoForm($oSicasCredenciado->dt_nascimento)?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Hora_atendimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->hora_atendimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Nm_servicos</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->nm_servicos?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Profissional_liberal</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->profissional_liberal?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Endereco</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->endereco?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Complemento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->complemento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Bairro</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->bairro?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Cidade</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->cidade?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Uf</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->uf?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Cep</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->cep?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Telefone1</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->telefone1?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Telefone2</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->telefone2?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Fax1</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->fax1?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Ramal1</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->ramal1?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Tipo</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->tipo?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Cd_pis_pasep</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->cd_pis_pasep?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Cpf</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->cpf?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Cgc</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->cgc?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Guia_prev_social</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->guia_prev_social?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasCredenciado->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>