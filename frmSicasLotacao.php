<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasLotacao();

$oSicasLotacao = ($_REQUEST['cd_lotacao'] == "") ? NULL : $oController->get($_REQUEST['cd_lotacao']);
$label   = (is_null($oSicasLotacao)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasLotacao)) ? ($oController->alterar()) : ($oController->cadastrar());
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
			<li><a href="admSicasLotacao.php">Lotação</a></li>
			<li class="active"><?=$label?></li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
		<form role="form" onsubmit="return false;">
            <div class="row">
    			<div class="col-md-4">
    				<div class="form-group">
    					<label for="sigla">Sigla</label> 
    					<input type="text" class="form-control" id="sigla" name="sigla" value="<?=$oSicasLotacao->sigla?>" />
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class="form-group">
    					<label for="cd_siged">Código SIGED</label> 
    					<input type="text" class="form-control" id="cd_siged" name="cd_siged" value="<?=$oSicasLotacao->cd_siged?>" />
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class="form-group">
    					<label for="nm_lotacao">Nome da Lotação</label> 
    					<input type="text" class="form-control" id="nm_lotacao" name="nm_lotacao" value="<?=$oSicasLotacao->nm_lotacao?>" />
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class="form-group">
    					<label for="nm_lotacao">Status</label> 
    					<select id="status" name="status" class="form-control">
    						<option value="1"<?=($oSicasLotacao->status==1) ? " selected" : ""?>>ATIVO</option>
    						<option value="0"<?=($oSicasLotacao->status==0) ? " selected" : ""?>>INATIVO</option>
    					</select>
    				</div>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-md-6">
    				<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
    				<a class="btn btn-default" href="admSicasLotacao.php">Voltar</a> 
    				<input type="hidden" name="classe" id="classe" value="SicasLotacao" /> 
    				<input type="hidden" name="cd_lotacao" id="cd_lotacao" value="<?=$_REQUEST['cd_lotacao']?>" /> 
    			</div>
    		</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>