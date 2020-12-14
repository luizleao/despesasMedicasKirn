<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasDespesa();

$oSicasDespesa = ($_REQUEST['cd_despesa'] == "") ? NULL : $oController->get($_REQUEST['cd_despesa']);
$label   = (is_null($oSicasDespesa)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasDespesa)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerSicasProcedimentoAutorizado = new ControllerSicasProcedimentoAutorizado();$aSicasProcedimentoAutorizado = $oControllerSicasProcedimentoAutorizado->getAll([], []);
$oControllerSicasSalario = new ControllerSicasSalario();$aSicasSalario = $oControllerSicasSalario->getAll([], []);

$oControllerSicasServidor = new ControllerSicasServidor();
$aSicasServidor = $oControllerSicasServidor->getAll(["sicas_servidor.status = 1"], ["sicas_pessoa.nm_pessoa asc"])
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
            <li><a href="admSicasDespesa.php">Despesa</a></li>
            <li class="active"><?=$label?></li>
        </ol>
<?php 
if($oController->msg != "")
    $oController->componenteMsg($oController->msg, "erro");
?>
        <form onsubmit="return false;">
        	<div class="row">
				<div class="col-md-6">
					<div class="form-group">
                		<label for="cd_servidor">Servidor</label>
                		<select name="cd_servidor" id="cd_servidor" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasServidor as $oSicasServidor){
                		?>
                			<option value="<?=$oSicasServidor->cd_servidor?>"<?=($oSicasServidor->cd_servidor == $oSicasDespesa->oSicasServidor->cd_servidor) ? " selected" : ""?>><?=$oSicasServidor->oSicasPessoa->nm_pessoa?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
                		<label for="periodo">Mês/Ano</label>
                		<?php $oController->componenteCalendario("mesAno", NULL, NULL, false, '%m/%Y')?>
                	</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
                		<label for="btnBuscar"> </label>
						<button id="btnBuscar" type="button" class="btn btn-primary form-control"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</div>
			</div>
			<?php require 'componentes/compProcedimentosDespesa.php';?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasDespesa.php">Voltar</a>
                        <input name="cd_despesa" type="hidden" id="cd_despesa" value="<?=$_REQUEST['cd_despesa']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasDespesa" />
                        <input type="hidden" name="status" id="status" value="1" />
                        <input type="hidden" name="dt_cadastro" id="dt_cadastro" value="<?=date('Y-m-d')?>" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
    
</body>
</html>