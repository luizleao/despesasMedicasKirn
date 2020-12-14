<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasEncaminhamento();

$oSicasEncaminhamento = ($_REQUEST['cd_encaminhamento'] == "") ? NULL : $oController->get($_REQUEST['cd_encaminhamento']);
$label   = (is_null($oSicasEncaminhamento)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasEncaminhamento)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerSicasMedico         = new ControllerSicasMedico();$aSicasMedico                   = $oControllerSicasMedico->getAll([], []);
//$oControllerSicasPessoa       = new ControllerSicasPessoa();//$aSicasPessoa                 = $oControllerSicasPessoa->getAll([], []);
$oControllerSicasConsultaMedica = new ControllerSicasConsultaMedica();$aSicasConsultaMedica           = $oControllerSicasConsultaMedica->getAll([], []);
$oControllerSicasCredenciado    = new ControllerSicasCredenciado();$aSicasCredenciado              = $oControllerSicasCredenciado->getAll([], []);
$oControllerSicasTipoDespesa    = new ControllerSicasTipoDespesa();$aSicasTipoDespesa              = $oControllerSicasTipoDespesa->getAll([], []);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
    <script src="js/frmBuscaServidor.js"></script>
</head>
<body>
    <div class="container">
        <?php 
        require_once("includes/titulo.php"); 
        require_once("includes/menu.php"); 
        ?>
        <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li><a href="admSicasEncaminhamento.php">Encaminhamento</a></li>
            <li class="active"><?=$label?></li>
        </ol>
<?php 
if($oController->msg != "")
    $oController->componenteMsg($oController->msg, "erro");
?>
        <form role="form" onsubmit="return false;">
        	<div class="row">
				<div class="col-md-6">
					<input type="text" id="nm_pessoa" name="nm_pessoa" class="form-control" data-provide="typeahead" data-items="10" autocomplete="off" placeholder="Nome do Servidor" autofocus /> 
					<input type="hidden" id="cd_servidor" name="cd_servidor" /> 
					<input type="hidden" id="cd_pessoa" name="cd_pessoa" />
				</div>
			</div>
            <div class="row">
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="dt_encaminhamento">Data de Encaminhamento</label>
                	    <?php $oController->componenteCalendario('dt_encaminhamento', Util::formataDataHoraBancoForm($oSicasEncaminhamento->dt_encaminhamento), NULL, true)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_medico">Médico</label>
                		<select name="cd_medico" id="cd_medico" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasMedico as $oSicasMedico){
                		?>
                			<option value="<?=$oSicasMedico->cd_medico?>"<?=($oSicasMedico->cd_medico == $oSicasEncaminhamento->oSicasMedico->cd_medico) ? " selected" : ""?>><?=$oSicasMedico->login?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_pessoa">Beneficiário</label>
                		<select name="cd_pessoa" id="cd_pessoa" class="form-control">
                			<option value="">Selecione</option>
                		<?php
//                		foreach($aSicasPessoa as $oSicasPessoa){
                		?>
                			<option value="<?=$oSicasPessoa->cd_pessoa?>"<?=($oSicasPessoa->cd_pessoa == $oSicasEncaminhamento->oSicasPessoa->cd_pessoa) ? " selected" : ""?>><?=$oSicasPessoa->nm_pessoa?></option>
                		<?php
//                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_consulta_medica">Consulta Médica</label>
                		<select name="cd_consulta_medica" id="cd_consulta_medica" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasConsultaMedica as $oSicasConsultaMedica){
                		?>
                			<option value="<?=$oSicasConsultaMedica->cd_consulta_medica?>"<?=($oSicasConsultaMedica->cd_consulta_medica == $oSicasEncaminhamento->oSicasConsultaMedica->cd_consulta_medica) ? " selected" : ""?>><?=$oSicasConsultaMedica->cd_consulta_medica?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_credenciado">Credenciado</label>
                		<select name="cd_credenciado" id="cd_credenciado" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasCredenciado as $oSicasCredenciado){
                		?>
                			<option value="<?=$oSicasCredenciado->cd_credenciado?>"<?=($oSicasCredenciado->cd_credenciado == $oSicasEncaminhamento->oSicasCredenciado->cd_credenciado) ? " selected" : ""?>><?=$oSicasCredenciado->nm_credenciado?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="tipo_guia">Tipo de Guia</label>
                		<input type="text" class="form-control" id="tipo_guia" name="tipo_guia" value="<?=$oSicasEncaminhamento->tipo_guia?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_tipo_despesa">Tipo de Despesa</label>
                		<select name="cd_tipo_despesa" id="cd_tipo_despesa" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasTipoDespesa as $oSicasTipoDespesa){
                		?>
                			<option value="<?=$oSicasTipoDespesa->cd_tipo_despesa?>"<?=($oSicasTipoDespesa->cd_tipo_despesa == $oSicasEncaminhamento->oSicasTipoDespesa->cd_tipo_despesa) ? " selected" : ""?>><?=$oSicasTipoDespesa->nm_despesa?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasEncaminhamento.php">Voltar</a>
                        <input name="cd_encaminhamento" type="hidden" id="cd_encaminhamento" value="<?=$_REQUEST['cd_encaminhamento']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasEncaminhamento" />
                        <input type="hidden" name="status" id="status" value="1" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>