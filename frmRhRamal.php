<?php
require_once("classes/autoload.php");
$oController = new ControllerRhRamal();

$oRhRamal = ($_REQUEST['cd_ramal'] == "") ? NULL : $oController->get($_REQUEST['cd_ramal']);
$label   = (is_null($oRhRamal)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oRhRamal)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

//Util::trace($oRhRamal);
$oControllerLotacao = new ControllerSicasLotacao();
$aSicasLotacao = $oControllerLotacao->getAll([], ["sicas_lotacao.sigla"]);
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
            <li><a href="admRhRamal.php">Ramais</a></li>
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
						<label for="cd_lotacao">Lotação</label>
						<select name="cd_lotacao" id="cd_lotacao" class="form-control">
							<option value="">Selecione</option>
						<?php
						foreach($aSicasLotacao as $oSicasLotacao){
						?>
							<option value="<?=$oSicasLotacao->cd_lotacao?>"<?=($oSicasLotacao->cd_lotacao == $oRhRamal->oSicasLotacao->cd_lotacao) ? " selected" : ""?>><?=$oSicasLotacao->sigla?> - <?=$oSicasLotacao->nm_lotacao?></option>
						<?php
						}
						?>
						</select>
					</div>
					<div class="form-group">
						<label for="ramal">Ramal</label>
						<input type="text" class="form-control ramal" id="ramal" name="ramal" value="<?=$oRhRamal->ramal?>" />
					</div>
					<div class="form-group">
						<label for="descricao">Descrição</label>
						<input type="text" class="form-control" id="descricao" name="descricao" value="<?=$oRhRamal->descricao?>" />
					</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admRhRamal.php">Voltar</a>
                        <input name="cd_ramal" type="hidden" id="cd_ramal" value="<?=$_REQUEST['cd_ramal']?>" />
                        <input type="hidden" name="classe" id="classe" value="RhRamal" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
</body>
</html>