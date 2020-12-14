<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasPessoaCategoria();

$oSicasPessoaCategoria = ($_REQUEST['cd_categoria'] == "") ? NULL : $oController->get($_REQUEST['cd_categoria']);
$label   = (is_null($oSicasPessoaCategoria)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasPessoaCategoria)) ? ($oController->alterar()) : ($oController->cadastrar());
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
			<li><a href="admSicasPessoaCategoria.php">Categoria de Pessoa</a></li>
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
						<label for="desc_categoria">Descrição</label> 
						<input type="text" class="form-control" id="desc_categoria" name="desc_categoria" value="<?=$oSicasPessoaCategoria->desc_categoria?>" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="desc_categoria_abrev">Abreviação</label> 
						<input type="text" class="form-control" id="desc_categoria_abrev" name="desc_categoria_abrev" value="<?=$oSicasPessoaCategoria->desc_categoria_abrev?>" />
					</div>
				</div>
        	</div>
        	<div class="row">
				<div class="col-md-6">
					<div class="form-actions">
						<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
						<a class="btn btn-default" href="admSicasPessoaCategoria.php">Voltar</a>
						<input name="cd_categoria" type="hidden" id="cd_categoria" value="<?=$_REQUEST['cd_categoria']?>" />
						<input type="hidden" name="classe" id="classe" value="SicasPessoaCategoria" />
					</div>
				</div>
			</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>