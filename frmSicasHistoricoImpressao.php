<?php
require_once(dirname(__FILE__)."/classes/autoload.php");
$oController = new Controller();
$oSicasHistoricoImpressao = $oController->getSicasHistoricoImpressao ( $_REQUEST['cd_carteira'] );

// ================= Edicao do SicasHistoricoImpressao =========================
if ($_POST) {
	print ($oController->alteraSicasHistoricoImpressao ()) ? "" : $oController->msg;
	exit ();
}
$aSicasPessoa = $oController->getAllSicasPessoa ();
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
			<li><a href="admSicasHistoricoImpressao.php">SicasHistoricoImpressao</a></li>
			<li class="active">Editar <span>SicasHistoricoImpressao</span></li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg ( $oController->msg, "erro" );
?>
        <form role="form" onsubmit="return false;">

			<div class="form-group">
				<label for="cd_pessoa">SicasPessoa</label> <select name="cd_pessoa"
					id="cd_pessoa" class="form-control">
					<option value="">Selecione</option>
    <?php
				foreach ( $aSicasPessoa as $oSicasPessoa ) {
					?>
        <option value="<?=$oSicasPessoa->cd_pessoa?>"
						<?=($oSicasPessoa->cd_pessoa == $oSicasHistoricoImpressao->oSicasPessoa->cd_pessoa) ? " selected" : ""?>><?=$oSicasPessoa->nm_pessoa?></option>
    <?php
				}
				?>
    </select>
			</div>

			<label for="dt_impressao">Dt_impressao</label>
                            <?php $oController->componenteCalendario('dt_impressao', Util::formataDataHoraBancoForm($oSicasHistoricoImpressao->dt_impressao), NULL, true)?>
            <div class="form-actions">
				<button id="btnEditar" data-loading-text="loading..." type="submit"
					class="btn btn-primary">Salvar</button>
				<a class="btn btn-default" href="admSicasHistoricoImpressao.php">Voltar</a>
				<input name="cd_carteira" type="hidden" id="cd_carteira"
					value="<?=$_REQUEST['cd_carteira']?>" />
			</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>