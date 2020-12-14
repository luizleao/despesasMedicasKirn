<?php
require_once("classes/autoload.php");
$oController = new ControllerRhCargo();

$oRhCargo = ($_REQUEST['cd_cargo'] == "") ? NULL : $oController->get($_REQUEST['cd_cargo']);
$label   = (is_null($oRhCargo)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oRhCargo)) ? ($oController->alterar()) : ($oController->cadastrar());
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
			<li><a href="admRhCargo.php">Cargo</a></li>
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
        				<label for="descricao_cargo">Descrição do Cargo</label> 
        				<input type="text" class="form-control" id="descricao_cargo" name="descricao_cargo" value="<?=$oRhCargo->descricao_cargo?>" />
        			</div>
        		</div>
    			<div class="col-md-4">        	
        			<div class="form-group">
        				<label for="descricao_cargo_abrev">Abreviação</label> 
        				<input type="text" class="form-control" id="descricao_cargo_abrev" name="descricao_cargo_abrev" value="<?=$oRhCargo->descricao_cargo_abrev?>" />
        			</div>
				</div>
    			<div class="col-md-4">
        			<div class="form-group">
        				<label for="num_siape_cargo">Número SIAPE do Cargo</label> 
        				<input type="text" class="form-control" id="num_siape_cargo" name="num_siape_cargo" value="<?=$oRhCargo->num_siape_cargo?>" />
        			</div>
				</div>
    			<div class="col-md-4">
    				<div class="form-group">
    					<label for="nm_lotacao">Status</label> 
    					<select id="status" name="status" class="form-control">
    					<option value="" disabled="disabled">Selecione</option>
    						<option value="1"<?=($oRhCargo->status==1) ? " selected" : ""?>>ATIVO</option>
    						<option value="0"<?=($oRhCargo->status==0) ? " selected" : ""?>>INATIVO</option>
    					</select>
    				</div>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-md-6">
    				<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
    				<a class="btn btn-default" href="admRhCargo.php">Voltar</a> 
    				<input name="cd_cargo" type="hidden" id="cd_cargo" value="<?=$_REQUEST['cd_cargo']?>" />
    				<input name="classe" type="hidden" id="classe" value="RhCargo" />
    			</div>
    		</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>