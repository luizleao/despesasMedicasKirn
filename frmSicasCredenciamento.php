<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasCredenciamento();

$oSicasCredenciamento = ($_REQUEST['cd_credenciamento'] == "") ? NULL: $oController->get($_REQUEST['cd_credenciamento']);
$label   = (is_null($oSicasCredenciamento)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasCredenciamento)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerSicasCredenciado = new ControllerSicasCredenciado();$aSicasCredenciado = $oControllerSicasCredenciado->getAll([], ['sicas_credenciado.nm_credenciado']);
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
            <li><a href="admSicasCredenciamento.php">Credenciamento</a></li>
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
                		<label for="cd_credenciado">Credenciado</label>
                		<select name="cd_credenciado" id="cd_credenciado" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasCredenciado as $oSicasCredenciado){
                		?>
                			<option value="<?=$oSicasCredenciado->cd_credenciado?>"<?=($oSicasCredenciado->cd_credenciado == $oSicasCredenciamento->oSicasCredenciado->cd_credenciado) ? " selected" : ""?>><?=$oSicasCredenciado->nm_credenciado?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="dt_ini_credenciamento">Data Início</label>
                	    <?php $oController->componenteCalendario('dt_ini_credenciamento', Util::formataDataBancoForm($oSicasCredenciamento->dt_ini_credenciamento), NULL, false)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="dt_fim_credenciamento">Data Fim</label>
                	    <?php $oController->componenteCalendario('dt_fim_credenciamento', Util::formataDataBancoForm($oSicasCredenciamento->dt_fim_credenciamento), NULL, false)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<select name="status" id="status" class="form-control">
							<option value="1"<?=($oSicasCredenciamento->status == '1') ? ' selected="selected"' : ''?>>Ativo</option>
							<option value="0"<?=($oSicasCredenciamento->status == '0') ? ' selected="selected"' : ''?>>Inativo</option>
						</select>
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasCredenciamento.php">Voltar</a>
                        <input name="cd_credenciamento" type="hidden" id="cd_credenciamento" value="<?=$_REQUEST['cd_credenciamento']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasCredenciamento" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>