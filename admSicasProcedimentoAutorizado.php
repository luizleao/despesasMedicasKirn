<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasProcedimentoAutorizado();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_procedimento_autorizado'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasProcedimentoAutorizado = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_procedimento_autorizado.cd_procedimento_autorizado"], $_REQUEST['pag']);
//Util::trace($aSicasProcedimentoAutorizado);
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
			<li class="active">Administrar SicasProcedimentoAutorizado</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar SicasProcedimentoAutorizado" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasProcedimentoAutorizado.php" class="btn btn-success btn-sm" title="Cadastrar SicasProcedimentoAutorizado"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasProcedimentoAutorizado){
?>	
			<thead>
				<tr>
					<th>Cd_procedimento_autorizado</th>
					<th>SicasEncaminhamento</th>
					<th>SicasProcedimento</th>
					<th>Qtd_servico_autorizado</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasProcedimentoAutorizado as $oSicasProcedimentoAutorizado){
?>
				<tr>
					<td><?=$oSicasProcedimentoAutorizado->cd_procedimento_autorizado?></td>
					<td><?=$oSicasProcedimentoAutorizado->oSicasEncaminhamento->cd_encaminhamento?></td>
					<td><?=$oSicasProcedimentoAutorizado->oSicasProcedimento->cd_procedimento?></td>
					<td><?=$oSicasProcedimentoAutorizado->qtd_servico_autorizado?></td>
					<td><?=$oSicasProcedimentoAutorizado->status?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasProcedimentoAutorizado->cd_procedimento_autorizado;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasProcedimentoAutorizado"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasProcedimentoAutorizado.php?cd_procedimento_autorizado=<?=$oSicasProcedimentoAutorizado->cd_procedimento_autorizado;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_procedimento_autorizado" data-id-valor="<?=$oSicasProcedimentoAutorizado->cd_procedimento_autorizado;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="8">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasProcedimentoAutorizado){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasProcedimentoAutorizado" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>