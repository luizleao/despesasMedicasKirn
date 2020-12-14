<?php
require_once("classes/autoload.php");

$oControllerServidor = new ControllerSicasServidor();
$oControllerDependente = new ControllerSicasDependente();

$oSicasServidor   = $oControllerServidor->get($_REQUEST['cd_servidor']);
$aSicasDependente = $oControllerDependente->getAll(["sicas_servidor.cd_servidor = ".$oSicasServidor->cd_servidor, "sicas_dependente.status=1"]);

$aTipoBeneficiario = ['D'=>'DEPENDENTE',
				  	  'S'=>'SERVIDOR',
				  	  'T'=>'TERCEIRIZADO'];
?>
<br />
<fieldset>
	<legend>Dados Pessoais <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></legend>
	<div class="row">
		<div class="col-md-9">
    		<div class="row">
        		<div class="col-md-2">
        			<label>Nome:</label>
        		</div>
        		<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->nm_pessoa?></div>		
        	</div>
        </div>
	</div>
	<div class="row">
		<div class="col-md-5">
			<div class="row">
				<div class="col-md-4">
					<label>Nascimento:</label>
				</div>
				<div class="col-md-8"><?=Util::formataDataBancoForm($oSicasServidor->oSicasPessoa->dt_nascimento)?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Estado Civil:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->oSicasEstadoCivil->nm_estado_civil?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Órgão Emissor:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->nm_orgao_emissor?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Data de Emissão:</label>
				</div>
				<div class="col-md-8"><?=Util::formataDataBancoForm($oSicasServidor->oSicasPessoa->dt_emissao)?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Endereço:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->endereco?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Bairro:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->bairro?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>UF:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->uf?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Telefone:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->telefone?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Tipo Beneficiário:</label>
				</div>
				<div class="col-md-8"><?=$aTipoBeneficiario[$oSicasServidor->oSicasPessoa->tipo_beneficiario];?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Categoria:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->oSicasPessoaCategoria->cd_categoria?> - <?=$oSicasServidor->oSicasPessoa->oSicasPessoaCategoria->desc_categoria?></div>
			</div>
		</div>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-4">
					<label>E-mail:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->email?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Sexo:</label>
				</div>
				<div class="col-md-8"><?=($oSicasServidor->oSicasPessoa->genero == 'F') ? 'FEMININO' : 'MASCULINO'?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>RG:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->identidade?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>UF RG:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->uf_identidade?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>CPF:</label>
				</div>
				<div class="col-md-8"><?=Util::formataCPF($oSicasServidor->oSicasPessoa->cpf)?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Complemento:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->complemento?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Cidade:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->cidade?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>CEP:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->cep?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Tipo Sanguíneo:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->grupo_sanguineo?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Foto:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasPessoa->foto?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Situação Pessoa:</label>
				</div>
				<div class="col-md-8"><?=($oSicasServidor->oSicasPessoa->status == 1) ? "Ativo" : "Inativo"?></div>
			</div>
		</div>
	</div>
</fieldset>
<?php 
if($oSicasServidor){
?>
<fieldset>
	<legend>Dados Funcionais</legend>
	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-4">
					<label>Matrícula:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->cd_matricula?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Lotação:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oSicasLotacao->nm_lotacao?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Cargo:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->oRhCargo->descricao_cargo_abrev?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Servidor Efetivo?</label>
				</div>
				<div class="col-md-8"><?=($oSicasServidor->serv_efetivo ==1) ? "Sim" : "Não"?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Ramal:</label>
				</div>
				<div class="col-md-8"><?=$oSicasServidor->ramal1?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Usuário PROAS:</label>
				</div>
				<div class="col-md-8"><?=($oSicasServidor->usuario_proas == 1) ? "Sim" : "Não"?></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label>Situação:</label>
				</div>
				<div class="col-md-8"><?=($oSicasServidor->status == 1) ? "Ativo" : "Inativo"?></div>
			</div>
		</div>
	</div>
</fieldset>
<?php 
}
if($aSicasDependente){
?>
<fieldset>
	<legend>Dependentes</legend>
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Parentesco</th>
				<th>Dep. Financeiro?</th>
				<th>Dep. PROAS?</th>
			</tr>
		</thead>		
		<tbody>
<?php 
	foreach($aSicasDependente as $oSicasDependente){
?>		
			<tr>
				<td><?=$oSicasDependente->oSicasPessoa->nm_pessoa?></td>
				<td><?=$oSicasDependente->oSicasGrauParentesco->nm_grau_parentesco?></td>
				<td><?=($oSicasDependente->dependente_financ == 1) ? "Sim" : "Não"?></td>
				<td><?=($oSicasDependente->dependente_proas == 1) ? "Sim" : "Não"?></td>
			</tr>
<?php 
	}
?>
		</tbody>
	</table>
</fieldset>
<?php 
}
?>