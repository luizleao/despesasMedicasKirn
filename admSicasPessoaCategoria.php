<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasPessoaCategoria();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_param_desc'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasPessoaCategoria = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_pessoa_categoria.desc_categoria"], $_REQUEST['pag']);
//Util::trace($aSicasPessoaCategoria);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <?php require_once("includes/modals.php");?>
    <div class="container">
        <?php require_once("includes/titulo.php");?>
        <?php require_once("includes/menu.php");?>
        <ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li class="active">Administrar Categorias Pessoa</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Categoria Pessoa" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasPessoaCategoria.php" class="btn btn-success btn-sm" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>
					</span>
					</div>
				</div>
			</div>
			<input type="hidden" name="classe" id="classe" value="SicasPessoaCategoria" />
		</form>
<?php
if ($oController->msg != "")
	$oController->componenteMsg ( $oController->msg, "erro" );
?>
        <table class="table table-striped table-condensed">
<?php
if($aSicasPessoaCategoria){
?>
	
            <thead>
				<tr>
					<th>Descrição</th>
					<th>Abreviação</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasPessoaCategoria as $oSicasPessoaCategoria){
?>
                <tr>
					<td><?=$oSicasPessoaCategoria->desc_categoria?></td>
					<td><?=$oSicasPessoaCategoria->desc_categoria_abrev?></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasPessoaCategoria.php?cd_categoria=<?=$oSicasPessoaCategoria->cd_categoria;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-xs" href="javascript: void(0);" onclick="excluir('cd_categoria','<?=$oSicasPessoaCategoria->cd_categoria;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
    				<td colspan="7">
    					<?php $oController->componentePaginacao($numPags);?>
    				</td>
				</tr>
            </tbody>
<?php
} else {
?>
            <tr>
				<td colspan="5" align="center">Não há registros cadastrados!</td>
			</tr>
<?php
}
?>
		</table>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>