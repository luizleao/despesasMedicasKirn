<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasCredenciado();

$oSicasCredenciado = ($_REQUEST['cd_credenciado'] == "") ? NULL : $oController->get($_REQUEST['cd_credenciado']);
$label   = (is_null($oSicasCredenciado)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasCredenciado)) ? ($oController->alterar()) : ($oController->cadastrar());
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
            <li><a href="admSicasCredenciado.php">Credenciado</a></li>
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
                		<label for="tipo">Tipo</label>
                		<select name="tipo" id="tipo" class="form-control">
							<option value="F"<?=($oSicasCredenciado->tipo == 'F') ? ' selected="selected"' : ''?>>Física</option>
							<option value="J"<?=($oSicasCredenciado->tipo == 'J') ? ' selected="selected"' : ''?>>Jurídica</option>
						</select>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cpf">CPF</label>
                		<input type="text" class="form-control cpf" id="cpf" name="cpf" value="<?=$oSicasCredenciado->cpf?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cgc">CNPJ</label>
                		<input type="text" class="form-control cnpj" id="cgc" name="cgc" value="<?=$oSicasCredenciado->cgc?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="nm_credenciado">Nome</label>
                		<input type="text" class="form-control" id="nm_credenciado" name="nm_credenciado" value="<?=$oSicasCredenciado->nm_credenciado?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="dt_nascimento">Data de Nascimento</label>
                	    <?php $oController->componenteCalendario('dt_nascimento', Util::formataDataBancoForm($oSicasCredenciado->dt_nascimento), NULL, false)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="hora_atendimento">Hora de Atendimento</label>
                	    <input type="text" name="hora_atendimento" class="form-control" id="hora_atendimento" value="<?=$oSicasCredenciado->hora_atendimento?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                	    <label for="nm_servicos">Serviços</label>
                	    <textarea name="nm_servicos" class="form-control" id="nm_servicos" cols="80" rows="10"><?=$oSicasCredenciado->nm_servicos?></textarea>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="profissional_liberal">Profissional Liberal</label>
                		<input type="text" class="form-control" id="profissional_liberal" name="profissional_liberal" value="<?=$oSicasCredenciado->profissional_liberal?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="endereco">Endereço</label>
                		<input type="text" class="form-control" id="endereco" name="endereco" value="<?=$oSicasCredenciado->endereco?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="complemento">Complemento</label>
                		<input type="text" class="form-control" id="complemento" name="complemento" value="<?=$oSicasCredenciado->complemento?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="bairro">Bairro</label>
                		<input type="text" class="form-control" id="bairro" name="bairro" value="<?=$oSicasCredenciado->bairro?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cidade">Cidade</label>
                		<input type="text" class="form-control" id="cidade" name="cidade" value="<?=$oSicasCredenciado->cidade?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="uf">UF</label>
                		<?php $oController->componenteListaUf("uf", $oSicasCredenciado->uf)?>
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cep">CEP</label>
                		<input type="text" class="form-control cep" id="cep" name="cep" value="<?=$oSicasCredenciado->cep?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="telefone1">Telefone 1</label>
                		<input type="text" class="form-control telefone" id="telefone1" name="telefone1" value="<?=$oSicasCredenciado->telefone1?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="telefone2">Telefone 2</label>
                		<input type="text" class="form-control telefone" id="telefone2" name="telefone2" value="<?=$oSicasCredenciado->telefone2?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="fax1">Fax 1</label>
                		<input type="text" class="form-control telefone" id="fax1" name="fax1" value="<?=$oSicasCredenciado->fax1?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="ramal1">Ramal 1</label>
                		<input type="text" class="form-control" id="ramal1" name="ramal1" value="<?=$oSicasCredenciado->ramal1?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="cd_pis_pasep">PIS/PASEP</label>
                		<input type="text" class="form-control" id="cd_pis_pasep" name="cd_pis_pasep" value="<?=$oSicasCredenciado->cd_pis_pasep?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="guia_prev_social">Guia_prev_social</label>
                		<input type="text" class="form-control" id="guia_prev_social" name="guia_prev_social" value="<?=$oSicasCredenciado->guia_prev_social?>" />
                	</div>
                </div>
                <div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<select name="status" id="status" class="form-control">
							<option value="1"<?=($oSicasCredenciado->status == '1') ? ' selected="selected"' : ''?>>Ativo</option>
							<option value="0"<?=($oSicasCredenciado->status == '0') ? ' selected="selected"' : ''?>>Inativo</option>
						</select>
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-actions">
                        <button id="btn<?=$label?>" data-loading-text="Carregando..." type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-default" href="admSicasCredenciado.php">Voltar</a>
                        <input name="cd_credenciado" type="hidden" id="cd_credenciado" value="<?=$_REQUEST['cd_credenciado']?>" />
                        <input type="hidden" name="classe" id="classe" value="SicasCredenciado" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
</body>
</html>