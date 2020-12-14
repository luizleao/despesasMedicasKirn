<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasGrauParentesco();
$aSicasGrauParentesco = $oController->getAll();
// print "<pre>";print_r($aSicasGrauParentesco);print "</pre>";

if ($_REQUEST['acao'] == 'excluir') {
	print ($oController->excluir( $_REQUEST['cd_grau_parentesco'] )) ? "" : $oController->msg;
	exit ();
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
			<li class="active">Administrar Grau de Parentesco</li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
        <table class="table table-striped table-condensed">
<?php
if ($aSicasGrauParentesco) {
?>
	
            <thead>
				<tr>
					<th>Resumo</th>
					<th>Descrição</th>
					<th>Ativo?</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach ($aSicasGrauParentesco as $oSicasGrauParentesco){
?>
                <tr>
					<td><?=$oSicasGrauParentesco->nm_grau_parentesco?></td>
					<td><?=$oSicasGrauParentesco->desc_grauparentesco?></td>
					<td><?=($oSicasGrauParentesco->status == '1') ? "Sim" : "Não" ?></td>
					<td><a class="btn btn-success btn-sm" href="frmSicasGrauParentesco.php?cd_grau_parentesco=<?=$oSicasGrauParentesco->cd_grau_parentesco;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="excluir('cd_grau_parentesco','<?=$oSicasGrauParentesco->cd_grau_parentesco;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
?>
            </tbody>
<?php
} else {
?>
            <tr>
				<td colspan="6" align="center">Não há registros
					cadastrados!</td>
			</tr>
<?php
}
?>
            <tr>
				<td colspan="6">
					<a href="frmSicasGrauParentesco.php" class="btn btn-primary btn-sm" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>
					<input type="hidden" name="classe" id="classe" value="SicasGrauParentesco" />
				</td>
			</tr>
		</table>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>