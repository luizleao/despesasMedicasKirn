<?php
require_once("classes/autoload.php");
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
			<li class="active">Relatório Desconto Mensal dos Servidores - Resumo</li>
		</ol>
		<form action="resRelDescontoMensalServidorResumo.php" method="post" target="_blank">
			<div class="row">
				<div class="col-md-2">
					<div class="form-group">
    					<input class="form-control input-sm" type="month" name="mesAno" id="mesAno" />
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
					<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>