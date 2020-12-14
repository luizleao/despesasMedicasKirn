<?php
require_once("classes/autoload.php");
$oController = new ControllerRhFeriado();

$oRhFeriado = ($_REQUEST['cd_feriado'] == "") ? NULL : $oController->get($_REQUEST['cd_feriado']);
$label   = (is_null($oRhFeriado)) ? "Cadastrar" : "Editar";

// ================= Edicao do RhFeriado ========================= 
if($_POST){
    $operacao = (is_object($oRhFeriado)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}
//Util::trace($oRhFeriado);
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
			<li><a href="admRhFeriado.php">Feriado</a></li>
			<li class="active"><?=$label?></li>
		</ol>
<?php
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
        <form role="form" onsubmit="return false;">

			<div class="row">
				<div class="col-md-4">
					<label for="data_feriado">Data</label>
                    <?php $oController->componenteCalendario('data_feriado', Util::formataDataBancoForm($oRhFeriado->data_feriado))?>
                </div>
				<div class="col-md-4">    
                    <div class="form-group">
						<label for="descricao_feriado">Descrição</label> 
						<input type="text" class="form-control" id="descricao_feriado" name="descricao_feriado" value="<?=$oRhFeriado->descricao_feriado?>" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="esfera_feriado">Esfera</label> 
						<select name="esfera_feriado" id="esfera_feriado" class="form-control">
							<option value="FEDERAL"<?=($oRhFeriado->esfera_feriado == "FEDERAL") ? " selected" : ""?>>FEDERAL</option>
							<option value="ESTADUAL"<?=($oRhFeriado->esfera_feriado == "ESTADUAL") ? " selected" : ""?>>ESTADUAL</option>
							<option value="MUNICIPAL"<?=($oRhFeriado->esfera_feriado == "MUNICIPAL") ? " selected" : ""?>>MUNICIPAL</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-actions">
						<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
						<a class="btn btn-default" href="admRhFeriado.php">Voltar</a> 
						<input name="cd_feriado" type="hidden" id="cd_feriado" value="<?=$_REQUEST['cd_feriado']?>" /> 
						<input type="hidden" name="classe" id="classe" value="RhFeriado" />
					</div>
				</div>
			</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>