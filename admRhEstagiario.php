<?php
require_once("classes/autoload.php");

$oController = new ControllerRhEstagiario();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_estagiario'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aRhEstagiario = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["rh_estagiario.dt_renovacao", "sicas_pessoa.nm_pessoa"], $_REQUEST['pag']);
//Util::trace($aRhEstagiario);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<?php require_once("includes/header.php");?>
</head>
<body>
	<?php require_once("includes/modals.php");?>
	<div class="container">
		<?php require_once("includes/titulo.php");?>
		<?php require_once("includes/menu.php");?>
		<ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li class="active">Administrar Estagiário</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Estagiário" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmRhEstagiario.php" class="btn btn-success btn-sm" title="Cadastrar RhEstagiario"><i class="glyphicon glyphicon-plus"></i></a>
					</span>
					</div>
				</div>
			</div>
		</form>

<?php 
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
		<table class="table table-condensed">
<?php
if($aRhEstagiario){
?>	
			<thead>
				<tr>
					<th>Nome</th>
					<th>Lotação</th>
					<th>IES</th>
					<th>Nº Processo</th>
					<th>Data Início</th>
					<th>Data Renovação</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aRhEstagiario as $oRhEstagiario){
	    $dataAtual = date_create(date('Y-m-d'));
	    $dataRenovacao = date_create($oRhEstagiario->dt_renovacao);
	    $interval = date_diff($dataAtual, $dataRenovacao);
	    $dias = $interval->days;
	    
	    if($dias < 90 && $dias > 60)
	        $alerta= "warning";
        elseif($dias < 60)
            $alerta = "danger";
        else 
            $alerta = "success";
        
?>
				<tr class="<?=$alerta?>">
					<td><?=$oRhEstagiario->oSicasPessoa->nm_pessoa?></td>
					<td><?=$oRhEstagiario->oSicasLotacao->sigla?></td>
					<td><?=$oRhEstagiario->oRhIes->sigla?></td>
					<td><?=$oRhEstagiario->num_processo?></td>
					<td><?=Util::formataDataBancoForm($oRhEstagiario->dt_inicio)?></td>
					<td><?=Util::formataDataBancoForm($oRhEstagiario->dt_renovacao)?> (em <?=$dias?> dias)</td>
					<td><a class="btn btn-info btn-xs" href="#" title="Detalhes RhEstagiario" onclick="verDetalhe(<?=$oRhEstagiario->cd_estagiario;?>)"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmRhEstagiario.php?cd_estagiario=<?=$oRhEstagiario->cd_estagiario;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-xs" href="javascript: void(0);" onclick="excluir('cd_estagiario','<?=$oRhEstagiario->cd_estagiario;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
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
else{
?>
				<tr>
					<td colspan="11" align="center">Não há registros cadastrados!</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		<input type="hidden" name="classe" id="classe" value="RhEstagiario" />
	</div>
	<?php require_once("includes/footer.php")?>
</body>
</html>