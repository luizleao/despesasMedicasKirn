<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasSalario();

$oSicasSalario = ($_REQUEST['cd_salario'] == "") ? NULL        : $oController->get($_REQUEST['cd_salario']);
$label   = (is_null($oSicasSalario)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasSalario)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerSicasServidor = new ControllerSicasServidor();$aSicasServidor = $oControllerSicasServidor->getAll(['sicas_servidor.status=1'], ['sicas_pessoa.nm_pessoa']);
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
            <li><a href="admSicasSalario.php">Salário</a></li>
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
                		<label for="cd_servidor">Servidor</label>
                		<select name="cd_servidor" id="cd_servidor" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasServidor as $oSicasServidor){
                		?>
                			<option value="<?=$oSicasServidor->cd_servidor?>"<?=($oSicasServidor->cd_servidor == $oSicasSalario->oSicasServidor->cd_servidor) ? " selected" : ""?>><?=$oSicasServidor->oSicasPessoa->nm_pessoa?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="val_salario">Salário</label>
                	    <div class="input-group">
                	        <span class="input-group-addon">R$</span>
                	        <input type="text" class="form-control money" name="val_salario" id="val_salario" value="<?=Util::formataMoeda($oSicasSalario->val_salario)?>" />
                	    </div>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="dt_ini_salario">Data Início</label>
                	    <?php $oController->componenteCalendario('dt_ini_salario', Util::formataDataBancoForm($oSicasSalario->dt_ini_salario), NULL, false)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="dt_fim_salario">Data Fim</label>
                	    <?php $oController->componenteCalendario('dt_fim_salario', Util::formataDataBancoForm($oSicasSalario->dt_fim_salario), NULL, false)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="obs">Obs</label>
                	    <textarea name="obs" class="form-control" id="obs" cols="80" rows="10"><?=$oSicasSalario->obs?></textarea>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="serv_efetivo">Servidor Efetivo?</label>
                		<select class="form-control" id="serv_efetivo" name="serv_efetivo">
                			<option value="1" <?=($oSicasSalario->serv_efetivo == 1) ? "selected" : "" ?>>Sim</option>
                			<option value="0" <?=($oSicasSalario->serv_efetivo == 0) ? "selected" : "" ?>>Não</option>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<select class="form-control" id="status" name="status">
                			<option value="1" <?=($oSicasSalario->status == 1) ? "selected" : "" ?>>Sim</option>
                			<option value="0" <?=($oSicasSalario->status == 0) ? "selected" : "" ?>>Não</option>
                		</select>
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasSalario.php">Voltar</a>
                        <input type="hidden" name="cd_salario" id="cd_salario" value="<?=$_REQUEST['cd_salario']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasSalario" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>