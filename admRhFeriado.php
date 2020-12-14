<?php
require_once("classes/autoload.php");

$oController = new ControllerRhFeriado();
$aRhFeriado = $oController->getAll([], ["rh_feriado.data_feriado"]);
//Util::trace($aRhFeriado);

if ($_REQUEST['acao'] == 'excluir') {
	print ($oController->excluir($_REQUEST['cd_feriado'])) ? "" : $oController->msg; exit ();
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
			<li class="active">Administrar Feriado</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Feriado" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmRhFeriado.php" class="btn btn-success btn-sm" title="Cadastrar"><i class="glyphicon glyphicon-plus"></i></a>
					</span>
					</div>
				</div>
			</div>
			<input type="hidden" name="classe" id="classe" value="SicasPessoaCategoria" />
		</form>
<?php
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
        <table class="table table-striped table-condensed">
<?php
if($aRhFeriado){
?>
	
            <thead>
				<tr>
					<th>Data</th>
					<th>Descrição</th>
					<th>Esfera</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aRhFeriado as $oRhFeriado){
?>
                <tr>
					<td><?=Util::formataDataBancoForm($oRhFeriado->data_feriado)?></td>
					<td><?=$oRhFeriado->descricao_feriado?></td>
					<td><?=$oRhFeriado->esfera_feriado?></td>
					<td><a class="btn btn-success btn-xs" href="frmRhFeriado.php?cd_feriado=<?=$oRhFeriado->cd_feriado;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td><a class="btn btn-danger btn-xs" href="javascript: void(0);" onclick="excluir('cd_feriado','<?=$oRhFeriado->cd_feriado;?>')" title="Excluir"><i class="glyphicon glyphicon-trash"></i></a></td>
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
		</table>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>