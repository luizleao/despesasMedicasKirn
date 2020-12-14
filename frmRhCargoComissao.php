<?php
require_once("classes/autoload.php");
$oController = new ControllerRhCargoComissao();

$oRhCargoComissao = ($_REQUEST['cd_cargo_comissao'] == "") ? NULL : $oController->get($_REQUEST['cd_cargo_comissao']);
$label   = (is_null($oRhCargoComissao)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oRhCargoComissao)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$oControllerServidor = new ControllerSicasServidor();
$aSicasServidor = $oControllerServidor->getAll(["sicas_servidor.status = 1"], ["nm_pessoa"]);

$oControllerLotacao = new ControllerSicasLotacao();
$aSicasLotacao  = $oControllerLotacao->getAll(["sicas_lotacao.status = 1"], ["sicas_lotacao.nm_lotacao"]);
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
			<li><a href="admRhCargoComissao.php">Cargo em Comissão</a></li>
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
        				<select name="cd_servidor" id="cd_servidor" class="form-control">
        					<option value="">Selecione</option>
        				<?php
        				foreach($aSicasServidor as $oSicasServidor){
        				?>
        					<option value="<?=$oSicasServidor->cd_servidor?>" <?=($oSicasServidor->cd_servidor == $oRhCargoComissao->oSicasServidor->cd_servidor) ? " selected" : ""?>><?=$oSicasServidor->oSicasPessoa->nm_pessoa?></option>
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
        					<option value="<?=$oSicasLotacao->cd_lotacao?>" <?=($oSicasLotacao->cd_lotacao == $oRhCargoComissao->oSicasLotacao->cd_lotacao) ? " selected" : ""?>><?=$oSicasLotacao->sigla?> - <?=$oSicasLotacao->nm_lotacao?></option>
        				<?php
        				}
        				?>
        				</select>
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
        				<label for="descricao">Descrição do Cargo</label> 
        				<input type="text" class="form-control" id="descricao" name="descricao" value="<?=$oRhCargoComissao->descricao?>" />
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
        				<label for="das">Cargo</label> 
						<select class="form-control" id="das" name="das">
							<option>Selecione</option>
<?php foreach(Util::getAllCargoComissao() as $cargo){?>
							<option value="<?=$cargo?>" <?=($oRhCargoComissao->das == $cargo) ? "selected" : ""?>><?=$cargo?></option>
<?php } ?>
						</select>        				
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
    					<label for="status">Status</label> 
    					<select class="form-control" id="status" name="status">
    						<option value="" disabled="disabled">Selecione</option>
    						<option value="1" <?=($oRhCargoComissao->status == 1) ? " selected" : ""?>">ATIVO</option>
    						<option value="0" <?=($oRhCargoComissao->status == 0) ? " selected" : ""?>">INATIVO</option>
    					</select>
        			</div>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-4">
    				<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
    				<a class="btn btn-default" href="admRhCargoComissao.php">Voltar</a> 
    				<input name="cd_cargo_comissao" type="hidden" id="cd_cargo_comissao" value="<?=$_REQUEST['cd_cargo_comissao']?>" />
    				<input name="classe" type="hidden" id="classe" value="RhCargoComissao" />
        		</div>
			</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>