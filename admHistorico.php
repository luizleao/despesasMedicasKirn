<?php
require_once("classes/autoload.php");

$oController = new ControllerHistorico();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['codigo'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aHistorico = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["historico.codigo"], $_REQUEST['pag']);
//Util::trace($aHistorico);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<?php require_once("includes/header.php");?>
</head>
<body>
	<div class="container">
		<?php require_once("includes/titulo.php");?>
		<?php require_once("includes/menu.php");?>
		<ol class="breadcrumb">
			<li><a href="home.php">Home</a></li>
			<li class="active">Administrar Historico</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Historico" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmHistorico.php" class="btn btn-success btn-sm" title="Cadastrar Historico"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aHistorico){
?>	
			<thead>
				<tr>
					<th>Código</th>
					<th>Data_</th>
					<th>Entidade</th>
					<th>Ip</th>
					<th>Tipo de Persistência</th>
					<th>Usuario</th>
					<th>Xml</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aHistorico as $oHistorico){
?>
				<tr>
					<td><?=$oHistorico->codigo?></td>
					<td><?=Util::formataDataHoraBancoForm($oHistorico->data_historico)?></td>
					<td><?=$oHistorico->entidade?></td>
					<td><?=$oHistorico->ip?></td>
					<td><?=$oHistorico->tipo_persistencia?></td>
					<td><?=$oHistorico->usuario?></td>
					<td><?=$oHistorico->xml?></td>
					<td><a id="btnDetalhes" data-id="<?=$oHistorico->codigo;?>" class="btn btn-info btn-xs" href="#" title="Detalhes Historico"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmHistorico.php?codigo=<?=$oHistorico->codigo;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="codigo" data-id-valor="<?=$oHistorico->codigo;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="10">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aHistorico){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="Historico" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>