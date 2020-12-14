<?php
class SicasPessoaMAP {
    static function getMetaData($alias='sicas_pessoa') {
		return array_merge([$alias => ['cd_pessoa', 'nm_pessoa', 'email', 'dt_nascimento', 'genero',
            									'cd_estado_civil', 'identidade', 'nm_orgao_emissor', 'dt_emissao',
            									'cpf', 'endereco', 'complemento', 'bairro', 'cidade', 'uf', 'cep', 
		                                        'telefone', 'grupo_sanguineo', 'tipo_beneficiario', 'status', 'foto', 
		                                        'cd_categoria', 'uf_identidade', 'tipo_identidade', 'descricao_perfil', 'usuario_proas']],
		    
                		    SicasPessoaCategoriaMAP::getMetaData(),
                		    SicasEstadoCivilMAP::getMetaData());
		
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
	
	
	static function objToRs($oSicasPessoa) {
		$reg ['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$reg ['nm_pessoa'] = $oSicasPessoa->nm_pessoa;
		$reg ['email'] = $oSicasPessoa->email;
		$reg ['dt_nascimento'] = $oSicasPessoa->dt_nascimento;
		$reg ['genero'] = $oSicasPessoa->genero;
		$oSicasEstadoCivil = $oSicasPessoa->oSicasEstadoCivil;
		$reg ['cd_estado_civil'] = $oSicasEstadoCivil->cd_estado_civil;
		$reg ['identidade'] = $oSicasPessoa->identidade;
		$reg ['nm_orgao_emissor'] = $oSicasPessoa->nm_orgao_emissor;
		$reg ['dt_emissao'] = $oSicasPessoa->dt_emissao;
		$reg ['cpf'] = $oSicasPessoa->cpf;
		$reg ['endereco'] = $oSicasPessoa->endereco;
		$reg ['complemento'] = $oSicasPessoa->complemento;
		$reg ['bairro'] = $oSicasPessoa->bairro;
		$reg ['cidade'] = $oSicasPessoa->cidade;
		$reg ['uf'] = $oSicasPessoa->uf;
		$reg ['cep'] = $oSicasPessoa->cep;
		$reg ['telefone'] = $oSicasPessoa->telefone;
		$reg ['grupo_sanguineo'] = $oSicasPessoa->grupo_sanguineo;
		$reg ['tipo_beneficiario'] = $oSicasPessoa->tipo_beneficiario;
		$reg ['status'] = $oSicasPessoa->status;
		$reg ['foto'] = $oSicasPessoa->foto;
		$oSicasPessoaCategoria = $oSicasPessoa->oSicasPessoaCategoria;
		$reg ['cd_categoria'] = $oSicasPessoaCategoria->cd_categoria;
		$reg ['uf_identidade'] = $oSicasPessoa->uf_identidade;
		$reg ['tipo_identidade']  = $oSicasPessoa->tipo_identidade;
		$reg ['descricao_perfil']  = $oSicasPessoa->descricao_perfil;
		$reg ['usuario_proas']  = $oSicasPessoa->usuario_proas;
				
		return $reg;
	}
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg [$campo] = $valor;
		}
		$oSicasPessoa = new SicasPessoa ();
		$oSicasPessoa->cd_pessoa = $reg ['sicas_pessoa_cd_pessoa'];
		$oSicasPessoa->nm_pessoa = $reg ['sicas_pessoa_nm_pessoa'];
		$oSicasPessoa->email = $reg ['sicas_pessoa_email'];
		$oSicasPessoa->dt_nascimento = $reg ['sicas_pessoa_dt_nascimento'];
		$oSicasPessoa->genero = $reg ['sicas_pessoa_genero'];
		
		$oSicasEstadoCivil = new SicasEstadoCivil ();
		$oSicasEstadoCivil->cd_estado_civil = $reg ['sicas_estado_civil_cd_estado_civil'];
		$oSicasEstadoCivil->nm_estado_civil = $reg ['sicas_estado_civil_nm_estado_civil'];
		$oSicasEstadoCivil->status = $reg ['sicas_estado_civil_status'];
		$oSicasPessoa->oSicasEstadoCivil = $oSicasEstadoCivil;
		$oSicasPessoa->identidade = $reg ['sicas_pessoa_identidade'];
		$oSicasPessoa->nm_orgao_emissor = $reg ['sicas_pessoa_nm_orgao_emissor'];
		$oSicasPessoa->dt_emissao = $reg ['sicas_pessoa_dt_emissao'];
		$oSicasPessoa->cpf = $reg ['sicas_pessoa_cpf'];
		$oSicasPessoa->endereco = $reg ['sicas_pessoa_endereco'];
		$oSicasPessoa->complemento = $reg ['sicas_pessoa_complemento'];
		$oSicasPessoa->bairro = $reg ['sicas_pessoa_bairro'];
		$oSicasPessoa->cidade = $reg ['sicas_pessoa_cidade'];
		$oSicasPessoa->uf = $reg ['sicas_pessoa_uf'];
		$oSicasPessoa->cep = $reg ['sicas_pessoa_cep'];
		$oSicasPessoa->telefone = $reg ['sicas_pessoa_telefone'];
		$oSicasPessoa->grupo_sanguineo = $reg ['sicas_pessoa_grupo_sanguineo'];
		$oSicasPessoa->tipo_beneficiario = $reg ['sicas_pessoa_tipo_beneficiario'];
		$oSicasPessoa->status = $reg ['sicas_pessoa_status'];
		$oSicasPessoa->foto = $reg ['sicas_pessoa_foto'];
		
		$oSicasPessoaCategoria = new SicasPessoaCategoria ();
		$oSicasPessoaCategoria->cd_categoria = $reg ['sicas_pessoa_categoria_cd_categoria'];
		$oSicasPessoaCategoria->desc_categoria = $reg ['sicas_pessoa_categoria_desc_categoria'];
		$oSicasPessoaCategoria->desc_categoria_abrev = $reg ['sicas_pessoa_categoria_desc_categoria_abrev'];
		$oSicasPessoa->oSicasPessoaCategoria = $oSicasPessoaCategoria;
		$oSicasPessoa->uf_identidade = $reg ['sicas_pessoa_uf_identidade'];
		$oSicasPessoa->tipo_identidade = $reg ['sicas_pessoa_tipo_identidade'];
		$oSicasPessoa->descricao_perfil = $reg ['sicas_pessoa_descricao_perfil'];
		$oSicasPessoa->usuario_proas= $reg ['sicas_pessoa_usuario_proas'];
		
		return $oSicasPessoa;
	}
	
