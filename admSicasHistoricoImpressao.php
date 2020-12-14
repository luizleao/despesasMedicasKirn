<?php
require_once("classes/autoload.php");

$oController = new Controller();
$aSicasHistoricoImpressao = $oController->getAllSicasHistoricoImpressao();
// print "<pre>";print_r($aSicasHistoricoImpressao);print "</pre>";

if ($_REQUEST['acao'] == 'excluir') {
	print ($oController->excluiSicasHistoricoImpressao($_REQUEST['cd_carteira'])) ? "" : $oController->msg;
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
			<li class="active">Administrar Historico Impressao</li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg ( $oController->msg, "erro" );
?>
        <table class="table table-striped">
<?php
if ($aSicasHistoricoImpressao) {
	?>
	
            <thead>
				<tr>
					<th>Cd_carteira</th>
					<th>SicasPessoa</th>
					<th>Dt_impressao</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach ( $aSicasHistoricoImpressao as $oSicasHistoricoImpressao ) {
		?>
                <tr>
					<td><?=$oSicasHistoricoImpressao->cd_carteira?></td>
					<td><?=$oSicasHistoricoImpressao->oSicasPessoa->nm_pessoa?></td>
					<td><?=Util::formataDataHoraBancoForm($oSicasHistoricoImpressao->dt_impressao)?></td>
					<td><a class="btn btn-success btn-sm" href="frmSicasHistoricoImpressao.php?cd_carteira=<?=$oSicasHistoricoImpressao->cd_carteira;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="excluir('cd_carteira','<?=$oSicasHistoricoImpressao->cd_carteira;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
				</tr>
<?php
	}
	?>
            </tbody>
<?php
} else {
	?>
            <tr>
				<td colspan="5" align="center">Não há registros
					cadastrados!</td>
			</tr>
<?php
}
?>
            <tr>
				<td colspan="5">
					<a href="frmSicasHistoricoImpressao.php" class="btn btn-primary btn-sm" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>
				</td>
			</tr>
		</table>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>