<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasEscolaridade();

$oSicasEscolaridade = ($_REQUEST['cd_escolaridade'] == "") ? NULL : $oController->get($_REQUEST['cd_escolaridade']);
$label   = (is_null($oSicasEscolaridade)) ? "Cadastrar" : "Editar";

if ($_POST) {
    $operacao = (is_object($oSicasEscolaridade)) ? ($oController->alterar()) : ($oController->cadastrar());
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
			<li><a href="admSicasEscolaridade.php">Escolaridade</a></li>
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
						<label for="nm_escolaridade">Descrição</label> 
						<input type="text" class="form-control" id="nm_escolaridade" name="nm_escolaridade" value="<?=$oSicasEscolaridade->nm_escolaridade?>" />
					</div>
					<div class="form-group">
						<label for="status">Ativo?</label> 
						<select id="status" name="status" class="form-control">
							<option value="1"<?=($oSicasEscolaridade->status == '1') ? " checked" : "" ?>>Sim</option>
							<option value="0"<?=($oSicasEscolaridade->status == '0') ? " checked" : "" ?>>Não</option>
						</select>
					</div>
					<div class="form-actions">
						<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
						<a class="btn btn-default" href="admSicasEscolaridade.php">Voltar</a>
						<input name="cd_escolaridade" type="hidden" id="cd_escolaridade" value="<?=$_REQUEST['cd_escolaridade']?>" />
						<input type="hidden" name="classe" id="classe" value="SicasEscolaridade" />
					</div>
				</div>
			</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>