	static function objToRsInsert($oSicasPessoa) {
		$reg ['nm_pessoa'] = $oSicasPessoa->nm_pessoa;
		$reg ['email'] = $oSicasPessoa->email;
		$reg ['dt_nascimento'] = $oSicasPessoa->dt_nascimento;
		$reg ['genero'] = $oSicasPessoa->genero;
		$oSicasEstadoCivil = $oSicasPessoa->oSicasEstadoCivil;
		$reg ['cd_estado_civil'] = $oSicasEstadoCivil->cd_estado_civil;
		$reg ['identidade'] = $oSicasPessoa->identidade;
		$reg ['nm_orgao_emissor'] = $oSicasPessoa->nm_orgao_emissor;
		$reg ['dt_emissao'] = $oSicasPessoa->dt_emissao;
		$reg ['cpf'] = $oSicasPessoa->cpf;
		$reg ['endereco'] = $oSicasPessoa->endereco;
		$reg ['complemento'] = $oSicasPessoa->complemento;
		$reg ['bairro'] = $oSicasPessoa->bairro;
		$reg ['cidade'] = $oSicasPessoa->cidade;
		$reg ['uf'] = $oSicasPessoa->uf;
		$reg ['cep'] = $oSicasPessoa->cep;
		$reg ['telefone'] = $oSicasPessoa->telefone;
		$reg ['grupo_sanguineo'] = $oSicasPessoa->grupo_sanguineo;
		$reg ['tipo_beneficiario'] = $oSicasPessoa->tipo_beneficiario;
		$reg ['status'] = $oSicasPessoa->status;
		$reg ['foto'] = $oSicasPessoa->foto;
		$oSicasPessoaCategoria = $oSicasPessoa->oSicasPessoaCategoria;
		$reg ['cd_categoria'] = $oSicasPessoaCategoria->cd_categoria;
		$reg ['uf_identidade'] = $oSicasPessoa->uf_identidade;
		$reg ['tipo_identidade']  = $oSicasPessoa->tipo_identidade;
		$reg ['descricao_perfil']  = $oSicasPessoa->descricao_perfil;
		$reg ['usuario_proas']  = $oSicasPessoa->usuario_proas;
		
		return $reg;
	}	
	
