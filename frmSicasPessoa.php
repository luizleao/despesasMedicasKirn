<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasPessoa();

$oSicasPessoa = ($_REQUEST['cd_pessoa'] == "") ? NULL : $oController->get($_REQUEST['cd_pessoa']);
$label   = (is_null($oSicasPessoa)) ? "Cadastrar" : "Editar";

if($_POST){
    $operacao = (is_object($oSicasPessoa)) ? ($oController->alterar()) : ($oController->cadastrar());
    print ($operacao) ? "" : $oController->msg; exit;
}

$aSicasEstadoCivil     = (new ControllerSicasEstadoCivil())->getAll();
$aSicasPessoaCategoria = (new ControllerSicasPessoaCategoria())->getAll([], ["sicas_pessoa_categoria.desc_categoria"]);
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
			<li><a href="admSicasPessoa.php">Pessoa</a></li>
			<li class="active"><?=$label?></li>
		</ol>
<?php
if ($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
        <form role="form" onsubmit="return false;">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="tipo_beneficiario">Tipo Beneficiário</label> 
						<select name="tipo_beneficiario" id="tipo_beneficiario" class="form-control">
							<option value="D"<?=($oSicasPessoa->tipo_beneficiario == 'D') ? " selected" : ""?>>DEPENDENTE</option>
							<option value="E"<?=($oSicasPessoa->tipo_beneficiario == 'E') ? " selected" : ""?>>ESTAGIARIO</option>
							<option value="S"<?=($oSicasPessoa->tipo_beneficiario == 'S') ? " selected" : ""?>>SERVIDOR</option>
							<option value="T"<?=($oSicasPessoa->tipo_beneficiario == 'T') ? " selected" : ""?>>TERCEIRIZADO</option>
							<option value="V"<?=($oSicasPessoa->tipo_beneficiario == 'V') ? " selected" : ""?>>VISITANTE</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="cd_categoria">Categoria</label> 
						<select name="cd_categoria" id="cd_categoria" class="form-control">
							<option value="">Selecione</option>
<?php
foreach($aSicasPessoaCategoria as $oSicasPessoaCategoria){
?>
                            <option value="<?=$oSicasPessoaCategoria->cd_categoria?>" <?=($oSicasPessoaCategoria->cd_categoria == $oSicasPessoa->oSicasPessoaCategoria->cd_categoria) ? " selected" : ""?>><?=$oSicasPessoaCategoria->desc_categoria_abrev?></option>
<?php
}
?>
                        </select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="cpf">CPF</label> 
						<input type="text" class="form-control cpf" id="cpf" name="cpf" value="<?=$oSicasPessoa->cpf?>" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="nm_pessoa">Nome</label> 
						<input type="text" class="form-control" id="nm_pessoa" name="nm_pessoa" value="<?=$oSicasPessoa->nm_pessoa?>" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="email">E-mail</label>
						<div class="input-group">
							<div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
							<input type="text" class="form-control" name="email" id="email" value="<?=$oSicasPessoa->email?>" />
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label for="dt_nascimento">Data de Nascimento</label>
                    <?php $oController->componenteCalendario('dt_nascimento', Util::formataDataBancoForm($oSicasPessoa->dt_nascimento))?>
				</div>
				<div class="col-md-4">
					<label>Sexo</label>
					<div class="radio">
						<label> 
							<input type="radio" name="genero" id="generoM" value="M" <?=($oSicasPessoa->genero == 'M') ? "Checked" : "" ?> /> Masculino
						</label>
					</div>
					<div class="radio">
						<label> 
							<input type="radio" name="genero" id="generoF" value="F" <?=($oSicasPessoa->genero == 'F') ? "Checked" : "" ?> /> Feminino
						</label>
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
                            <option value="<?=$oSicasEstadoCivil->cd_estado_civil?>" <?=($oSicasEstadoCivil->cd_estado_civil == $oSicasPessoa->oSicasEstadoCivil->cd_estado_civil) ? " selected" : ""?>><?=$oSicasEstadoCivil->nm_estado_civil?></option>
						<?php
						}
						?>
                        </select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="identidade">Identidade</label> 
						<input type="text" class="form-control" id="identidade" name="identidade" value="<?=$oSicasPessoa->identidade?>" />
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="tipo_identidade">Tipo de Identidade</label> 
						<select class="form-control" id="tipo_identidade" name="tipo_identidade">
							<option value="RG"<?=($oSicasPessoa->tipo_identidade == 'RG') ? " checked" : ""?>>RG</option>
							<option value="CNH"<?=($oSicasPessoa->tipo_identidade == 'CNH') ? " checked" : ""?>>CNH</option>
							<option value="PASSAPORTE"<?=($oSicasPessoa->tipo_identidade == 'PASSAPORTE') ? " checked" : ""?>>PASSAPORTE</option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="nm_orgao_emissor">Orgão Emissor</label> 
						<input type="text" class="form-control" id="nm_orgao_emissor" name="nm_orgao_emissor" value="<?=$oSicasPessoa->nm_orgao_emissor?>" maxlength="8" size="8" />
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="uf">UF Órgão Emissor</label>
	                    <?php $oController->componenteListaUf("uf_identidade", $oSicasPessoa->uf_identidade);?>
	                </div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="dt_emissao">Data de Emissão</label>
						<?php $oController->componenteCalendario('dt_emissao', Util::formataDataBancoForm($oSicasPessoa->dt_emissao))?>
                    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="endereco">Endereço</label> 
						<input type="text" class="form-control" id="endereco" name="endereco" value="<?=$oSicasPessoa->endereco?>" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="complemento">Complemento</label> 
						<input type="text" class="form-control" id="complemento" name="complemento" value="<?=$oSicasPessoa->complemento?>" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="bairro">Bairro</label> 
						<input type="text" class="form-control" id="bairro" name="bairro" value="<?=$oSicasPessoa->bairro?>" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="cidade">Cidade</label> 
						<input type="text" class="form-control" id="cidade" name="cidade" value="<?=$oSicasPessoa->cidade?>" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="uf">UF</label>
                        <?php $oController->componenteListaUf("uf", $oSicasPessoa->uf);?>
                    </div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="cep">CEP</label> 
						<input type="text" class="form-control cep" id="cep" name="cep" value="<?=$oSicasPessoa->cep?>" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="telefone">Telefone</label> 
						<input type="text" class="form-control telefone" id="telefone" name="telefone" value="<?=$oSicasPessoa->telefone?>" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="grupo_sanguineo">Grupo Sanguíneo</label> 
						<input type="text" class="form-control" id="grupo_sanguineo" name="grupo_sanguineo" value="<?=$oSicasPessoa->grupo_sanguineo?>" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="foto">Foto</label> 
						<input type="text" class="form-control" id="foto" name="foto" value="<?=$oSicasPessoa->foto?>" />
					</div>
				</div>
 				<div class="col-md-4">
                	<div class="form-group">
                		<label for="status">Status</label>
                		<select name="status" id="status" class="form-control">
							<option value="1"<?=($oSicasPessoa->status == '1') ? ' selected="selected"' : ''?>>Ativo</option>
							<option value="0"<?=($oSicasPessoa->status == '0') ? ' selected="selected"' : ''?>>Inativo</option>
						</select>
                	</div>
                </div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<button id="btn<?=$label?>" data-loading-text="loading..." type="submit" class="btn btn-primary">Salvar</button>
						<a class="btn btn-default" href="admSicasPessoa.php">Voltar</a> 
						<input type="hidden" name="cd_pessoa" id="cd_pessoa" value="<?=$oSicasPessoa->cd_pessoa?>" />
						<input type="hidden" name="classe" id="classe" value="SicasPessoa" />
					</div>
				</div>
			</div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
</body>
</html>