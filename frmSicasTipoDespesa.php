<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasTipoDespesa();

$oSicasTipoDespesa = ($_REQUEST['cd_tipo_despesa'] == "") ? NULL  : $oController->get($_REQUEST['cd_tipo_despesa']);
$label   = (is_null($oSicasTipoDespesa)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasTipoDespesa)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}
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
            <li><a href="admSicasTipoDespesa.php">SicasTipoDespesa</a></li>
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
                		<label for="credenciado">Credenciado</label>
                		<input type="text" class="form-control" id="credenciado" name="credenciado" value="<?=$oSicasTipoDespesa->credenciado?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<input type="text" class="form-control" id="status" name="status" value="<?=$oSicasTipoDespesa->status?>" />
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasTipoDespesa.php">Voltar</a>
                        <input name="cd_tipo_despesa" type="hidden" id="cd_tipo_despesa" value="<?=$_REQUEST['cd_tipo_despesa']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasTipoDespesa" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>