	static function wsToObj($obj) {
		$oSicasPessoa = new SicasPessoa();
		$oSicasPessoa->cd_pessoa = $obj->cd_pessoa;
		$oSicasPessoa->nm_pessoa = $obj->nm_pessoa;
		$oSicasPessoa->email = $obj->email;
		$oSicasPessoa->dt_nascimento = $obj->dt_nascimento;
		$oSicasPessoa->genero = $obj->genero;
		
		$oSicasEstadoCivil = new SicasEstadoCivil ();
		$oSicasEstadoCivil->cd_estado_civil = $obj->oSicasEstadoCivil->cd_estado_civil;
		$oSicasEstadoCivil->nm_estado_civil = $obj->oSicasEstadoCivil->nm_estado_civil;
		$oSicasEstadoCivil->status = $obj->oSicasEstadoCivil->status;
		$oSicasPessoa->oSicasEstadoCivil = $oSicasEstadoCivil;
		$oSicasPessoa->identidade = $obj->identidade;
		$oSicasPessoa->nm_orgao_emissor = $obj->nm_orgao_emissor;
		$oSicasPessoa->dt_emissao = $obj->dt_emissao;
		$oSicasPessoa->cpf = $obj->cpf;
		$oSicasPessoa->endereco = $obj->endereco;
		$oSicasPessoa->complemento = $obj->complemento;
		$oSicasPessoa->bairro = $obj->bairro;
		$oSicasPessoa->cidade = $obj->cidade;
		$oSicasPessoa->uf = $obj->uf;
		$oSicasPessoa->cep = $obj->cep;
		$oSicasPessoa->telefone = $obj->telefone;
		$oSicasPessoa->grupo_sanguineo = $obj->grupo_sanguineo;
		$oSicasPessoa->tipo_beneficiario = $obj->tipo_beneficiario;
		$oSicasPessoa->status = $obj->status;
		$oSicasPessoa->foto = $obj->foto;
		
		$oSicasPessoaCategoria = new SicasPessoaCategoria ();
		$oSicasPessoaCategoria->cd_categoria = $obj->oSicasPessoaCategoria->cd_categoria;
		$oSicasPessoaCategoria->desc_categoria = $obj->oSicasPessoaCategoria->desc_categoria;
		$oSicasPessoaCategoria->desc_categoria_abrev = $obj->oSicasPessoaCategoria->desc_categoria_abrev;
		$oSicasPessoa->oSicasPessoaCategoria = $oSicasPessoaCategoria;
		$oSicasPessoa->uf_identidade = $obj->uf_identidade;
		$oSicasPessoa->tipo_identidade = $obj->tipo_identidade;
		$oSicasPessoa->descricao_perfil = $obj->descricao_perfil;
		$oSicasPessoa->usuario_proas = $obj->usuario_proas;
		
		return $oSicasPessoa;
	}
}
