<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasTipoAtendimento();

$oSicasTipoAtendimento = ($_REQUEST['cd_tipo_atendimento'] == "") ? NULL : $oController->get($_REQUEST['cd_tipo_atendimento']);
$label   = (is_null($oSicasTipoAtendimento)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasTipoAtendimento)) ? ($oController->alterar()) : ($oController->cadastrar());
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
            <li><a href="admSicasTipoAtendimento.php">SicasTipoAtendimento</a></li>
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
                		<label for="nm_tipo_atendimento">Nm_tipo_atendimento</label>
                		<input type="text" class="form-control" id="nm_tipo_atendimento" name="nm_tipo_atendimento" value="<?=$oSicasTipoAtendimento->nm_tipo_atendimento?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="fl_atendimento">Fl_atendimento</label>
                		<input type="text" class="form-control" id="fl_atendimento" name="fl_atendimento" value="<?=$oSicasTipoAtendimento->fl_atendimento?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="pericia">Pericia</label>
                		<input type="text" class="form-control" id="pericia" name="pericia" value="<?=$oSicasTipoAtendimento->pericia?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<input type="text" class="form-control" id="status" name="status" value="<?=$oSicasTipoAtendimento->status?>" />
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasTipoAtendimento.php">Voltar</a>
                        <input name="cd_tipo_atendimento" type="hidden" id="cd_tipo_atendimento" value="<?=$_REQUEST['cd_tipo_atendimento']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasTipoAtendimento" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>