<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasFatura();

$oSicasFatura = ($_REQUEST['cd_fatura'] == "") ? NULL        : $oController->get($_REQUEST['cd_fatura']);
$label   = (is_null($oSicasFatura)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasFatura)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerSicasCredenciado = new ControllerSicasCredenciado();$aSicasCredenciado = $oControllerSicasCredenciado->getAll([], []);
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
            <li><a href="admSicasFatura.php">SicasFatura</a></li>
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
		<label for="cd_credenciado">SicasCredenciado</label>
		<select name="cd_credenciado" id="cd_credenciado" class="form-control">
			<option value="">Selecione</option>
		<?php
		foreach($aSicasCredenciado as $oSicasCredenciado){
		?>
			<option value="<?=$oSicasCredenciado->cd_credenciado?>"<?=($oSicasCredenciado->cd_credenciado == $oSicasFatura->oSicasCredenciado->cd_credenciado) ? " selected" : ""?>><?=$oSicasCredenciado->nm_credenciado?></option>
		<?php
		}
		?>
		</select>
	</div>
</div>
<div class="col-md-4">
	<div class="form-group">
		<label for="num_nota">Num_nota</label>
		<input type="text" class="form-control" id="num_nota" name="num_nota" value="<?=$oSicasFatura->num_nota?>" />
	</div>
</div>
<div class="col-md-4">
	<div class="form-group">
	    <label for="dt_cadastro">Dt_cadastro</label>
	    <?php $oController->componenteCalendario('dt_cadastro', Util::formataDataBancoForm($oSicasFatura->dt_cadastro), NULL, false)?>
	</div>
</div>
<div class="col-md-4">
	<div class="form-group">
		<label for="status">Status</label>
		<input type="text" class="form-control" id="status" name="status" value="<?=$oSicasFatura->status?>" />
	</div>
</div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasFatura.php">Voltar</a>
                        <input name="cd_fatura" type="hidden" id="cd_fatura" value="<?=$_REQUEST['cd_fatura']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasFatura" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>