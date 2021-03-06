<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasProcedimento();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_procedimento'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasProcedimento = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_procedimento.cd_procedimento"], $_REQUEST['pag']);
//Util::trace($aSicasProcedimento);
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
			<li class="active">Administrar Procedimento</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Procedimento" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasProcedimento.php" class="btn btn-success btn-sm" title="Cadastrar SicasProcedimento"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasProcedimento){
?>	
			<thead>
				<tr>
					<th>Número</th>
					<th>Procedimento</th>
					<th>Custo Operacional (R$)</th>
					<th>Honorário (R$)</th>
					<th>Med Filme</th>
					<th>Auxiliares</th>
					<th>Porta Anestesia</th>
					<th>Sigla</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasProcedimento as $oSicasProcedimento){
?>
				<tr>
					<td><?=$oSicasProcedimento->num_procedimento?></td>
					<td><?=$oSicasProcedimento->nm_procedimento?></td>
					<td><?=Util::formataMoeda($oSicasProcedimento->num_custo_operacional)?></td>
					<td><?=Util::formataMoeda($oSicasProcedimento->num_honorario)?></td>
					<td><?=$oSicasProcedimento->num_med_filme?></td>
					<td><?=$oSicasProcedimento->num_auxiliares?></td>
					<td><?=$oSicasProcedimento->num_port_anest?></td>
					<td><?=$oSicasProcedimento->sigla?></td>
					<td><?=Util::getStatus($oSicasProcedimento->status)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasProcedimento->cd_procedimento;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasProcedimento"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasProcedimento.php?cd_procedimento=<?=$oSicasProcedimento->cd_procedimento;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_procedimento" data-id-valor="<?=$oSicasProcedimento->cd_procedimento;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="14">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasProcedimento){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasProcedimento" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>