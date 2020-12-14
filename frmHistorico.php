<?php
require_once("classes/autoload.php");
$oController = new ControllerHistorico();

$oHistorico = ($_REQUEST['codigo'] == "") ? NULL        : $oController->get($_REQUEST['codigo']);
$label   = (is_null($oHistorico)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oHistorico)) ? ($oController->alterar()) : ($oController->cadastrar());
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
            <li><a href="admHistorico.php">Historico</a></li>
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
                	    <label for="data_historico">Data_</label>
                	    <?php $oController->componenteCalendario('data_historico', Util::formataDataHoraBancoForm($oHistorico->data_historico), NULL, true)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="entidade">Entidade</label>
                		<input type="text" class="form-control" id="entidade" name="entidade" value="<?=$oHistorico->entidade?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="ip">Ip</label>
                		<input type="text" class="form-control" id="ip" name="ip" value="<?=$oHistorico->ip?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="tipo_persistencia">Tipo_persistencia</label>
                		<input type="text" class="form-control" id="tipo_persistencia" name="tipo_persistencia" value="<?=$oHistorico->tipo_persistencia?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="usuario">Usuario</label>
                		<input type="text" class="form-control" id="usuario" name="usuario" value="<?=$oHistorico->usuario?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="xml">Xml</label>
                		<input type="text" class="form-control" id="xml" name="xml" value="<?=$oHistorico->xml?>" />
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admHistorico.php">Voltar</a>
                        <input name="codigo" type="hidden" id="codigo" value="<?=$_REQUEST['codigo']?>" />
                        <input type="hidden" name="classe" id="classe" value="Historico" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>