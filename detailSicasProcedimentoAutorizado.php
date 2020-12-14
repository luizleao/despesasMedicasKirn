<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasProcedimentoAutorizado();

$oSicasProcedimentoAutorizado = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasProcedimentoAutorizado <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_procedimento_autorizado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimentoAutorizado->cd_procedimento_autorizado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasEncaminhamento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimentoAutorizado->oSicasEncaminhamento->cd_encaminhamento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>SicasProcedimento</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimentoAutorizado->oSicasProcedimento->cd_procedimento?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Qtd_servico_autorizado</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimentoAutorizado->qtd_servico_autorizado?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasProcedimentoAutorizado->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>