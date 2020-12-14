<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasEspecialidadeMedica();

$oSicasEspecialidadeMedica = ($_REQUEST['cd_especialidade_medica'] == "") ? NULL : $oController->get($_REQUEST['cd_especialidade_medica']);
$label   = (is_null($oSicasEspecialidadeMedica)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasEspecialidadeMedica)) ? ($oController->alterar()) : ($oController->cadastrar());
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
			<li><a href="admSicasEspecialidadeMedica.php">Especialidade Médica</a></li>
			<li class="active"><?=$label?></li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg ( $oController->msg, "erro" );
?>
        <form role="form" onsubmit="return false;">
			<div class="row">
    			<div class="col-md-4">
        			<div class="form-group">
        				<label for="nm_especialidade">Especialidade</label> 
        				<input type="text" class="form-control" id="nm_especialidade" name="nm_especialidade" value="<?=$oSicasEspecialidadeMedica->nm_especialidade?>" />
        			</div>
        		</div>
        		<div class="col-md-4">
    				<div class="form-group">
    					<label for="nm_lotacao">Status</label> 
    					<select id="status" name="status" class="form-control">
    					<option value="" disabled="disabled">Selecione</option>
    						<option value="1"<?=($oSicasEspecialidadeMedica->status==1) ? " selected" : ""?>>ATIVO</option>
    						<option value="0"<?=($oSicasEspecialidadeMedica->status==0) ? " selected" : ""?>>INATIVO</option>
    					</select>
    				</div>
    			</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4">
    				<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
    				<a class="btn btn-default" href="admSicasEspecialidadeMedica.php">Voltar</a>
    				<input name="cd_especialidade_medica" type="hidden" id="cd_especialidade_medica" value="<?=$_REQUEST['cd_especialidade_medica']?>" />
        		</div>
        	</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>