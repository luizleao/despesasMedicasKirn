<?php
require_once("classes/autoload.php");
$oController = new ControllerRhEstagiario();

$oRhEstagiario = $oController->get($_REQUEST['id']);
?>
<!DOCTYPE html>
<html lang="pt">
<head></head>
<body>
    <div class="container-fluid">
		<fieldset>
			<legend>Detalhes RhEstagiario <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
            <div class="row">
            	<div class="col-md-3">
            		<label>Estagiário</label>
            	</div>
            	<div class="col-md-9">
            		<?=$oRhEstagiario->oSicasPessoa->nm_pessoa?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<label>Lotação</label>
            	</div>
            	<div class="col-md-9">
            		<?=$oRhEstagiario->oSicasLotacao->sigla?> - <?=$oRhEstagiario->oSicasLotacao->nm_lotacao?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<label>IES</label>
            	</div>
            	<div class="col-md-9">
            		<?=$oRhEstagiario->oRhIes->sigla?> - <?=$oRhEstagiario->oRhIes->descricao?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<label>Nº Processo</label>
            	</div>
            	<div class="col-md-9">
            		<?=$oRhEstagiario->num_processo?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<label>Data de Início</label>
            	</div>
            	<div class="col-md-9">
            		<?=Util::formataDataBancoForm($oRhEstagiario->dt_inicio)?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<label>Data de Renovação</label>
            	</div>
            	<div class="col-md-9">
            		<?=Util::formataDataBancoForm($oRhEstagiario->dt_renovacao)?>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<label>Status</label>
            	</div>
            	<div class="col-md-9">
            		<?=Util::getStatus($oRhEstagiario->status)?>
            	</div>
            </div>
		</fieldset>
    </div>
</body>
</html>