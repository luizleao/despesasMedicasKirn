<?php
class SicasDependenteMAP {
    static function getMetaData($alias='sicas_dependente') {
	    return array_merge([$alias => ['cd_dependente',
                            	        'cd_servidor',
                            	        'cd_pessoa',
                            	        'cd_seq_dependente',
                            	        'cd_grau_parentesco',
                            	        'cd_escolaridade',
                            	        'dt_inclusao',
                            	        'dt_manutencao',
                            	        'dependente_financ',
                            	        'dependente_proas',
                            	        'status']],
	        SicasPessoaMAP::getMetaData(),
	        SicasServidorMAP::getMetaData(),
	        SicasGrauParentescoMAP::getMetaData(),
	        SicasEscolaridadeMAP::getMetaData(),
	        SicasPessoaMAP::getMetaData('pessoa_servidor'),
	        SicasPessoaCategoriaMAP::getMetaData('categoria_servidor'));
	}
	
	static function dataToSelect() {
		foreach(self::getMetaData() as $tabela => $aCampo){
			foreach($aCampo as $sCampo){
				$aux[] = "$tabela.$sCampo as $tabela"."_$sCampo";
			}
		}
	
		return implode(",\n", $aux);
	}
	
	static function filterLike($valor) {
		foreach(self::getMetaData() as $tabela => $aCampo){
			foreach($aCampo as $sCampo){
				$aux[] = "$tabela.$sCampo like '$valor'";
			}
		}
	
		return implode("\nor ", $aux);
	}
	
