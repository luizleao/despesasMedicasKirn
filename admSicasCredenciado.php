<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasCredenciado();
$numPags = $oController->numeroPaginasConsulta($oController->totalColecao());

if($_REQUEST['acao'] == 'excluir'){
    print ($oController->excluir($_REQUEST['cd_credenciado'])) ? "" : $oController->msg; exit;
}
if(!isset($_REQUEST['pag'])) $_REQUEST['pag'] = 1;

$aSicasCredenciado = ($_POST) ? $oController->consultar($_REQUEST['txtConsulta']) : $oController->getAll([], ["sicas_credenciado.cd_credenciado"], $_REQUEST['pag']);
//Util::trace($aSicasCredenciado);
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
			<li class="active">Administrar Credenciados</li>
		</ol>
		<form action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group h2">
					<input name="txtConsulta" class="form-control input-sm" id="txtConsulta" type="text" placeholder="Pesquisar Credenciado" value="<?=$_REQUEST['txtConsulta']?>" autofocus />
					<span class="input-group-btn">
						<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
						<a href="frmSicasCredenciado.php" class="btn btn-success btn-sm" title="Cadastrar SicasCredenciado"><i class="glyphicon glyphicon-plus"></i></a>
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
if($aSicasCredenciado){
?>	
			<thead>
				<tr>
					<th>Credenciado</th>
					<th>Serviços</th>
					<th>Profissional Liberal</th>
					<th>Cidade</th>
					<th>UF</th>
					<th>CEP</th>
					<th>Telefone 1</th>
					<th>Telefone 2</th>
					<th>Fax 1</th>
					<th>Ramal 1</th>
					<th>Tipo</th>
					<th>CPF</th>
					<th>CNPJ</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($aSicasCredenciado as $oSicasCredenciado){
?>
				<tr>
					<td><?=$oSicasCredenciado->nm_credenciado?></td>
					<td><?=$oSicasCredenciado->nm_servicos?></td>
					<td><?=$oSicasCredenciado->profissional_liberal?></td>
					<td><?=$oSicasCredenciado->cidade?></td>
					<td><?=$oSicasCredenciado->uf?></td>
					<td><?=$oSicasCredenciado->cep?></td>
					<td><?=Util::formataTelefone($oSicasCredenciado->telefone1)?></td>
					<td><?=Util::formataTelefone($oSicasCredenciado->telefone2)?></td>
					<td><?=Util::formataTelefone($oSicasCredenciado->fax1)?></td>
					<td><?=$oSicasCredenciado->ramal1?></td>
					<td><?=Util::getTipoPessoa($oSicasCredenciado->tipo)?></td>
					<td><?=Util::formataCPF($oSicasCredenciado->cpf)?></td>
					<td><?=Util::formataCNPJ($oSicasCredenciado->cgc)?></td>
					<td><?=Util::getStatus($oSicasCredenciado->status)?></td>
					<td><a id="btnDetalhes" data-id="<?=$oSicasCredenciado->cd_credenciado;?>" class="btn btn-info btn-xs" href="#" title="Detalhes SicasCredenciado"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a class="btn btn-success btn-xs" href="frmSicasCredenciado.php?cd_credenciado=<?=$oSicasCredenciado->cd_credenciado;?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></td>
					<td>
						<a id="btnExcluir" data-id="cd_credenciado" data-id-valor="<?=$oSicasCredenciado->cd_credenciado;?>" class="btn btn-danger btn-xs" href="javascript: void(0);" title="Excluir">
							<i class="glyphicon glyphicon-trash"></i>
						</a>
					</td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="25">
						<?php $oController->componentePaginacao($numPags);?>
					</td>
				</tr>
<?php
}
?>
			</tbody>
		</table>
		
<?php
if(!$aSicasCredenciado){
	$oController->componenteMsg("Não há registros cadastrados", "info");
}
?>		
		<input type="hidden" name="classe" id="classe" value="SicasCredenciado" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>