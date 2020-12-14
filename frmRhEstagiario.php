<?php
require_once("classes/autoload.php");
$oController = new ControllerRhEstagiario();

$oRhEstagiario = ($_REQUEST['cd_estagiario'] == "") ? NULL : $oController->get($_REQUEST['cd_estagiario']);
$label   = (is_null($oRhEstagiario)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oRhEstagiario)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerPessoa = new ControllerSicasPessoa();
$aSicasPessoa = $oControllerPessoa->getAll(["sicas_pessoa.cd_categoria = 71","sicas_pessoa.status = 1"],
                                           ["sicas_pessoa.nm_pessoa"]);


$oControllerLotacao = new ControllerSicasLotacao();
$aSicasLotacao = $oControllerLotacao->getAll(["sicas_lotacao.status = 1"],
                                                ["sicas_lotacao.sigla,  sicas_lotacao.nm_lotacao"]);
$oControllerIes = new ControllerRhIes();
$aRhIes = $oControllerIes->getAll([],["rh_ies.descricao"]);
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
        ?>
        <ol class="breadcrumb">
            <li><a href="principal.php">Home</a></li>
            <li><a href="admRhEstagiario.php">Estagiário</a></li>
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
                    	<label for="cd_pessoa">Pessoa</label>
                    	<select name="cd_pessoa" id="cd_pessoa" class="form-control">
                    		<option value="">Selecione</option>
                    	<?php
                    	foreach($aSicasPessoa as $oSicasPessoa){
                    	?>
                    		<option value="<?=$oSicasPessoa->cd_pessoa?>"<?=($oSicasPessoa->cd_pessoa == $oRhEstagiario->oSicasPessoa->cd_pessoa) ? " selected" : ""?>><?=$oSicasPessoa->nm_pessoa?></option>
                    	<?php
                    	}
                    	?>
                    	</select>
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                    	<label for="cd_lotacao">Lotação</label>
                    	<select name="cd_lotacao" id="cd_lotacao" class="form-control">
                    		<option value="">Selecione</option>
                    	<?php
                    	foreach($aSicasLotacao as $oSicasLotacao){
                    	?>
                    		<option value="<?=$oSicasLotacao->cd_lotacao?>"<?=($oSicasLotacao->cd_lotacao == $oRhEstagiario->oSicasLotacao->cd_lotacao) ? " selected" : ""?>><?=$oSicasLotacao->nm_lotacao?></option>
                    	<?php
                    	}
                    	?>
                    	</select>
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                    	<label for="cd_ies">IES</label>
                    	<select name="cd_ies" id="cd_ies" class="form-control">
                    		<option value="">Selecione</option>
                    	<?php
                    	foreach($aRhIes as $oRhIes){
                    	?>
                    		<option value="<?=$oRhIes->cd_ies?>"<?=($oRhIes->cd_ies == $oRhEstagiario->oRhIes->cd_ies) ? " selected" : ""?>><?=$oRhIes->descricao?></option>
                    	<?php
                    	}
                    	?>
                    	</select>
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                    	<label for="num_processo">Nº Processo</label>
                    	<input type="text" class="form-control" id="num_processo" name="num_processo" value="<?=$oRhEstagiario->num_processo?>" />
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                        <label for="dt_inicio">Data Início</label>
                        <?php $oController->componenteCalendario('dt_inicio', Util::formataDataBancoForm($oRhEstagiario->dt_inicio), NULL, false)?>
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                        <label for="dt_renovacao">Data Renovação</label>
                        <?php $oController->componenteCalendario('dt_renovacao', Util::formataDataBancoForm($oRhEstagiario->dt_renovacao), NULL, false)?>
                    </div>
				</div>
				<div class="col-md-4">
        			<div class="form-group">
    					<label for="status">Status</label> 
    					<select class="form-control" id="status" name="status">
    						<option value="" disabled="disabled">Selecione</option>
    						<option value="1" <?=($oRhEstagiario->status == 1) ? "selected" : ""?>">ATIVO</option>
    						<option value="0" <?=($oRhEstagiario->status == 0) ? "selected" : ""?>">INATIVO</option>
    					</select>
        			</div>
        		</div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admRhEstagiario.php">Voltar</a>
                        <input name="cd_estagiario" type="hidden" id="cd_estagiario" value="<?=$_REQUEST['cd_estagiario']?>" />
                        <input type="hidden" name="classe" id="classe" value="RhEstagiario" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
</body>
</html>