	static function objToRs($oSicasDependente) {
		$reg['cd_dependente'] = $oSicasDependente->cd_dependente;
		$oSicasServidor = $oSicasDependente->oSicasServidor;
		$reg['cd_servidor'] = $oSicasServidor->cd_servidor;
		$oSicasPessoa = $oSicasDependente->oSicasPessoa;
		$reg['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$reg['cd_seq_dependente'] = $oSicasDependente->cd_seq_dependente;
		$oSicasGrauParentesco = $oSicasDependente->oSicasGrauParentesco;
		$reg['cd_grau_parentesco'] = $oSicasGrauParentesco->cd_grau_parentesco;
		$oSicasEscolaridade = $oSicasDependente->oSicasEscolaridade;
		$reg['cd_escolaridade'] = $oSicasEscolaridade->cd_escolaridade;
		$reg['dt_inclusao'] = $oSicasDependente->dt_inclusao;
		$reg['dt_manutencao'] = $oSicasDependente->dt_manutencao;
		$reg['dependente_financ'] = $oSicasDependente->dependente_financ;
		$reg['dependente_proas'] = $oSicasDependente->dependente_proas;
		$reg['status'] = $oSicasDependente->status;
		return $reg;
	}
	
	static function objToRsInsert($oSicasDependente) {
		$oSicasServidor = $oSicasDependente->oSicasServidor;
		$reg['cd_servidor'] = $oSicasServidor->cd_servidor;
		$oSicasPessoa = $oSicasDependente->oSicasPessoa;
		$reg['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$reg['cd_seq_dependente'] = $oSicasDependente->cd_seq_dependente;
		$oSicasGrauParentesco = $oSicasDependente->oSicasGrauParentesco;
		$reg['cd_grau_parentesco'] = $oSicasGrauParentesco->cd_grau_parentesco;
		$oSicasEscolaridade = $oSicasDependente->oSicasEscolaridade;
		$reg['cd_escolaridade'] = $oSicasEscolaridade->cd_escolaridade;
		$reg['dt_inclusao'] = $oSicasDependente->dt_inclusao;
		$reg['dt_manutencao'] = $oSicasDependente->dt_manutencao;
		$reg['dependente_financ'] = $oSicasDependente->dependente_financ;
		$reg['dependente_proas'] = $oSicasDependente->dependente_proas;
		$reg['status'] = $oSicasDependente->status;
		return $reg;
	}
	
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg[$campo] = $valor;
		}
		$oSicasDependente = new SicasDependente ();
		$oSicasDependente->cd_dependente = $reg['sicas_dependente_cd_dependente'];
		
		$oSicasPessoa = new SicasPessoa ();
		$oSicasPessoa->cd_pessoa = $reg['sicas_pessoa_cd_pessoa'];
		$oSicasPessoa->nm_pessoa = $reg['sicas_pessoa_nm_pessoa'];
		$oSicasPessoa->email = $reg['sicas_pessoa_email'];
		$oSicasPessoa->dt_nascimento = $reg['sicas_pessoa_dt_nascimento'];
		$oSicasPessoa->genero = $reg['sicas_pessoa_genero'];
		$oSicasPessoa->identidade = $reg['sicas_pessoa_identidade'];
		$oSicasPessoa->nm_orgao_emissor = $reg['sicas_pessoa_nm_orgao_emissor'];
		$oSicasPessoa->dt_emissao = $reg['sicas_pessoa_dt_emissao'];
		$oSicasPessoa->cpf = $reg['sicas_pessoa_cpf'];
		$oSicasPessoa->endereco = $reg['sicas_pessoa_endereco'];
		$oSicasPessoa->complemento = $reg['sicas_pessoa_complemento'];
		$oSicasPessoa->bairro = $reg['sicas_pessoa_bairro'];
		$oSicasPessoa->cidade = $reg['sicas_pessoa_cidade'];
		$oSicasPessoa->uf = $reg['sicas_pessoa_uf'];
		$oSicasPessoa->cep = $reg['sicas_pessoa_cep'];
		$oSicasPessoa->telefone = $reg['sicas_pessoa_telefone'];
		$oSicasPessoa->grupo_sanguineo = $reg['sicas_pessoa_grupo_sanguineo'];
		$oSicasPessoa->tipo_beneficiario = $reg['sicas_pessoa_tipo_beneficiario'];
		$oSicasPessoa->status = $reg['sicas_pessoa_status'];
		$oSicasPessoa->foto = $reg['sicas_pessoa_foto'];
		$oSicasPessoa->uf_identidade = $reg['sicas_pessoa_uf_identidade'];
		
		$oSicasPessoaCategoria = new SicasPessoaCategoria ();
		$oSicasPessoaCategoria->cd_categoria = $reg ['sicas_pessoa_categoria_cd_categoria'];
		$oSicasPessoaCategoria->desc_categoria = $reg ['sicas_pessoa_categoria_desc_categoria'];
		$oSicasPessoaCategoria->desc_categoria_abrev = $reg ['sicas_pessoa_categoria_desc_categoria_abrev'];
		$oSicasPessoa->oSicasPessoaCategoria = $oSicasPessoaCategoria;
		
		$oSicasDependente->oSicasPessoa = $oSicasPessoa;
		
		$oSicasServidor = new SicasServidor ();
		$oSicasServidor->cd_servidor = $reg['sicas_servidor_cd_servidor'];
		$oSicasServidor->cd_matricula = $reg['sicas_servidor_cd_matricula'];
		$oSicasServidor->status = $reg['sicas_servidor_status'];
		$oSicasServidor->serv_efetivo = $reg['sicas_servidor_serv_efetivo'];
		//'cd_cargo',
		$oSicasServidor->ramal1 = $reg['sicas_servidor_ramal1'];
		$oSicasServidor->ramal2 = $reg['sicas_servidor_ramal2'];
		$oSicasServidor->ramal3 = $reg['sicas_servidor_ramal3'];
		//'cd_categoria',
		$oSicasServidor->foto = $reg['sicas_servidor_foto'];
		$oSicasServidor->descricao_perfil = $reg['sicas_servidor_descricao_perfil'];
		$oSicasServidor->usuario_proas = $reg['sicas_servidor_usuario_proas'];
		
		$oSicasDependente->oSicasServidor = $oSicasServidor;
		
		$oCategoriaServidor = new SicasPessoaCategoria();
		$oCategoriaServidor->cd_categoria = $reg['categoria_servidor_cd_categoria'];
		$oCategoriaServidor->desc_categoria = $reg['categoria_servidor_desc_categoria'];
		$oCategoriaServidor->desc_categoria_abrev = $reg['categoria_servidor_desc_categoria_abrev'];
		
		$oSicasDependente->oSicasServidor->oSicasPessoaCategoria = $oCategoriaServidor;
		
		$oSicasPessoaServidor = new SicasPessoa();
		$oSicasPessoaServidor->cd_pessoa = $reg['pessoa_servidor_cd_pessoa'];
		$oSicasPessoaServidor->nm_pessoa = $reg['pessoa_servidor_nm_pessoa'];
		$oSicasPessoaServidor->email = $reg['pessoa_servidor_email'];
		$oSicasPessoaServidor->dt_nascimento = $reg['pessoa_servidor_dt_nascimento'];
		$oSicasPessoaServidor->genero = $reg['pessoa_servidor_genero'];
		$oSicasPessoaServidor->identidade = $reg['pessoa_servidor_identidade'];
		$oSicasPessoaServidor->nm_orgao_emissor = $reg['pessoa_servidor_nm_orgao_emissor'];
		$oSicasPessoaServidor->dt_emissao = $reg['pessoa_servidor_dt_emissao'];
		$oSicasPessoaServidor->cpf = $reg['pessoa_servidor_cpf'];
		$oSicasPessoaServidor->endereco = $reg['pessoa_servidor_endereco'];
		$oSicasPessoaServidor->complemento = $reg['pessoa_servidor_complemento'];
		$oSicasPessoaServidor->bairro = $reg['pessoa_servidor_bairro'];
		$oSicasPessoaServidor->cidade = $reg['pessoa_servidor_cidade'];
		$oSicasPessoaServidor->uf = $reg['pessoa_servidor_uf'];
		$oSicasPessoaServidor->cep = $reg['pessoa_servidor_cep'];
		$oSicasPessoaServidor->telefone = $reg['pessoa_servidor_telefone'];
		$oSicasPessoaServidor->grupo_sanguineo = $reg['pessoa_servidor_grupo_sanguineo'];
		$oSicasPessoaServidor->tipo_beneficiario = $reg['pessoa_servidor_tipo_beneficiario'];
		$oSicasPessoaServidor->status = $reg['pessoa_servidor_status'];
		$oSicasPessoaServidor->foto = $reg['pessoa_servidor_foto'];
		$oSicasPessoaServidor->uf_identidade = $reg['pessoa_servidor_uf_identidade'];
		$oSicasPessoaServidor->tipo_identidade = $reg['pessoa_servidor_tipo_identidade'];
		$oSicasPessoaServidor->descricao_perfil = $reg['pessoa_servidor_descricao_perfil'];
		$oSicasPessoaServidor->usuario_proas = $reg['pessoa_servidor_usuario_proas'];
		
		$oSicasDependente->oSicasServidor->oSicasPessoa = $oSicasPessoaServidor;
		
		$oSicasDependente->cd_seq_dependente = $reg['sicas_dependente_cd_seq_dependente'];
		
		$oSicasGrauParentesco = new SicasGrauParentesco ();
		$oSicasGrauParentesco->cd_grau_parentesco = $reg['sicas_grau_parentesco_cd_grau_parentesco'];
		$oSicasGrauParentesco->desc_grauparentesco = $reg['sicas_grau_parentesco_desc_grauparentesco'];
		$oSicasGrauParentesco->nm_grau_parentesco = $reg['sicas_grau_parentesco_nm_grau_parentesco'];
		$oSicasGrauParentesco->status = $reg['sicas_grau_parentesco_status'];
		$oSicasDependente->oSicasGrauParentesco = $oSicasGrauParentesco;
		
		$oSicasEscolaridade = new SicasEscolaridade ();
		$oSicasEscolaridade->cd_escolaridade = $reg['sicas_escolaridade_cd_escolaridade'];
		$oSicasEscolaridade->nm_escolaridade = $reg['sicas_escolaridade_nm_escolaridade'];
		$oSicasEscolaridade->status = $reg['sicas_escolaridade_status'];
		$oSicasDependente->oSicasEscolaridade = $oSicasEscolaridade;
		$oSicasDependente->dt_inclusao = $reg['sicas_dependente_dt_inclusao'];
		$oSicasDependente->dt_manutencao = $reg['sicas_dependente_dt_manutencao'];
		$oSicasDependente->dependente_financ = $reg['sicas_dependente_dependente_financ'];
		$oSicasDependente->dependente_proas = $reg['sicas_dependente_dependente_proas'];
		$oSicasDependente->status = $reg['sicas_dependente_status'];
		
		
		return $oSicasDependente;
	}
}
