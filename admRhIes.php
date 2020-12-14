<?php
require_once("classes/autoload.php");

$oController = new ControllerRhIes();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_ies'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aRhIes = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["rh_ies.cd_ies"], $_REQUEST['pag']);
//Util::trace($aRhIes);
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
			<li class="active">Administrar IES</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar IES" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmRhIes.php" class="btn btn-success btn-sm" title="Cadastrar IES"><i class="glyphicon glyphicon-plus"></i></a>
					</span>
					</div>
				</div>
			</div>
		</form>

<?php 
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
		<table class="table table-condensed table-striped">
<?php
if($aRhIes){
?>	
			<thead>
				<tr>
					<th>Sigla</th>
					<th>Descrição</th>
					<th>Endereço</th>
					<th>Telefone</th>
					<th>E-mail</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aRhIes as $oRhIes){
?>
				<tr>
					<td><?=$oRhIes->sigla?></td>
					<td><?=$oRhIes->descricao?></td>
					<td><?=$oRhIes->endereco?></td>
					<td><?=$oRhIes->telefone1?></td>
					<td><?=$oRhIes->email?></td>
					<td><?=Util::getStatus($oRhIes->status)?></td>
					<td><a class="btn btn-info btn-xs" href="#" title="Detalhes IES" onclick="verDetalhe(<?=$oRhIes->cd_ies;?>)"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmRhIes.php?cd_ies=<?=$oRhIes->cd_ies;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-xs" href="javascript: void(0);" onclick="excluir('cd_ies','<?=$oRhIes->cd_ies;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="9">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
else{
?>
				<tr>
					<td colspan="9" align="center">Não há registros cadastrados!</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		<input type="hidden" name="classe" id="classe" value="RhIes" />
	</div>
	<?php require_once("includes/footer.php")?>
</body>
</html>