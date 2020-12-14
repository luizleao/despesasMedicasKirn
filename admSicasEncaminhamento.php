<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasEncaminhamento();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_encaminhamento'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasEncaminhamento = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_encaminhamento.cd_encaminhamento"], $_REQUEST['pag']);
//Util::trace($aSicasEncaminhamento);
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
			<li class="active">Administrar SicasEncaminhamento</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar SicasEncaminhamento" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasEncaminhamento.php" class="btn btn-success btn-sm" title="Cadastrar SicasEncaminhamento"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasEncaminhamento){
?>	
			<thead>
				<tr>
					<th>Cd_encaminhamento</th>
					<th>Dt_encaminhamento</th>
					<th>SicasMedico</th>
					<th>SicasPessoa</th>
					<th>SicasConsultaMedica</th>
					<th>SicasCredenciado</th>
					<th>Tipo_guia</th>
					<th>Status</th>
					<th>SicasTipoDespesa</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasEncaminhamento as $oSicasEncaminhamento){
?>
				<tr>
					<td><?=$oSicasEncaminhamento->cd_encaminhamento?></td>
					<td><?=Util::formataDataHoraBancoForm($oSicasEncaminhamento->dt_encaminhamento)?></td>
					<td><?=$oSicasEncaminhamento->oSicasMedico->login?></td>
					<td><?=$oSicasEncaminhamento->oSicasPessoa->nm_pessoa?></td>
					<td><?=$oSicasEncaminhamento->oSicasConsultaMedica->cd_consulta_medica?></td>
					<td><?=$oSicasEncaminhamento->oSicasCredenciado->nm_credenciado?></td>
					<td><?=$oSicasEncaminhamento->tipo_guia?></td>
					<td><?=$oSicasEncaminhamento->status?></td>
					<td><?=$oSicasEncaminhamento->oSicasTipoDespesa->cd_tipo_despesa?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasEncaminhamento->cd_encaminhamento;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasEncaminhamento"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasEncaminhamento.php?cd_encaminhamento=<?=$oSicasEncaminhamento->cd_encaminhamento;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_encaminhamento" data-id-valor="<?=$oSicasEncaminhamento->cd_encaminhamento;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="12">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasEncaminhamento){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasEncaminhamento" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>