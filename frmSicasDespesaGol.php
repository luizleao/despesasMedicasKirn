<?php
require_once(dirname(__FILE__)."/classes/autoload.php");
$oController = new Controller();
$oSicasDespesaGol = $oController->getSicasDespesaGol ( $_REQUEST['cd_despesa_gol'] );

// ================= Edicao do SicasDespesaGol =========================
if ($_POST) {
	print ($oController->alteraSicasDespesaGol ()) ? "" : $oController->msg;
	exit ();
}
$aSicasPessoa = $oController->getAllSicasPessoa ();
$aSicasCredenciado = $oController->getAllSicasCredenciado ();
$aSicasTipoDespesa = $oController->getAllSicasTipoDespesa ();
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
			<li><a href="admSicasDespesaGol.php">SicasDespesaGol</a></li>
			<li class="active">Editar <span>SicasDespesaGol</span></li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg ( $oController->msg, "erro" );
?>
        <form role="form" onsubmit="return false;">

			<div class="form-group">
				<label for="ano_mes">Ano_mes</label> <input type="text"
					class="form-control" id="ano_mes" name="ano_mes"
					value="<?=$oSicasDespesaGol->ano_mes?>" />
			</div>
			<div class="form-group">
				<label for="matricula">Matricula</label> <input type="text"
					class="form-control" id="matricula" name="matricula"
					value="<?=$oSicasDespesaGol->matricula?>" />
			</div>
			<div class="form-group">
				<label for="cd_pessoa">SicasPessoa</label> <select name="cd_pessoa"
					id="cd_pessoa" class="form-control">
					<option value="">Selecione</option>
    <?php
				foreach ( $aSicasPessoa as $oSicasPessoa ) {
					?>
        <option value="<?=$oSicasPessoa->cd_pessoa?>"
						<?=($oSicasPessoa->cd_pessoa == $oSicasDespesaGol->oSicasPessoa->cd_pessoa) ? " selected" : ""?>><?=$oSicasPessoa->nm_pessoa?></option>
    <?php
				}
				?>
    </select>
			</div>
			<div class="form-group">
				<label for="cd_credenciado">SicasCredenciado</label> <select
					name="cd_credenciado" id="cd_credenciado" class="form-control">
					<option value="">Selecione</option>
    <?php
				foreach ( $aSicasCredenciado as $oSicasCredenciado ) {
					?>
        <option value="<?=$oSicasCredenciado->cd_credenciado?>"
						<?=($oSicasCredenciado->cd_credenciado == $oSicasDespesaGol->oSicasCredenciado->cd_credenciado) ? " selected" : ""?>><?=$oSicasCredenciado->nm_credenciado?></option>
    <?php
				}
				?>
    </select>
			</div>
			<div class="form-group">
				<label for="vl_despesa">vl_despesa</label>
				<div class="input-prepend">
					<span class="add-on">R$</span> <input type="text"
						class="form-control money" name="vl_despesa" id="vl_despesa"
						value="<?=$oSicasDespesaGol->vl_despesa?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="vl_d_despesa">vl_d_despesa</label>
				<div class="input-prepend">
					<span class="add-on">R$</span> <input type="text"
						class="form-control money" name="vl_d_despesa" id="vl_d_despesa"
						value="<?=$oSicasDespesaGol->vl_d_despesa?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="porcentagem_desconto">porcentagem_desconto</label>
				<div class="input-prepend">
					<span class="add-on">R$</span> <input type="text"
						class="form-control money" name="porcentagem_desconto"
						id="porcentagem_desconto"
						value="<?=$oSicasDespesaGol->porcentagem_desconto?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="remuneracao">Remuneracao</label> <input type="text"
					class="form-control" id="remuneracao" name="remuneracao"
					value="<?=$oSicasDespesaGol->remuneracao?>" />
			</div>
			<div class="form-group">
				<label for="cd_tipo_despesa">SicasTipoDespesa</label> <select
					name="cd_tipo_despesa" id="cd_tipo_despesa" class="form-control">
					<option value="">Selecione</option>
    <?php
				foreach ( $aSicasTipoDespesa as $oSicasTipoDespesa ) {
					?>
        <option value="<?=$oSicasTipoDespesa->cd_tipo_despesa?>"
						<?=($oSicasTipoDespesa->cd_tipo_despesa == $oSicasDespesaGol->oSicasTipoDespesa->cd_tipo_despesa) ? " selected" : ""?>><?=$oSicasTipoDespesa->cd_tipo_despesa?></option>
    <?php
				}
				?>
    </select>
			</div>
			<div class="form-group">
				<label for="flg_desconta">Flg_desconta</label> <input type="text"
					class="form-control" id="flg_desconta" name="flg_desconta"
					value="<?=$oSicasDespesaGol->flg_desconta?>" />
			</div>
			<div class="form-group">
				<label for="flg_fis_jur">Flg_fis_jur</label> <input type="text"
					class="form-control" id="flg_fis_jur" name="flg_fis_jur"
					value="<?=$oSicasDespesaGol->flg_fis_jur?>" />
			</div>
			<div class="form-actions">
				<button id="btnEditar" data-loading-text="loading..." type="submit"
					class="btn btn-primary">Salvar</button>
				<a class="btn btn-default" href="admSicasDespesaGol.php">Voltar</a>
				<input name="cd_despesa_gol" type="hidden" id="cd_despesa_gol"
					value="<?=$_REQUEST['cd_despesa_gol']?>" />
			</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>