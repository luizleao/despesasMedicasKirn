<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasConsultaMedicaCid();

$oSicasConsultaMedicaCid = ($_REQUEST[''] == "") ? NULL        : $oController->get($_REQUEST['']);
$label   = (is_null($oSicasConsultaMedicaCid)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasConsultaMedicaCid)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerSicasCid = new ControllerSicasCid();$aSicasCid = $oControllerSicasCid->getAll([], []);
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
            <li><a href="admSicasConsultaMedicaCid.php">SicasConsultaMedicaCid</a></li>
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
                		<label for="cd_cid">SicasCid</label>
                		<select name="cd_cid" id="cd_cid" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasCid as $oSicasCid){
                		?>
                			<option value="<?=$oSicasCid->cd_cid?>"<?=($oSicasCid->cd_cid == $oSicasConsultaMedicaCid->oSicasCid->cd_cid) ? " selected" : ""?>><?=$oSicasCid->desc_cid?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_consulta_medica">Cd_consulta_medica</label>
                		<input type="text" class="form-control" id="cd_consulta_medica" name="cd_consulta_medica" value="<?=$oSicasConsultaMedicaCid->cd_consulta_medica?>" />
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasConsultaMedicaCid.php">Voltar</a>
                        
                        <input type="hidden" name="classe" id="classe" value="SicasConsultaMedicaCid" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>