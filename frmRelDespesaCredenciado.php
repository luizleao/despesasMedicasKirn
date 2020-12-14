<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasDespesa();

$oSicasDespesa = ($_REQUEST['cd_despesa'] == "") ? NULL : $oController->get($_REQUEST['cd_despesa']);
$label   = (is_null($oSicasDespesa)) ? "Cadastrar" : "Editar";

$oControllerSicasCredenciado = new ControllerSicasCredenciado();
$aSicasCredenciado = $oControllerSicasCredenciado->getAll([], ['nm_credenciado asc']);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
    <script type="text/javascript" src="js/frmSicasDespesa.js"></script>
</head>
<body>
    <div class="container">
        <?php 
        require_once("includes/titulo.php"); 
        require_once("includes/menu.php"); 
        ?>
        <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li><a href="#">Relatório</a></li>
            <li class="active">Despesa Credenciado</li>
            
        </ol>
<?php 
if($oController->msg != "")
    $oController->componenteMsg($oController->msg, "erro");
?>
        <form action="relDespesaCredenciado.php" method="post" target="_blank">
        	<div class="row">
				<div class="col-md-6">
					<div class="form-group">
                		<label for="cd_credenciado">Credenciado</label>
                		<select name="cd_credenciado" id="cd_credenciado" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasCredenciado as $oSicasCredenciado){
                		?>
                			<option value="<?=$oSicasCredenciado->cd_credenciado?>"><?=$oSicasCredenciado->nm_credenciado?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
                		<label for="btnBuscar"> </label>
						<button id="btnBuscar" type="submit" class="btn btn-primary form-control">Gerar</button>
					</div>
				</div>
			</div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>