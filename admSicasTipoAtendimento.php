<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasTipoAtendimento();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_tipo_atendimento'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasTipoAtendimento = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_tipo_atendimento.cd_tipo_atendimento"], $_REQUEST['pag']);
//Util::trace($aSicasTipoAtendimento);
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
			<li class="active">Administrar Tipo de Atendimento</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Tipo de Atendimento" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasTipoAtendimento.php" class="btn btn-success btn-sm" title="Cadastrar SicasTipoAtendimento"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasTipoAtendimento){
?>	
			<thead>
				<tr>
					<th>Descrição</th>
					<th>Atendimento</th>
					<th>Perícia</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasTipoAtendimento as $oSicasTipoAtendimento){
?>
				<tr>
					<td><?=$oSicasTipoAtendimento->nm_tipo_atendimento?></td>
					<td><?=($oSicasTipoAtendimento->fl_atendimento == 'M') ? "Médico": "Odontológico"?></td>
					<td><?=Util::getSimNao($oSicasTipoAtendimento->pericia)?></td>
					<td><?=Util::getStatus($oSicasTipoAtendimento->status)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasTipoAtendimento->cd_tipo_atendimento;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasTipoAtendimento"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasTipoAtendimento.php?cd_tipo_atendimento=<?=$oSicasTipoAtendimento->cd_tipo_atendimento;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_tipo_atendimento" data-id-valor="<?=$oSicasTipoAtendimento->cd_tipo_atendimento;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
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
if(!$aSicasTipoAtendimento){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasTipoAtendimento" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>