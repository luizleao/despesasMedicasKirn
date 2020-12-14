<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasProcedimento();

$oSicasProcedimento = ($_REQUEST['cd_procedimento'] == "") ? NULL : $oController->get($_REQUEST['cd_procedimento']);
$label   = (is_null($oSicasProcedimento)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasProcedimento)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}
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
            <li><a href="admSicasProcedimento.php">Procedimento</a></li>
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
                		<label for="num_procedimento">Nº Procedimento</label>
                		<input type="text" class="form-control" id="num_procedimento" name="num_procedimento" value="<?=$oSicasProcedimento->num_procedimento?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="nm_procedimento">Procedimento</label>
                		<input type="text" class="form-control" id="nm_procedimento" name="nm_procedimento" value="<?=$oSicasProcedimento->nm_procedimento?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="num_custo_operacional">Custo Operacional</label>
                		<div class="input-group">
                	        <span class="input-group-addon">R$</span>
                			<input type="text" class="form-control money" id="num_custo_operacional" name="num_custo_operacional" value="<?=$oSicasProcedimento->num_custo_operacional?>" />
                		</div>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="num_honorario">Honorário</label>
                		<div class="input-group">
                	        <span class="input-group-addon">R$</span>
            				<input type="text" class="form-control money" id="num_honorario" name="num_honorario" value="<?=$oSicasProcedimento->num_honorario?>" />
            			</div>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="num_med_filme">Med Filme</label>
                		<input type="number" class="form-control" id="num_med_filme" name="num_med_filme" value="<?=$oSicasProcedimento->num_med_filme?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="num_auxiliares">Auxiliares</label>
                		<input type="number" class="form-control" id="num_auxiliares" name="num_auxiliares" value="<?=$oSicasProcedimento->num_auxiliares?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="num_port_anest">Porta Anestesia</label>
                		<input type="number" class="form-control" id="num_port_anest" name="num_port_anest" value="<?=$oSicasProcedimento->num_port_anest?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="sigla">Sigla</label>
                		<input type="text" class="form-control" id="sigla" name="sigla" value="<?=$oSicasProcedimento->sigla?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="red_registro">Registro</label>
                		<input type="text" class="form-control" id="red_registro" name="red_registro" value="<?=$oSicasProcedimento->red_registro?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label><br />
                		<label class="radio-inline">
                          <input type="radio" name="status" id="status_ativo" value="1" <?=($oSicasProcedimento->status == 1) ? "checked" : ""?> /> Ativo
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="status" id="status_inativo" value="0" <?=($oSicasProcedimento->status == 0) ? "checked" : ""?> /> Inativo
                        </label>
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasProcedimento.php">Voltar</a>
                        <input name="cd_procedimento" type="hidden" id="cd_procedimento" value="<?=$_REQUEST['cd_procedimento']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasProcedimento" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>