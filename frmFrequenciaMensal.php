<?php
require_once("classes/autoload.php");
$oController = new Controller();

// ================= Cadastrar SicasPessoa ========================= 
$aLotacao = (new ControllerSicasLotacao())->getAll(["sicas_lotacao.status = 1"], ["sicas_lotacao.sigla"]);
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
    <div class="container" ng-controller="frmFrequenciaMensalController">
        <?php require_once("includes/titulo.php"); 
        require_once("includes/menu.php"); 
        ?>
        <ul class="breadcrumb">
            <li><a href="principal.php">Home</a></li>
            <li><a href="admSicasServidor.php">Servidor</a></li>
            <li class="active">Frequência Mensal</li>
        </ul>
<?php 
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
        <form class="form-inline" action="resFrequenciaMensal.php" target="_blank">
            <label for="cd_lotacao">Unidade</label>
            <select name="cd_lotacao" id="cd_lotacao" class="form-control" ng-model="cd_lotacao" ng-change="getAllServidorLotacao()">
                <option value="">Selecione</option>
<?php
foreach($aLotacao as $oLotacao){
?>
                <option value="<?=$oLotacao->cd_lotacao?>"><?=$oLotacao->sigla?></option>
<?php
}
?>
            </select>
            <label for="cd_servidor">Servidor</label>
            <select name       = "cd_servidor" 
                    id         = "cd_servidor" 
                    class      = "form-control" 
                    ng-model   = "cd_servidor"
                    ng-options = "oSicasServidor.oSicasPessoa.nm_pessoa for oSicasServidor in aSicasServidor track by oSicasServidor.cd_servidor">
                <option value="">Todos</option>
            </select>
            <label for="mesano">Mês/Ano</label>
            <input type="text" id="mesano" name="mesano" class="mesano form-control" size="7" value="{{mesano| date: 'MM/yyyy'}}" required />
            <button id="btnGerar" data-loading-text="loading..." type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Gerar</button>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
</body>
</html>