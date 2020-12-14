<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasConsultaMedica();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_consulta_medica'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasConsultaMedica = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_consulta_medica.cd_consulta_medica"], $_REQUEST['pag']);
//Util::trace($aSicasConsultaMedica);
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
			<li class="active">Administrar Consulta Médica</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Consulta Médica" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasConsultaMedica.php" class="btn btn-success btn-sm" title="Cadastrar SicasConsultaMedica"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasConsultaMedica){
?>	
			<thead>
				<tr>
					<th>SicasAtendimento</th>
					<th>Dt_consulta</th>
					<th>SicasMedico</th>
					<th>Qp_paciente</th>
					<th>Exame_fisico</th>
					<th>Exame_solicitado</th>
					<th>Diag_paciente</th>
					<th>SicasTipoAtendimento</th>
					<th>Resultado</th>
					<th>Tratamento</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasConsultaMedica as $oSicasConsultaMedica){
	    //Util::trace($oSicasConsultaMedica);
?>
				<tr>
					<td><?=$oSicasConsultaMedica->oSicasAtendimento->cd_atendimento?></td>
					<td><?=Util::formataDataHoraBancoForm($oSicasConsultaMedica->dt_consulta)?></td>
					<td><?=$oSicasConsultaMedica->oSicasMedico->login?></td>
					<td><?=$oSicasConsultaMedica->qp_paciente?></td>
					<td><?=$oSicasConsultaMedica->exame_fisico?></td>
					<td><?=$oSicasConsultaMedica->exame_solicitado?></td>
					<td><?=$oSicasConsultaMedica->diag_paciente?></td>
					<td><?=$oSicasConsultaMedica->oSicasTipoAtendimento->nm_tipo_atendimento?></td>
					<td><?=$oSicasConsultaMedica->resultado?></td>
					<td><?=$oSicasConsultaMedica->tratamento?></td>
					<td><?=Util::getStatus($oSicasConsultaMedica->status)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasConsultaMedica->cd_consulta_medica;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasConsultaMedica"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasConsultaMedica.php?cd_consulta_medica=<?=$oSicasConsultaMedica->cd_consulta_medica;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_consulta_medica" data-id-valor="<?=$oSicasConsultaMedica->cd_consulta_medica;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="15">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasConsultaMedica){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasConsultaMedica" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>