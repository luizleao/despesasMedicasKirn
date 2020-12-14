<?php
require_once("classes/autoload.php");

$oController = new ControllerRhRamal();
$aRhRamal = $oController->getAll();

//Util::trace($aRhRamal);

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_ramal'])) ? "" : $oController->msg; exit;
}
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
			<li class="active">Administrar Ramais</li>
		</ol>
<?php 
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
		<table class="table table-striped table-condensed">
<?php
if($aRhRamal){
?>	
			<thead>
				<tr>
					<th>Ramal</th>
					<th>Descrição</th>
					<th>Lotação</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aRhRamal as $oRhRamal){
		//Util::trace($aServidorRamal);
?>
				<tr>
					<td><?=$oRhRamal->ramal?></td>
					<td><?=$oRhRamal->descricao?></td>
					<td><?=$oRhRamal->oSicasLotacao->sigla?> - <?=$oRhRamal->oSicasLotacao->nm_lotacao?></td>
					<td><a class="btn btn-success btn-sm" href="frmRhRamal.php?cd_ramal=<?=$oRhRamal->cd_ramal;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="excluir('cd_ramal','<?=$oRhRamal->cd_ramal;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
			</tbody>
<?php
}
else{
?>
			<tr>
				<td colspan="5" align="center">Não há registros cadastrados!</td>
			</tr>
<?php
}
?>
			<tr>
				<td colspan="5"><a href="frmRhRamal.php" class="btn btn-primary btn-sm" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a></td>
			</tr>
		</table>
		<input type="hidden" name="classe" id="classe" value="RhRamal" />
	</div>
	<?php require_once("includes/footer.php")?>
</body>
</html>