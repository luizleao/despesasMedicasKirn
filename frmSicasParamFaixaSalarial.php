<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasParamFaixaSalarial();

$oSicasParamFaixaSalarial = ($_REQUEST['cd_param_faixa_sal'] == "") ? NULL  : $oController->get($_REQUEST['cd_param_faixa_sal']);
$label   = (is_null($oSicasParamFaixaSalarial)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasParamFaixaSalarial)) ? ($oController->alterar()) : ($oController->cadastrar());
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
            <li><a href="admSicasParamFaixaSalarial.php">SicasParamFaixaSalarial</a></li>
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
                		<label for="flg_faixa_ini_inclusive">Flg_faixa_ini_inclusive</label>
                		<input type="text" class="form-control" id="flg_faixa_ini_inclusive" name="flg_faixa_ini_inclusive" value="<?=$oSicasParamFaixaSalarial->flg_faixa_ini_inclusive?>" />
                	</div>
                </div>
                
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="flg_faixa_fin_inclusive">Flg_faixa_fin_inclusive</label>
                		<input type="text" class="form-control" id="flg_faixa_fin_inclusive" name="flg_faixa_fin_inclusive" value="<?=$oSicasParamFaixaSalarial->flg_faixa_fin_inclusive?>" />
                	</div>
                </div>
                
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<input type="text" class="form-control" id="status" name="status" value="<?=$oSicasParamFaixaSalarial->status?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="servidor_efetivo">Servidor_efetivo</label>
                		<input type="text" class="form-control" id="servidor_efetivo" name="servidor_efetivo" value="<?=$oSicasParamFaixaSalarial->servidor_efetivo?>" />
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasParamFaixaSalarial.php">Voltar</a>
                        <input name="cd_param_faixa_sal" type="hidden" id="cd_param_faixa_sal" value="<?=$_REQUEST['cd_param_faixa_sal']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasParamFaixaSalarial" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>