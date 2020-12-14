<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasParamDesconto();

$oSicasParamDesconto = ($_REQUEST['cd_param_desc'] == "") ? NULL : $oController->get($_REQUEST['cd_param_desc']);
$label   = (is_null($oSicasParamDesconto)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasParamDesconto)) ? $oController->alterar() : $oController->cadastrar();
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
            <li><a href="admSicasParamDesconto.php">SicasParamDesconto</a></li>
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
                		<label for="descricao_param">Descricao_param</label>
                		<input type="text" class="form-control" id="descricao_param" name="descricao_param" value="<?=$oSicasParamDesconto->descricao_param?>" />
                	</div>
                </div>
                
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<input type="text" class="form-control" id="status" name="status" value="<?=$oSicasParamDesconto->status?>" />
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasParamDesconto.php">Voltar</a>
                        <input name="cd_param_desc" type="hidden" id="cd_param_desc" value="<?=$_REQUEST['cd_param_desc']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasParamDesconto" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>