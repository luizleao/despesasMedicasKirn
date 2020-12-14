<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasConsultaMedica();

$oSicasConsultaMedica = ($_REQUEST['cd_consulta_medica'] == "") ? NULL        : $oController->get($_REQUEST['cd_consulta_medica']);
$label   = (is_null($oSicasConsultaMedica)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasConsultaMedica)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerSicasAtendimento = new ControllerSicasAtendimento();$aSicasAtendimento = $oControllerSicasAtendimento->getAll([], []);
$oControllerSicasMedico = new ControllerSicasMedico();$aSicasMedico = $oControllerSicasMedico->getAll([], []);
$oControllerSicasTipoAtendimento = new ControllerSicasTipoAtendimento();$aSicasTipoAtendimento = $oControllerSicasTipoAtendimento->getAll([], []);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <div class="container">
        <?php 
        require_once("includes/titulo.php"); 
        require_once("includes/menu.php"); 
        ?>
        <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li><a href="admSicasConsultaMedica.php">SicasConsultaMedica</a></li>
            <li class="active"><?=$label?></li>
        </ol>
<?php 
if($oController->msg != "")
    $oController->componenteMsg($oController->msg, "erro");
?>
        <form role="form" onsubmit="return false;">
            <div class="row">      	
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_atendimento">SicasAtendimento</label>
                		<select name="cd_atendimento" id="cd_atendimento" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasAtendimento as $oSicasAtendimento){
                		?>
                			<option value="<?=$oSicasAtendimento->cd_atendimento?>"<?=($oSicasAtendimento->cd_atendimento == $oSicasConsultaMedica->oSicasAtendimento->cd_atendimento) ? " selected" : ""?>><?=$oSicasAtendimento->cd_atendimento?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="dt_consulta">Dt_consulta</label>
                	    <?php $oController->componenteCalendario('dt_consulta', Util::formataDataHoraBancoForm($oSicasConsultaMedica->dt_consulta), NULL, true)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_medico">SicasMedico</label>
                		<select name="cd_medico" id="cd_medico" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasMedico as $oSicasMedico){
                		?>
                			<option value="<?=$oSicasMedico->cd_medico?>"<?=($oSicasMedico->cd_medico == $oSicasConsultaMedica->oSicasMedico->cd_medico) ? " selected" : ""?>><?=$oSicasMedico->login?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="qp_paciente">Qp_paciente</label>
                	    <textarea name="qp_paciente" class="form-control" id="qp_paciente" cols="80" rows="10"><?=$oSicasConsultaMedica->qp_paciente?></textarea>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="exame_fisico">Exame_fisico</label>
                	    <textarea name="exame_fisico" class="form-control" id="exame_fisico" cols="80" rows="10"><?=$oSicasConsultaMedica->exame_fisico?></textarea>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="exame_solicitado">Exame_solicitado</label>
                	    <textarea name="exame_solicitado" class="form-control" id="exame_solicitado" cols="80" rows="10"><?=$oSicasConsultaMedica->exame_solicitado?></textarea>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="diag_paciente">Diag_paciente</label>
                	    <textarea name="diag_paciente" class="form-control" id="diag_paciente" cols="80" rows="10"><?=$oSicasConsultaMedica->diag_paciente?></textarea>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_tipo_atendimento">SicasTipoAtendimento</label>
                		<select name="cd_tipo_atendimento" id="cd_tipo_atendimento" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasTipoAtendimento as $oSicasTipoAtendimento){
                		?>
                			<option value="<?=$oSicasTipoAtendimento->cd_tipo_atendimento?>"<?=($oSicasTipoAtendimento->cd_tipo_atendimento == $oSicasConsultaMedica->oSicasTipoAtendimento->cd_tipo_atendimento) ? " selected" : ""?>><?=$oSicasTipoAtendimento->cd_tipo_atendimento?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="resultado">Resultado</label>
                	    <textarea name="resultado" class="form-control" id="resultado" cols="80" rows="10"><?=$oSicasConsultaMedica->resultado?></textarea>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="tratamento">Tratamento</label>
                	    <textarea name="tratamento" class="form-control" id="tratamento" cols="80" rows="10"><?=$oSicasConsultaMedica->tratamento?></textarea>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<input type="text" class="form-control" id="status" name="status" value="<?=$oSicasConsultaMedica->status?>" />
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasConsultaMedica.php">Voltar</a>
                        <input name="cd_consulta_medica" type="hidden" id="cd_consulta_medica" value="<?=$_REQUEST['cd_consulta_medica']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasConsultaMedica" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>