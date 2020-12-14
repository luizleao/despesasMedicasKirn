<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasParamDesconto();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_param_desc'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasParamDesconto = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_param_desconto.cd_param_desc"], $_REQUEST['pag']);
//Util::trace($aSicasParamDesconto);
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
			<li class="active">Administrar Parâmetros de Desconto</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Parâmetro de Desconto" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasParamDesconto.php" class="btn btn-success btn-sm" title="Cadastrar SicasParamDesconto"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasParamDesconto){
?>	
			<thead>
				<tr>
					<th>Descrição</th>
					<th>Percentagem (%)</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasParamDesconto as $oSicasParamDesconto){
?>
				<tr>
					<td><?=$oSicasParamDesconto->descricao_param?></td>
					<td><?=$oSicasParamDesconto->percentagem_desconto?></td>
					<td><?=Util::getStatus($oSicasParamDesconto->status)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasParamDesconto->cd_param_desc;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasParamDesconto"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasParamDesconto.php?cd_param_desc=<?=$oSicasParamDesconto->cd_param_desc;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_param_desc" data-id-valor="<?=$oSicasParamDesconto->cd_param_desc;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="7">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasParamDesconto){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasParamDesconto" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>