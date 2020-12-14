<?php
require_once(dirname(__FILE__)."/classes/autoload.php");
$oController = new Controller();

// ================= Cadastrar SicasPessoa ========================= 
$aLotacao = $oController->getAllSicasLotacao(["sicas_lotacao.status = 1"], ["sicas_lotacao.sigla"]);
//$aPessoa  = $oController->getAllSicasPessoa("order by nm_pessoa");
?>
<!DOCTYPE html>
<html lang="pt" ng-app="app">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <?php require_once("includes/loading.php");?>
    <?php require_once("includes/modals.php");?>
    <div class="container" ng-controller="frmConsultaServidorSAMSController">
        <?php require_once("includes/titulo.php"); 
        require_once("includes/menu.php"); 
        ?>
        <ul class="breadcrumb">
            <li><a href="principal.php">Home</a></li>
            <li><a href="admSicasServidor.php">Servidor</a></li>
            <li class="active">Consulta Servidor SAMS</li>
        </ul>
<?php 
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
        <form class="form-inline" action="" target="_blank">
            <button id="btnGerar" data-loading-text="loading..." type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Gerar</button>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
</body>
</html>