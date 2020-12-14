<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasParamFaixaSalarial();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_param_faixa_sal'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasParamFaixaSalarial = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_param_faixa_salarial.cd_param_faixa_sal"], $_REQUEST['pag']);
//Util::trace($aSicasParamFaixaSalarial);
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
			<li class="active">Administrar Parâmetros de Faixa Salarial</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Parâmetros de Faixa Salarial" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasParamFaixaSalarial.php" class="btn btn-success btn-sm" title="Cadastrar SicasParamFaixaSalarial"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasParamFaixaSalarial){
?>	
			<thead>
				<tr>
					<th>Faixa Inicial</th>
					<th>Inicial</th>
					<th>Faixa Final</th>
					<th>Final</th>
					<th>Desconto (%)</th>
					<th>Status</th>
					<th>Servidor Efetivo?</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasParamFaixaSalarial as $oSicasParamFaixaSalarial){
?>
				<tr>
					<td><?=$oSicasParamFaixaSalarial->val_faixa_inicial?></td>
					<td><?=($oSicasParamFaixaSalarial->flg_faixa_ini_inclusive == 1) ? "Inclusive" : "Exclusive"?></td>
					<td><?=$oSicasParamFaixaSalarial->val_faixa_final?></td>
					<td><?=($oSicasParamFaixaSalarial->flg_faixa_fin_inclusive == 1) ? "Inclusive" : "Exclusive"?></td>
					<td><?=$oSicasParamFaixaSalarial->percentagem_desconto?></td>
					<td><?=Util::getStatus($oSicasParamFaixaSalarial->status)?></td>
					<td><?=Util::getSimNao($oSicasParamFaixaSalarial->servidor_efetivo)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasParamFaixaSalarial->cd_param_faixa_sal;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasParamFaixaSalarial"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasParamFaixaSalarial.php?cd_param_faixa_sal=<?=$oSicasParamFaixaSalarial->cd_param_faixa_sal;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" data-id="cd_param_faixa_sal" data-id-valor="<?=$oSicasParamFaixaSalarial->cd_param_faixa_sal;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
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
if(!$aSicasParamFaixaSalarial){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasParamFaixaSalarial" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>