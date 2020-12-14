<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasGrauParentesco();

$oSicasGrauParentesco = ($_REQUEST['cd_grau_parentesco'] == "") ? NULL : $oController->get($_REQUEST['cd_grau_parentesco']);
$label   = (is_null($oSicasGrauParentesco)) ? "Cadastrar" : "Editar";


if($_POST) {
    $operacao = (is_object($oSicasGrauParentesco)) ? ($oController->alterar()) : ($oController->cadastrar());
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
			<li><a href="admSicasGrauParentesco.php">Grau de Parentesco</a></li>
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
						<label for="nm_grau_parentesco">Resumo</label> 
						<input type="text" class="form-control" id="nm_grau_parentesco" name="nm_grau_parentesco" value="<?=$oSicasGrauParentesco->nm_grau_parentesco?>" />
					</div>
					<div class="form-group">
						<label for="desc_grauparentesco">Descrição</label> 
						<input type="text" class="form-control" id="desc_grauparentesco" name="desc_grauparentesco" value="<?=$oSicasGrauParentesco->desc_grauparentesco?>" />
					</div>
					<div class="form-group">
						<label for="status">Ativo?</label> 
						<select id="status" name="status" class="form-control">
							<option value="1"<?=($oSicasGrauParentesco->status == '1') ? " checked" : "" ?>>Sim</option>
							<option value="0"<?=($oSicasGrauParentesco->status == '0') ? " checked" : "" ?>>Não</option>
						</select>
					</div>
					<div class="form-actions">
						<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
						<a class="btn btn-default" href="admSicasGrauParentesco.php">Voltar</a>
						<input name="cd_grau_parentesco" type="hidden" id="cd_grau_parentesco" value="<?=$_REQUEST['cd_grau_parentesco']?>" />
						<input type="hidden" name="classe" id="classe" value="SicasGrauParentesco" />
					</div>
				</div>
			</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>