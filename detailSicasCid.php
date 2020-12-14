<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasCid();

$oSicasCid = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes CID <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
    		<div class="row">
            	<div class="col-md-3">
            		<label>CID</label>
            	</div>
            	<div class="col-md-9">
            		<?=$oSicasCid->cd_cid?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<label>Descrição</label>
            	</div>
            	<div class="col-md-9">
            		<?=$oSicasCid->desc_cid?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<label>Abreviação</label>
            	</div>
            	<div class="col-md-9">
            		<?=$oSicasCid->desc_cid_abrev?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<label>CID Pai</label>
            	</div>
            	<div class="col-md-9">
            		<?=$oSicasCid->oSicasCid->desc_cid?>
            	</div>
            </div>
		</fieldset>
    </div>
</body>
</html>