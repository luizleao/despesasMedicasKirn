<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasEstadoCivil();

$oSicasEstadoCivil = ($_REQUEST['cd_estado_civil'] == "") ? NULL : $oController->get($_REQUEST['cd_estado_civil']);
$label   = (is_null($oSicasEstadoCivil)) ? "Cadastrar" : "Editar";
 

// ================= Edicao do SicasEstadoCivil =========================
if($_POST) {
    $operacao = (is_object($oSicasEstadoCivil)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <?php require_once("includes/modals.php");?>
    <div class="container">
        <?php
		require_once("includes/titulo.php");
		require_once("includes/menu.php");
		?>
        <ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li><a href="admSicasEstadoCivil.php">Estado Civil</a></li>
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
        				<label for="nm_estado_civil">Estado Civil</label> 
        				<input type="text" class="form-control" id="nm_estado_civil" name="nm_estado_civil" value="<?=$oSicasEstadoCivil->nm_estado_civil?>" />
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
        				<label for="status">Status</label> 
        				<input type="text" class="form-control" id="status" name="status" value="<?=$oSicasEstadoCivil->status?>" />
        			</div>
        		</div>
    		</div>
			<div class="row">
				<div class="col-md-6">
    				<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
    				<a class="btn btn-default" href="admSicasEstadoCivil.php">Voltar</a>
    				<input name="cd_estado_civil" type="hidden" id="cd_estado_civil" value="<?=$_REQUEST['cd_estado_civil']?>" />
    			</div>
			</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>