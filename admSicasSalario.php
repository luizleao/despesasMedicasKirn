<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasSalario();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_salario'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasSalario = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll(["tb.sicas_servidor_status = 1"], ["tb.sicas_pessoa_nm_pessoa"], $_REQUEST['pag']);
//Util::trace($aSicasSalario);
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
			<li class="active">Administrar Salário</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Salário" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasSalario.php" class="btn btn-success btn-sm" title="Cadastrar SicasSalario"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasSalario){
?>	
			<thead>
				<tr>
					<th>Servidor</th>
					<th>Salário</th>
					<th>Data Início</th>
					<th>Data Fim</th>
					<th>Efetivo</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasSalario as $oSicasSalario){
	    
?>
				<tr>
					<td><?=$oSicasSalario->oSicasServidor->oSicasPessoa->nm_pessoa?></td>
					<td><?=Util::formataMoeda($oSicasSalario->val_salario)?></td>
					<td><?=Util::formataDataBancoForm($oSicasSalario->dt_ini_salario)?></td>
					<td><?=Util::formataDataBancoForm($oSicasSalario->dt_fim_salario)?></td>
					<td><?=Util::getSimNao($oSicasSalario->serv_efetivo)?></td>
					<td><?=Util::getStatus($oSicasSalario->status)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasSalario->cd_salario;?>" class="btn btn-info btn-xs" href="#" title="Detalhes Salario"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasSalario.php?cd_salario=<?=$oSicasSalario->cd_salario;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_salario" data-id-valor="<?=$oSicasSalario->cd_salario;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="11">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasSalario){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasSalario" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>