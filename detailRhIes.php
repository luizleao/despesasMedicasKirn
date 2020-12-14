<?php
require_once(dirname(__FILE__)."/classes/autoload.php");
$oController = new Controller();

$oRhIes = $oController->getRhIes($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes IES <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
            <div class="row">
            	<div class="col-md-2">
            		<label>Sigla</label>
            	</div>
            	<div class="col-md-10">
            		<?=$oRhIes->sigla?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-2">
            		<label>Descrição</label>
            	</div>
            	<div class="col-md-10">
            		<?=$oRhIes->descricao?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-2">
            		<label>Endereço</label>
            	</div>
            	<div class="col-md-10">
            		<?=$oRhIes->endereco?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-2">
            		<label>Telefone 1</label>
            	</div>
            	<div class="col-md-10">
            		<?=$oRhIes->telefone1?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-2">
            		<label>Telefone 2</label>
            	</div>
            	<div class="col-md-10">
            		<?=$oRhIes->telefone2?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-2">
            		<label>Telefone 3</label>
            	</div>
            	<div class="col-md-10">
            		<?=$oRhIes->telefone3?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-2">
            		<label>E-mail</label>
            	</div>
            	<div class="col-md-10">
            		<?=$oRhIes->email?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-2">
            		<label>Status</label>
            	</div>
            	<div class="col-md-10">
            		<?=Util::getStatus($oRhIes->status)?>
            	</div>
            </div>
		</fieldset>
    </div>
</body>
</html>