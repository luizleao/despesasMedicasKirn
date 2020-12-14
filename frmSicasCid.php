<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasCid();

$oSicasCid = ($_REQUEST['cd_cid'] == "") ? NULL        : $oController->get($_REQUEST['cd_cid']);
$label   = (is_null($oSicasCid)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasCid)) ? ($oController->alterar()) : ($oController->cadastrar());
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
            <li><a href="admSicasCid.php">SicasCid</a></li>
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
                		<label for="desc_cid">Desc_cid</label>
                		<input type="text" class="form-control" id="desc_cid" name="desc_cid" value="<?=$oSicasCid->desc_cid?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="desc_cid_abrev">Desc_cid_abrev</label>
                		<input type="text" class="form-control" id="desc_cid_abrev" name="desc_cid_abrev" value="<?=$oSicasCid->desc_cid_abrev?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_cid_pai">SicasCid</label>
                		<select name="cd_cid_pai" id="cd_cid_pai" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasCid as $oSicasCid){
                		?>
                			<option value="<?=$oSicasCid->cd_cid?>"<?=($oSicasCid->cd_cid_pai == $oSicasCid->oSicasCid->cd_cid) ? " selected" : ""?>><?=$oSicasCid->desc_cid?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasCid.php">Voltar</a>
                        <input name="cd_cid" type="hidden" id="cd_cid" value="<?=$_REQUEST['cd_cid']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasCid" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>