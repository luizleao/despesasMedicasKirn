<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasDependente();

$oSicasDependente = ($_REQUEST['cd_dependente'] == "") ? NULL : $oController->get($_REQUEST['cd_dependente']);

//Util::trace($oSicasDependente);
$label   = (is_null($oSicasDependente)) ? "Cadastrar" : "Editar";

// ================= Edicao do SicasDependente ========================= 
if($_POST){
    $operacao = (is_object($oSicasDependente)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerGrauParentesco = new ControllerSicasGrauParentesco();
$aSicasGrauParentesco = $oControllerGrauParentesco->getAll([], ["sicas_grau_parentesco.desc_grauparentesco"]);

$oControllerEscolaridade = new ControllerSicasEscolaridade();
$aSicasEscolaridade   = $oControllerEscolaridade->getAll([], []);
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
            <li><a href="admSicasDependente.php">Dependente</a></li>
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
					    <label for="cd_servidor">Servidor</label>
<?php if($oSicasDependente->oSicasServidor->cd_servidor){?>
					    <input type="text" class="form-control" value="<?=$oSicasDependente->oSicasServidor->oSicasPessoa->nm_pessoa?>" disabled="disabled" />
					    <input type="hidden" name="cd_servidor" value="<?=$oSicasDependente->oSicasServidor->cd_servidor?>" />
<?php 
} else {
    $oControllerServidor = new ControllerSicasServidor();
    $aServidor = $oControllerServidor->getAll(["sicas_servidor.status=1"], ["sicas_pessoa.nm_pessoa"]);
?>
						<select id="cd_servidor" name="cd_servidor" class="form-control">
<?php 
    foreach($aServidor as $oServidor){
?>
							<option value="<?=$oServidor->cd_servidor?>"><?=$oServidor->oSicasPessoa->nm_pessoa?></option>
<?php 
    }
?>
						</select>
<?php 
}
?>

					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    <label for="cd_pessoa">Dependente</label>
<?php if($oSicasDependente->oSicasPessoa->cd_pessoa){?>
					    <input type="text" class="form-control" value="<?=$oSicasDependente->oSicasPessoa->nm_pessoa?>" disabled="disabled" />
					    <input type="hidden" name="cd_pessoa" id="cd_pessoa" value="<?=$oSicasDependente->oSicasPessoa->cd_pessoa?>" />
<?php 
} else {
    $oControllerPessoa = new ControllerSicasPessoa();
    $aPessoa = $oControllerPessoa->getAllDependenteEnabled();
?>
						<select id="cd_pessoa" name="cd_pessoa" class="form-control">
<?php 
     foreach($aPessoa as $oPessoa){
?>
							<option value="<?=$oPessoa->cd_pessoa?>"><?=$oPessoa->nm_pessoa?></option>
<?php 
    }
?>
						</select>
<?php 
}
?>

					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    <label for="cd_grau_parentesco">Grau Parentesco</label>
					    <select name="cd_grau_parentesco" id="cd_grau_parentesco" class="form-control">
					        <option value="">Selecione</option>
					    <?php
					    foreach($aSicasGrauParentesco as $oSicasGrauParentesco){
					    ?>
					        <option value="<?=$oSicasGrauParentesco->cd_grau_parentesco?>"<?=($oSicasGrauParentesco->cd_grau_parentesco == $oSicasDependente->oSicasGrauParentesco->cd_grau_parentesco) ? " selected" : ""?>><?=$oSicasGrauParentesco->desc_grauparentesco?></option>
					    <?php
					    }
					    ?>
					    </select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    <label for="cd_escolaridade">Escolaridade</label>
					    <select name="cd_escolaridade" id="cd_escolaridade" class="form-control">
					        <option value="">Selecione</option>
					    <?php
					    foreach($aSicasEscolaridade as $oSicasEscolaridade){
					    ?>
					        <option value="<?=$oSicasEscolaridade->cd_escolaridade?>"<?=($oSicasEscolaridade->cd_escolaridade == $oSicasDependente->oSicasEscolaridade->cd_escolaridade) ? " selected" : ""?>><?=$oSicasEscolaridade->nm_escolaridade?></option>
					    <?php
					    }
					    ?>
					    </select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    <label for="dependente_financ">Dependente Financeiro</label>
					    <select name="dependente_financ" id="dependente_financ" class="form-control">
					        <option value="1"<?=($oSicasDependente->dependente_financ =="1") ? "selected" : ""; ?>>SIM</option>
					        <option value="0"<?=($oSicasDependente->dependente_financ == "0") ? "selected" : "" ?>>NÃO</option>    
					    </select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    <label for="dependente_proas">Dependente PROAS</label>
					    <select id="dependente_proas" name="dependente_proas" class="form-control">
					        <option value="1"<?=($oSicasDependente->dependente_proas == "1") ? "selected" : "";?>>SIM</option>
					        <option value="0"<?=($oSicasDependente->dependente_proas == "0") ? "selected" : "";?>>NÃO</option>
					    </select>
					</div>
				</div>
				<div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<select name="status" id="status" class="form-control">
							<option value="1"<?=($oSicasDependente->status == '1') ? ' selected="selected"' : ''?>>Ativo</option>
							<option value="0"<?=($oSicasDependente->status == '0') ? ' selected="selected"' : ''?>>Inativo</option>
						</select>
                	</div>
                </div>
			</div>		           
            <div class="form-actions">
                <button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
                <a class="btn btn-default" href="admSicasDependente.php">Voltar</a>
                <input type="hidden" id="cd_dependente" name="cd_dependente" value="<?=$_REQUEST['cd_dependente']?>" />
                <input type="hidden" id="cd_servidor" name="cd_servidor" value="<?=$oSicasDependente->oSicasServidor->cd_servidor?>" />
                <input type="hidden" id="classe" name="classe" value="SicasDependente" />
                <input type="hidden" id="cd_seq_dependente" name="cd_seq_dependente" value="<?=$oSicasDependente->cd_seq_dependente?>" />
                <input type="hidden" id="dt_inclusao" name="dt_inclusao" value="<?=($oSicasDependente->dt_inclusao) ? $oSicasDependente->dt_inclusao : date('Y-m-d h:i:s')?>" />
                <input type="hidden" id="dt_manutencao" name="dt_manutencao" value="<?=date('Y-m-d h:i:s')?>" />
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
</body>
</html>