<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasEstadoCivil();
$aSicasEstadoCivil = $oController->getAll();
// print "<pre>";print_r($aSicasEstadoCivil);print "</pre>";

if ($_REQUEST['acao'] == 'excluir') {
	print ($oController->excluir($_REQUEST['cd_estado_civil'])) ? "" : $oController->msg;
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
			<li class="active">Administrar Estado Civil</li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
        <table class="table table-striped table-condensed">
<?php
if ($aSicasEstadoCivil) {
	?>
	
            <thead>
				<tr>
					<th>Descrição</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach ( $aSicasEstadoCivil as $oSicasEstadoCivil ) {
		?>
                <tr>
					<td><?=$oSicasEstadoCivil->nm_estado_civil?></td>
					<td><a class="btn btn-success btn-sm" href="frmSicasEstadoCivil.php?cd_estado_civil=<?=$oSicasEstadoCivil->cd_estado_civil;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a id="btnExcluir" class="btn btn-danger btn-sm" href="javascript: void(0);" data-id="<?=$oSicasEstadoCivil->cd_estado_civil;?>" onclick="excluir('cd_estado_civil','<?=$oSicasEstadoCivil->cd_estado_civil;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
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
					<a href="frmSicasEstadoCivil.php" class="btn btn-primary btn-sm" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>
					<input type="hidden" name="classe" id="classe" value="SicasEstadoCivil" />
				</td>
			</tr>
		</table>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>