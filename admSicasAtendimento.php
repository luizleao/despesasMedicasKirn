<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasAtendimento();
$aSicasAtendimento = $oController->getAll();
// print "<pre>";print_r($aSicasAtendimento);print "</pre>";

if ($_REQUEST['acao'] == 'excluir') {
	print ($oController->excluir($_REQUEST['cd_atendimento'])) ? "" : $oController->msg;
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
			<li class="active">Administrar Atendimento</li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg ( $oController->msg, "erro" );
?>
        <table class="table table-striped">
<?php
if ($aSicasAtendimento) {
	?>
	
            <thead>
				<tr>
					<th>Nº </th>
					<th>Beneficiário</th>
					<th>Data Início</th>
					<th>Data Fim</th>
					<th>Médico</th>
					<th>Status</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach ( $aSicasAtendimento as $oSicasAtendimento ) {
		?>
                <tr>
					<td><?=$oSicasAtendimento->cd_atendimento?></td>
					<td><?=$oSicasAtendimento->oSicasPessoa->nm_pessoa?></td>
					<td><?=Util::formataDataHoraBancoForm($oSicasAtendimento->dt_ini_atendimento)?></td>
					<td><?=Util::formataDataHoraBancoForm($oSicasAtendimento->dt_fim_atendimento)?></td>
					<td><?=$oSicasAtendimento->oSicasMedico->login?></td>
					<td><?=$oSicasAtendimento->status?></td>
					<td><a class="btn btn-success btn-sm" href="frmSicasAtendimento.php?cd_atendimento=<?=$oSicasAtendimento->cd_atendimento;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="excluir('cd_atendimento','<?=$oSicasAtendimento->cd_atendimento;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
	?>
            </tbody>
<?php
} else {
	?>
            <tr>
				<td colspan="8" align="center">Não há registros cadastrados!</td>
			</tr>
<?php
}
?>
            <tr>
				<td colspan="8"><a href="frmSicasAtendimento.php" class="btn btn-primary btn-sm" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a></td>
			</tr>
		</table>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>