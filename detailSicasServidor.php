<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasServidor();

$oSicasServidor = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasServidor <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_servidor</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->cd_servidor?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasPessoa</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->oSicasPessoa->nm_pessoa?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Cd_matricula</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->cd_matricula?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Cd_lotacao</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->cd_lotacao?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->status?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Serv_efetivo</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->serv_efetivo?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>RhCargo</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->oRhCargo->descricao_cargo?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Ramal1</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->ramal1?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Ramal2</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->ramal2?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Ramal3</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->ramal3?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasPessoaCategoria</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->oSicasPessoaCategoria->desc_categoria?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Foto</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->foto?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Descricao_perfil</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->descricao_perfil?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Usuario_proas</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasServidor->usuario_proas?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>