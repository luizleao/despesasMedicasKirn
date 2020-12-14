<?php
require_once("classes/autoload.php");
$oController = new ControllerRhies();

$oRhIes = ($_REQUEST['cd_ies'] == "") ? NULL : $oController->get($_REQUEST['cd_ies']);
$label   = (is_null($oRhIes)) ? "Cadastrar" : "Editar";

// ================= Edicao do RhIes ========================= 
if($_POST){
    $operacao = (is_object($oRhIes)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}
//Util::trace($oRhIes);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body ng-app="app">
    <?php require_once("includes/modals.php");?>
    <div class="container" ng-controller="RhIesController">
        <?php 
        require_once("includes/titulo.php"); 
        require_once("includes/menu.php"); 
        ?>
        <ol class="breadcrumb">
            <li><a href="principal.php">Home</a></li>
            <li><a href="admRhIes.php">IES</a></li>
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
                    	<label for="sigla">Sigla</label>
                    	<input type="text" class="form-control" id="sigla" name="sigla" value="<?=$oRhIes->sigla?>" />
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                    	<label for="descricao">Descrição</label>
                    	<input type="text" class="form-control" id="descricao" name="descricao" value="<?=$oRhIes->descricao?>" />
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                    	<label for="endereco">Enderço</label>
                    	<input type="text" class="form-control" id="endereco" name="endereco" value="<?=$oRhIes->endereco?>" />
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                    	<label for="telefone1">Telefone 1</label>
                    	<input type="text" class="form-control telefone" id="telefone1" name="telefone1" value="<?=$oRhIes->telefone1?>" />
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                    	<label for="telefone2">Telefone 2</label>
                    	<input type="text" class="form-control telefone" id="telefone2" name="telefone2" value="<?=$oRhIes->telefone2?>" />
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                    	<label for="telefone3">Telefone 3</label>
                    	<input type="text" class="form-control telefone" id="telefone3" name="telefone3" value="<?=$oRhIes->telefone3?>" />
                    </div>
				</div>
				<div class="col-md-4">
                    <div class="form-group">
                    	<label for="email">E-mail</label>
                    	<input type="text" class="form-control" id="email" name="email" value="<?=$oRhIes->email?>" />
                    </div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="status">Status</label> 
						<select class="form-control" id="status" name="status">
							<option value="" disabled="disabled">Selecione</option>
							<option value="1" <?=($oRhIes->status == 1) ? "selected" : ""?>">ATIVO</option>
							<option value="0" <?=($oRhIes->status == 0) ? "selected" : ""?>">INATIVO</option>
						</select>
					</div>
				</div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admRhIes.php">Voltar</a>
                        <input name="cd_ies" type="hidden" id="cd_ies" value="<?=$_REQUEST['cd_ies']?>" />
                        <input type="hidden" name="classe" id="classe" value="RhIes" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
</body>
</html>