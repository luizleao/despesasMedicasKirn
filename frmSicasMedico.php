<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasMedico();

$oSicasMedico = ($_REQUEST['cd_medico'] == "") ? NULL        : $oController->get($_REQUEST['cd_medico']);
$label   = (is_null($oSicasMedico)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasMedico)) ? $oController->alterar() : $oController->cadastrar();
    print ($operacao) ? "" : $oController->msg; exit;
}
$aSicasServidor = (new ControllerSicasServidor())->getAll([], ['sicas_pessoa.nm_pessoa']);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <div class="container">
        <?php 
        require_once("includes/titulo.php"); 
        require_once("includes/menu.php"); 
        ?>
        <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li><a href="admSicasMedico.php">Médico</a></li>
            <li class="active"><?=$label?></li>
        </ol>
<?php 
if($oController->msg != "")
    $oController->componenteMsg($oController->msg, "erro");
?>
        <form role="form" onsubmit="return false;">
            <div class="row">
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="login">Login</label>
                		<input type="text" class="form-control" id="login" name="login" value="<?=$oSicasMedico->login?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="crm">CRM</label>
                		<input type="text" class="form-control" id="crm" name="crm" value="<?=$oSicasMedico->crm?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_servidor">Servidor</label>
                		<select name="cd_servidor" id="cd_servidor" class="form-control">
                			<option value="">Selecione</option>
                		<?php
                		foreach($aSicasServidor as $oSicasServidor){
                		?>
                			<option value="<?=$oSicasServidor->cd_servidor?>"<?=($oSicasServidor->cd_servidor == $oSicasMedico->oSicasServidor->cd_servidor) ? " selected" : ""?>><?=$oSicasServidor->oSicasPessoa->nm_pessoa?></option>
                		<?php
                		}
                		?>
                		</select>
                	</div>
                </div>
                <div class="col-md-4">
    				<div class="form-group">
    					<label for="nm_lotacao">Status</label> 
    					<select id="status" name="status" class="form-control">
    						<option value="1"<?=($oSicasMedico->status==1) ? " selected" : ""?>>ATIVO</option>
    						<option value="0"<?=($oSicasMedico->status==0) ? " selected" : ""?>>INATIVO</option>
    					</select>
    				</div>
    			</div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasMedico.php">Voltar</a>
                        <input name="cd_medico" type="hidden" id="cd_medico" value="<?=$_REQUEST['cd_medico']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasMedico" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>