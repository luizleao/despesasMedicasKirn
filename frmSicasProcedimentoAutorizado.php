<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasProcedimentoAutorizado();

$oSicasProcedimentoAutorizado = ($_REQUEST['cd_procedimento_autorizado'] == "") ? NULL : $oController->get($_REQUEST['cd_procedimento_autorizado']);
$label   = (is_null($oSicasProcedimentoAutorizado)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasProcedimentoAutorizado)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}
$aSicasEncaminhamento = (new ControllerSicasEncaminhamento())->getAll([], []);$aSicasProcedimento  = (new ControllerSicasProcedimento())->getAll([], []);
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
            <li><a href="admSicasProcedimentoAutorizado.php">SicasProcedimentoAutorizado</a></li>
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
                		<label for="cd_encaminhamento">SicasEncaminhamento</label>
                		<select name="cd_encaminhamento" id="cd_encaminhamento" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasEncaminhamento as $oSicasEncaminhamento){
                		?>
                			<option value="<?=$oSicasEncaminhamento->cd_encaminhamento?>"<?=($oSicasEncaminhamento->cd_encaminhamento == $oSicasProcedimentoAutorizado->oSicasEncaminhamento->cd_encaminhamento) ? " selected" : ""?>><?=$oSicasEncaminhamento->cd_encaminhamento?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_procedimento">SicasProcedimento</label>
                		<select name="cd_procedimento" id="cd_procedimento" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasProcedimento as $oSicasProcedimento){
                		?>
                			<option value="<?=$oSicasProcedimento->cd_procedimento?>"<?=($oSicasProcedimento->cd_procedimento == $oSicasProcedimentoAutorizado->oSicasProcedimento->cd_procedimento) ? " selected" : ""?>><?=$oSicasProcedimento->cd_procedimento?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="qtd_servico_autorizado">Qtd_servico_autorizado</label>
                		<input type="text" class="form-control" id="qtd_servico_autorizado" name="qtd_servico_autorizado" value="<?=$oSicasProcedimentoAutorizado->qtd_servico_autorizado?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<input type="text" class="form-control" id="status" name="status" value="<?=$oSicasProcedimentoAutorizado->status?>" />
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasProcedimentoAutorizado.php">Voltar</a>
                        <input name="cd_procedimento_autorizado" type="hidden" id="cd_procedimento_autorizado" value="<?=$_REQUEST['cd_procedimento_autorizado']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasProcedimentoAutorizado" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>