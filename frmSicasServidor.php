<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasServidor();

$oSicasServidor = ($_REQUEST['cd_servidor'] == "") ? NULL : $oController->get($_REQUEST['cd_servidor']);
$label   = (is_null($oSicasServidor)) ? "Cadastrar" : "Editar";

//$oSicasServidor->getSicasSalarioAtual();
//Util::trace($oSicasServidor);
//Util::trace($oSicasServidor->oSicasSalario);

if($_POST){
    //Util::trace($_POST);
    $operacao = (is_object($oSicasServidor)) ? ($oController->transacaoAlterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$aRhCargo              = (new ControllerRhCargo())->getAll(["rh_cargo.status = 1"], ["rh_cargo.descricao_cargo_abrev"]);
$aSicasPessoaCategoria = (new ControllerSicasPessoaCategoria())->getAll([], ["desc_categoria_abrev"]);
$aSicasEstadoCivil     = (new ControllerSicasEstadoCivil())->getAll([], ["nm_estado_civil"]);
$aSicasLotacao         = (new ControllerSicasLotacao())->getAll(["sicas_lotacao.status=1", "sicas_lotacao.status=1"], ["sicas_lotacao.sigla", "sicas_lotacao.nm_lotacao"]);


if($_REQUEST['cd_servidor'] == '')
    $aPessoa = (new ControllerSicasPessoa())->getAll(['sicas_pessoa.status = 1', 'sicas_pessoa.cd_pessoa not in (select cd_pessoa from usersicas.sicas_servidor)'], ['sicas_pessoa.nm_pessoa']);
//Util::trace($aSicasLotacao);
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
			<li><a href="admSicasServidor.php">Servidor</a></li>
			<li class="active"><?=$label?></li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro" );
?>
        <form role="form" onsubmit="return false;">       
            <div>
                <!-- Nav tabs -->
            	<ul class="nav nav-tabs" role="tablist">
                	<li role="presentation" class="active"><a href="#dadosPessoais" aria-controls="dadosPessoais" role="tab" data-toggle="tab">Dados Pessoais</a></li>
                	<li role="presentation"><a href="#dadosServidor" aria-controls="dadosServidor" role="tab" data-toggle="tab">Dados Servidor</a></li>
            	</ul>
                <!-- Tab panes -->
            	<div class="tab-content">
                	<div role="tabpanel" class="tab-pane active" id="dadosPessoais">
                		<br />
						<div class="row">
            				<div class="col-md-8">
<?php 
if($_REQUEST['cd_servidor'] == ''){
?>
            					<div class="form-group">
            						<label for="cd_pessoa">Nome</label> 
            						<select id="cd_pessoa" name="cd_pessoa" class="form-control">
            							<option value="">Selecione</option>
<?php 
foreach($aPessoa as $oPessoa){
?>
										<option value="<?=$oPessoa->cd_pessoa?>"><?=$oPessoa->nm_pessoa?></option>
<?php 
}
?>
            						</select>
            					</div>
<?php 
} else {
?>
								<div class="form-group">
            						<label for="nm_pessoa">Nome</label> 
            						<input type="text" class="form-control" id="nm_pessoa" name="nm_pessoa" value="<?=$oSicasServidor->oSicasPessoa->nm_pessoa?>" />
            					</div>
<?php 
}
?>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="email">E-mail</label>
            						<div class="input-group">
            							<div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
            							<input type="text" class="form-control" name="email" id="email" value="<?=$oSicasServidor->oSicasPessoa->email?>" />
            						</div>
            					</div>
            				</div>
            			</div>
            			<div class="row">
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="cpf">CPF</label> 
            						<input type="text" class="form-control cpf" id="cpf" name="cpf" value="<?=$oSicasServidor->oSicasPessoa->cpf?>" />
            					</div>
            				</div>
            				<div class="col-md-4">
            					<label for="dt_nascimento">Data de Nascimento</label>
								<div class="input-group">
                                    <input type="date" class="form-control date" name="dt_nascimento" id="dt_nascimento" value="<?=$oSicasServidor->oSicasPessoa->dt_nascimento?>" size="18" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar" style="cursor: pointer; border-width: 0px"></span>
                                    </span>
                                </div>
            				</div>
            			</div>
            			<div class="row">
            				<div class="col-md-4">
                				<label>Sexo</label>
                				<div class="form-group">
                					<div class="radio-inline">
                						<label> 
                							<input type="radio" name="genero" id="generoM" value="M" <?=($oSicasServidor->oSicasPessoa->genero == 'M') ? "Checked" : "" ?> /> Masculino
                						</label>
                					</div>
                					<div class="radio-inline">
                						<label> 
                							<input type="radio" name="genero" id="generoF" value="F" <?=($oSicasServidor->oSicasPessoa->genero == 'F') ? "Checked" : "" ?> /> Feminino
                						</label>
                					</div>
                				</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="cd_estado_civil">Estado Civil</label> 
            						<select name="cd_estado_civil" id="cd_estado_civil" class="form-control">
            							<option value="">Selecione</option>
            						<?php
            						foreach($aSicasEstadoCivil as $oSicasEstadoCivil){
            						?>
                                        <option value="<?=$oSicasEstadoCivil->cd_estado_civil?>" <?=($oSicasEstadoCivil->cd_estado_civil == $oSicasServidor->oSicasPessoa->oSicasEstadoCivil->cd_estado_civil) ? " selected" : ""?>><?=$oSicasEstadoCivil->nm_estado_civil?></option>
            						<?php
            						}
            						?>
                                    </select>
            					</div>
            				</div>
            			</div>
            			<div class="row">
            				<div class="col-md-2">
            					<div class="form-group">
            						<label for="identidade">Identidade</label> 
            						<input type="text" class="form-control" id="identidade" name="identidade" value="<?=$oSicasServidor->oSicasPessoa->identidade?>" />
            					</div>
            				</div>
            				<div class="col-md-2">
            					<div class="form-group">
            						<label for="tipo_identidade">Tipo de Identidade</label> 
            						<select class="form-control" id="tipo_identidade" name="tipo_identidade">
            							<option value="RG"<?=($oSicasServidor->oSicasPessoa->tipo_identidade == 'RG') ? " checked" : ""?>>RG</option>
            							<option value="CNH"<?=($oSicasServidor->oSicasPessoa->tipo_identidade == 'CNH') ? " checked" : ""?>>CNH</option>
            							<option value="PASSAPORTE"<?=($oSicasServidor->oSicasPessoa->tipo_identidade == 'PASSAPORTE') ? " checked" : ""?>>PASSAPORTE</option>
            						</select>
            					</div>
            				</div>
            				<div class="col-md-2">
            					<div class="form-group">
            						<label for="nm_orgao_emissor">Orgão Emissor</label> 
            						<input type="text" class="form-control" id="nm_orgao_emissor" name="nm_orgao_emissor" value="<?=$oSicasServidor->oSicasPessoa->nm_orgao_emissor?>" maxlength="8" size="8" />
            					</div>
            				</div>
            				<div class="col-md-2">
            					<div class="form-group">
            						<label for="uf">UF Órgão Emissor</label>
            	                    <?php $oController->componenteListaUf("uf_identidade", $oSicasServidor->oSicasPessoa->uf_identidade);?>
            	                </div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="dt_emissao">Data de Emissão</label>
            						<div class="input-group">
                                        <input type="date" class="form-control date" name="dt_emissao" id="dt_emissao" value="<?=$oSicasServidor->oSicasPessoa->dt_emissao?>" size="18" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar" style="cursor: pointer; border-width: 0px"></span>
                                        </span>
                                    </div>
                                </div>
            				</div>
            			</div>
            			<div class="row">
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="endereco">Endereço</label> 
            						<input type="text" class="form-control" id="endereco" name="endereco" value="<?=$oSicasServidor->oSicasPessoa->endereco?>" />
            					</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="complemento">Complemento</label> 
            						<input type="text" class="form-control" id="complemento" name="complemento" value="<?=$oSicasServidor->oSicasPessoa->complemento?>" />
            					</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="bairro">Bairro</label> 
            						<input type="text" class="form-control" id="bairro" name="bairro" value="<?=$oSicasServidor->oSicasPessoa->bairro?>" />
            					</div>
            				</div>
            			</div>
            			<div class="row">
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="cidade">Cidade</label> 
            						<input type="text" class="form-control" id="cidade" name="cidade" value="<?=$oSicasServidor->oSicasPessoa->cidade?>" />
            					</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="uf">UF</label>
                                    <?php $oController->componenteListaUf("uf", $oSicasServidor->oSicasPessoa->uf);?>
                                </div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="cep">CEP</label> 
            						<input type="text" class="form-control cep" id="cep" name="cep" value="<?=$oSicasServidor->oSicasPessoa->cep?>" />
            					</div>
            				</div>
            			</div>
            			<div class="row">
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="telefone">Telefone</label> 
            						<input type="text" class="form-control" id="telefone" name="telefone" value="<?=$oSicasServidor->oSicasPessoa->telefone?>" />
            					</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="grupo_sanguineo">Grupo Sanguíneo</label> 
            						<input type="text" class="form-control" id="grupo_sanguineo" name="grupo_sanguineo" value="<?=$oSicasServidor->oSicasPessoa->grupo_sanguineo?>" />
            					</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="foto">Foto</label> 
            						<input type="text" class="form-control" id="foto" name="foto" value="<?=$oSicasServidor->oSicasPessoa->foto?>" />
            					</div>
            				</div>
            			</div>
                	</div>
                	<div role="tabpanel" class="tab-pane" id="dadosServidor">
                		<br />
<?php 
if($oSicasServidor){
?>                		
            			<div class="row">
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="cd_pessoa">Servidor</label>
            						<div>
            						<?=$oSicasServidor->oSicasPessoa->nm_pessoa?>
            						</div>          						
            						<input type="hidden" name="cd_pessoa" id="cd_pessoa" value="<?=$oSicasServidor->oSicasPessoa->cd_pessoa?>" />
            					</div>
            				</div>
            			</div>
<?php 
}
?>
            			<div class="row">
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="cd_matricula">Matrícula SIAPE</label> 
            						<input type="text" class="form-control" id="cd_matricula" name="cd_matricula" value="<?=$oSicasServidor->cd_matricula?>" />
            					</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="cd_lotacao">Lotação</label> 
            						<select name="cd_lotacao" id="cd_lotacao" class="form-control">
            							<option value="">Selecione</option>
                                    <?php
            						foreach($aSicasLotacao as $oSicasLotacao ) {
            						?>
                                        <option value="<?=$oSicasLotacao->cd_lotacao?>" <?=($oSicasLotacao->cd_lotacao == $oSicasServidor->oSicasLotacao->cd_lotacao) ? " selected" : ""?>><?=$oSicasLotacao->sigla?> - <?=$oSicasLotacao->nm_lotacao?></option>
                                    <?php
            						}
            						?>
                                    </select>
            					</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="serv_efetivo">Servidor Efetivo</label> 
            						<select name="serv_efetivo" id="serv_efetivo" class="form-control">
            							<option value="1" <?=($oSicasServidor->serv_efetivo == "1") ? " selected" : "";?>>SIM</option>
            							<option value="0" <?=($oSicasServidor->serv_efetivo == "0") ? " selected" : "";?>>NÃO</option>
            						</select>
            					</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="usuario_proas">Usuário PROAS?</label> 
            						<select name="usuario_proas" id="usuario_proas" class="form-control">
            							<option value="1" <?=($oSicasServidor->usuario_proas == "1") ? " selected" : "";?>>SIM</option>
            							<option value="0" <?=($oSicasServidor->usuario_proas == "0") ? " selected" : "";?>>NÃO</option>
            						</select>
            					</div>
            				</div>
                			<div class="col-md-4">
                				<div class="form-group">
                					<label for="cd_cargo">Cargo</label> 
                					<select name="cd_cargo" id="cd_cargo" class="form-control">
                						<option value="">Selecione</option>
                                    <?php
                						foreach($aRhCargo as $oRhCargo){
                					?>
                                        <option value="<?=$oRhCargo->cd_cargo?>"<?=($oRhCargo->cd_cargo == $oSicasServidor->oRhCargo->cd_cargo) ? " selected" : ""?>><?=$oRhCargo->descricao_cargo_abrev?></option>
                                    <?php
                					}
                					?>
                                    </select>
                				</div>
                			</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="ramal1">Ramal</label> 
            						<input type="text" class="form-control" id="ramal1" name="ramal1" value="<?=$oSicasServidor->ramal1?>" />
            					</div>
            				</div>
            				<div class="col-md-4">
                				<div class="form-group">
                					<label for="cd_categoria_servidor">Categoria</label> 
                					<select name="cd_categoria_servidor" id="cd_categoria_servidor" class="form-control">
                						<option value="">Selecione</option>
                                    <?php
                                    foreach($aSicasPessoaCategoria as $oSicasPessoaCategoria){
                					?>
                                        <option value="<?=$oSicasPessoaCategoria->cd_categoria?>"<?=($oSicasPessoaCategoria->cd_categoria == $oSicasServidor->oSicasPessoaCategoria->cd_categoria) ? " selected" : ""?>><?=$oSicasPessoaCategoria->desc_categoria_abrev?></option>
                                    <?php
                					}
                					?>
                                    </select>
                				</div>
                			</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="foto_servidor">Foto</label> 
            						<input type="text" class="form-control" id="foto_servidor" name="foto_servidor" value="<?=$oSicasServidor->foto?>" />
            					</div>
            				</div>
                			<div class="col-md-4">
            					<div class="form-group">
            						<label for="status_servidor">Situação do Vínculo</label> 
            						<select name="status_servidor" id="status_servidor" class="form-control">
            							<option value="1" <?=($oSicasServidor->status == 1) ? " selected" : "";?>>ATIVO</option>
            							<option value="0" <?=($oSicasServidor->status == 0) ? " selected" : "";?>>INATIVO</option>
            						</select>
            					</div>
            				</div>
            				<div class="col-md-4">
            					<div class="form-group">
            						<label for="vl_saldo_odonto">Saldo Odontológico (R$)</label> 
            						<input type="text" class="form-control" id="vl_saldo_odonto" name="vl_saldo_odonto" value="<?=$oSicasServidor->vl_saldo_odonto?>" />
            					</div>
            				</div>
            			</div>
                	</div>
            	</div>
            </div>        

			<div class="row">
				<div class="col-md-4">
					<div class="form-actions">
						<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
						<a class="btn btn-default" href="admSicasServidor.php">Voltar</a>
						<input type="hidden" name="cd_servidor" id="cd_servidor" value="<?=$_REQUEST['cd_servidor']?>" />
						<input type="hidden" name="tipo_beneficiario" id="tipo_beneficiario" value="<?=($oSicasServidor->oSicasPessoa->tipo_beneficiario) ? $oSicasServidor->oSicasPessoa->tipo_beneficiario : "S"?>" />
						<input type="hidden" name="classe" id="classe" value="SicasServidor" />
						<input type="hidden" name="status" id="status" value="1" />
						<input type="hidden" name="cd_categoria" id="cd_categoria" value="<?php $oSicasServidor->oSicasPessoa->oSicasPessoaCategoria->cd_categoria?>" />
					</div>
				</div>
			</div>

		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>