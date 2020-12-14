<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasEscolaridade();
$aSicasEscolaridade = $oController->getAll();
// print "<pre>";print_r($aSicasEscolaridade);print "</pre>";

if ($_REQUEST['acao'] == 'excluir') {
	print ($oController->excluir($_REQUEST['cd_escolaridade'])) ? "" : $oController->msg; exit();
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
			<li class="active">Administrar Escolaridade</li>
		</ol>
<?php
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
        <table class="table table-striped table-condensed">
<?php
if($aSicasEscolaridade){
?>
	
            <thead>
				<tr>
					<th>Descrição</th>
					<th>Ativo?</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasEscolaridade as $oSicasEscolaridade){
?>
                <tr>
					<td><?=$oSicasEscolaridade->nm_escolaridade?></td>
					<td><?=($oSicasEscolaridade->status == '1') ? "Sim" : "Não"?></td>
					<td><a class="btn btn-success btn-sm" href="frmSicasEscolaridade.php?cd_escolaridade=<?=$oSicasEscolaridade->cd_escolaridade;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="excluir('cd_escolaridade','<?=$oSicasEscolaridade->cd_escolaridade;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
            </tbody>
<?php
} else {
?>
            <tr>
				<td colspan="5" align="center">Não há registros cadastrados!</td>
			</tr>
<?php
}
?>
            <tr>
				<td colspan="5">
					<a href="frmSicasEscolaridade.php" class="btn btn-primary btn-sm" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>
					<input type="hidden" name="classe" id="classe" value="SicasEscolaridade" />
				</td>
			</tr>
		</table>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>