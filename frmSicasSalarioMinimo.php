<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasSalarioMinimo();

$oSicasSalarioMinimo = ($_REQUEST['cd_salario_minimo'] == "") ? NULL  : $oController->get($_REQUEST['cd_salario_minimo']);
$label   = (is_null($oSicasSalarioMinimo)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasSalarioMinimo)) ? ($oController->alterar()) : ($oController->cadastrar());
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
            <li><a href="admSicasSalarioMinimo.php">Salario Mínimo</a></li>
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
                	    <label for="valor">Valor</label>
                	    <div class="input-group">
                	        <span class="input-group-addon">R$</span>
                	        <input type="text" class="form-control money" name="valor" id="valor" value="<?=Util::formataMoeda($oSicasSalarioMinimo->valor)?>" />
                	    </div>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="dt_cadastro">Data de Cadastro</label>
                	    <?php $oController->componenteCalendario('dt_cadastro', Util::formataDataBancoForm($oSicasSalarioMinimo->dt_cadastro), NULL, false)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<input type="text" class="form-control" id="status" name="status" value="<?=$oSicasSalarioMinimo->status?>" />
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasSalarioMinimo.php">Voltar</a>
                        <input type="hidden" name="cd_salario_minimo" id="cd_salario_minimo" value="<?=$_REQUEST['cd_salario_minimo']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasSalarioMinimo" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>