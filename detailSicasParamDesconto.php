<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasParamDesconto();

$oSicasParamDesconto = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes SicasParamDesconto <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
		<div class="row">
	<div class="col-md-3">
		<label>Cd_param_desc</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamDesconto->cd_param_desc?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Descricao_param</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamDesconto->descricao_param?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Percentagem_desconto</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamDesconto->percentagem_desconto?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Status</label>
	</div>
	<div class="col-md-9">
		<?=$oSicasParamDesconto->status?>
	</div>
</div>
		</fieldset>
    </div>
</body>
</html>