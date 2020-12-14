<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasServidor();
$aServidor = $oController->getAll(['sicas_servidor.status=1'], ['sicas_pessoa.nm_pessoa']);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<?php require_once("includes/header.php");?>
</head>
<body id="app">
	<div class="container">
		<?php require_once("includes/titulo.php");?>
		<?php require_once("includes/menu.php");?>
		<ol class="breadcrumb">
			<li><a href="home.php">Home</a></li>
			<li class="active">Relatório Desconto Mensal dos Servidores</li>
		</ol>
		<form action="resRelDescontoMensalServidor.php" method="post" target="_blank" class="form-inline">
			<div class="form-group">
				<label for="mesAno">Mês/Ano Referência: </label>
				<input class="form-control input-sm" type="month" name="mesAno" id="mesAno" />
			</div>
			<div class="form-group">
				<label for="cd_servidor">Servidor: </label>
				<select class="form-control" name="cd_servidor" id="cd_servidor">
					<option value="">TODOS</option>
<?php 
foreach ($aServidor as $oServidor){
?>
					<option value="<?=$oServidor->cd_servidor?>"><?=$oServidor->oSicasPessoa->nm_pessoa?></option>
<?php 
}
?>
				</select>
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-sm btn-block" type="submit"><span class="glyphicon glyphicon-search"></span></button>
			</div>
		</form>
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>