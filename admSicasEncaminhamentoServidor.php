<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasEncaminhamento();

$oServidor = (new ControllerSicasServidor())->get($_REQUEST['cd_servidor']);

$oProxy = $oController->getProxy();

$aSicasEncaminhamento = $oProxy->viewEncaminhamentoServidorDependente(["cd_servidor=".$_REQUEST['cd_servidor'], 
                                                                                          "DATEDIFF (YEAR , dt_encaminhamento, GETDATE()) <= 2"], 
                                                                                         ["dt_encaminhamento desc, nm_pessoa"]);
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
			<li><a href="admSicasServidor.php">Servidor</a></li>
			<li class="active">Encaminhamentos</li>
		</ol>
		<div class="panel panel-default">
            <div class="panel-body">
            	<strong>Servidor: </strong><?=$oServidor->oSicasPessoa->nm_pessoa?> <strong>Matrícula: </strong><?=$oServidor->cd_matricula?>
            </div>
        </div>

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
					<th>Encaminhamento</th>
					<th>Data</th>
					<th>Nome</th>
					<th>Credenciado</th>
					<th>Tipo Guia</th>
					<th>Tipo de Despesa</th>
					<th>Status</th>
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
					<td><?=Util::formataEncaminhamento($oSicasEncaminhamento['cd_encaminhamento'])?></td>
					<td><?=Util::formataDataHoraBancoForm($oSicasEncaminhamento['dt_encaminhamento'])?></td>
					<td><?=$oSicasEncaminhamento['nm_pessoa']?></td>
					<td><?=$oSicasEncaminhamento['nm_credenciado']?></td>
					<td><?=$oSicasEncaminhamento['tipo_guia']?></td>
					<td><?=$oSicasEncaminhamento['nm_despesa']?></td>
					<td><?=$oSicasEncaminhamento['status_encaminhamento']?></td>
					<td><a href="frmEncaminhamento.php?cd_encaminhamento=<?=$oSicasEncaminhamento['cd_encaminhamento']?>" target="_blank" class="btn btn-info btn-xs" href="#" title="Imprimir Encaminhamento"><i class="glyphicon glyphicon-print"></i></a></td>
				</tr>
<?php
	}
}
?>
			</tbody>
		</table>
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>