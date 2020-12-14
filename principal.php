<?php
require_once(dirname(__FILE__)."/classes/autoload.php");
$oController = new Controller();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<?php require_once("includes/header.php");?>
</head>
<body>
    <?php require_once("includes/modals.php");?>
	<div class="container">
        <?php
		require_once("includes/titulo.php");
		require_once("includes/menu.php");
		//Util::trace($_SESSION);
		?>
        <fieldset>
			<legend>Dados Usuário</legend>
			<div class="row">
				<div class="col-md-2">Servidor:</div>
				<div class="col-md-4"><?=$_SESSION['usuarioAtual']['nome']?></div>
			</div>
			<div class="row">
				<div class="col-md-2">Perfil:</div>
				<div class="col-md-4"><?=implode('<br />', $_SESSION['usuarioAtual']['perfil'])?></div>
			</div>			
			<div class="row">
				<div class="col-md-2">E-mail:</div>
				<div class="col-md-4"><?=$_SESSION['usuarioAtual']['email']?></div>
			</div>
			<div class="row">
				<div class="col-md-2">Último Acesso:</div>
				<div class="col-md-4"><?=$_SESSION['usuarioAtual']['ultimoLogon']?></div>
			</div>
		</fieldset>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>