<?php
class SicasMedicoMAP {
    static function getMetaData($alias='sicas_medico') {
		return array_merge([$alias => ['cd_medico', 'login', 
                					   'status', 'crm', 'cd_servidor']], 
	                       SicasServidorMAP::getMetaData());
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

	static function objToRs($oSicasMedico){
		$reg['cd_medico'] = $oSicasMedico->cd_medico;
		$reg['login'] = $oSicasMedico->login;
		$reg['status'] = $oSicasMedico->status;
		$reg['crm'] = $oSicasMedico->crm;
		$oSicasServidor = $oSicasMedico->oSicasServidor;
		$reg['cd_servidor'] = $oSicasServidor->cd_servidor;
		return $reg;		   
	}

	static function objToRsInsert($oSicasMedico){
		$reg['login'] = $oSicasMedico->login;
		$reg['status'] = $oSicasMedico->status;
		$reg['crm'] = $oSicasMedico->crm;
		$oSicasServidor = $oSicasMedico->oSicasServidor;
		$reg['cd_servidor'] = $oSicasServidor->cd_servidor;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasMedico = new SicasMedico();
		$oSicasMedico->cd_medico = $reg['sicas_medico_cd_medico'];
		$oSicasMedico->login = $reg['sicas_medico_login'];
		$oSicasMedico->status = $reg['sicas_medico_status'];
		$oSicasMedico->crm = $reg['sicas_medico_crm'];

		$oSicasServidor = new SicasServidor();
		$oSicasServidor->cd_servidor = $reg['sicas_servidor_cd_servidor'];
		$oSicasServidor->cd_matricula = $reg['sicas_servidor_cd_matricula'];
		$oSicasServidor->cd_lotacao = $reg['sicas_servidor_cd_lotacao'];
		$oSicasServidor->status = $reg['sicas_servidor_status'];
		$oSicasServidor->serv_efetivo = $reg['sicas_servidor_serv_efetivo'];
		$oSicasServidor->ramal1 = $reg['sicas_servidor_ramal1'];
		$oSicasServidor->ramal2 = $reg['sicas_servidor_ramal2'];
		$oSicasServidor->ramal3 = $reg['sicas_servidor_ramal3'];
		$oSicasServidor->foto = $reg['sicas_servidor_foto'];
		$oSicasServidor->descricao_perfil = $reg['sicas_servidor_descricao_perfil'];
		$oSicasServidor->usuario_proas    = $reg['sicas_servidor_usuario_proas'];
		$oSicasServidor->vl_saldo_odonto  = $reg['sicas_servidor_vl_saldo_odonto'];
		
		$oSicasPessoa = new SicasPessoa();
		$oSicasPessoa->cd_pessoa      = $reg['sicas_pessoa_cd_pessoa'];
		$oSicasPessoa->nm_pessoa      = $reg['sicas_pessoa_nm_pessoa'];
		$oSicasPessoa->email          = $reg['sicas_pessoa_email'];
		$oSicasPessoa->dt_nascimento  = $reg['sicas_pessoa_dt_nascimento'];
		$oSicasPessoa->genero         = $reg['sicas_pessoa_genero'];
		
		$oSicasEstadoCivil = new SicasEstadoCivil();
		$oSicasEstadoCivil->cd_estado_civil = $reg['sicas_estado_civil_cd_estado_civil'];
		$oSicasEstadoCivil->nm_estado_civil = $reg['sicas_estado_civil_nm_estado_civil'];
		$oSicasEstadoCivil->status          = $reg['sicas_estado_civil_status'];
		$oSicasPessoa->oSicasEstadoCivil = $oSicasEstadoCivil;
		
		$oSicasPessoa->identidade         = $reg['sicas_pessoa_identidade'];
		$oSicasPessoa->nm_orgao_emissor   = $reg['sicas_pessoa_nm_orgao_emissor'];
		$oSicasPessoa->dt_emissao         = $reg['sicas_pessoa_dt_emissao'];
		$oSicasPessoa->cpf                = $reg['sicas_pessoa_cpf'];
		$oSicasPessoa->endereco           = $reg['sicas_pessoa_endereco'];
		$oSicasPessoa->complemento        = $reg['sicas_pessoa_complemento'];
		$oSicasPessoa->bairro             = $reg['sicas_pessoa_bairro'];
		$oSicasPessoa->cidade             = $reg['sicas_pessoa_cidade'];
		$oSicasPessoa->uf                 = $reg['sicas_pessoa_uf'];
		$oSicasPessoa->cep                = $reg['sicas_pessoa_cep'];
		$oSicasPessoa->telefone           = $reg['sicas_pessoa_telefone'];
		$oSicasPessoa->grupo_sanguineo    = $reg['sicas_pessoa_grupo_sanguineo'];
		$oSicasPessoa->tipo_beneficiario  = $reg['sicas_pessoa_tipo_beneficiario'];
		$oSicasPessoa->status             = $reg['sicas_pessoa_status'];
		$oSicasPessoa->foto               = $reg['sicas_pessoa_foto'];
		
		$oSicasPessoaCategoria = new SicasPessoaCategoria();
		$oSicasPessoaCategoria->cd_categoria         = $reg['sicas_pessoa_categoria_cd_categoria'];
		$oSicasPessoaCategoria->desc_categoria       = $reg['sicas_pessoa_categoria_desc_categoria'];
		$oSicasPessoaCategoria->desc_categoria_abrev = $reg['sicas_pessoa_categoria_desc_categoria_abrev'];
		
		$oSicasPessoa->oSicasPessoaCategoria = $oSicasPessoaCategoria;
		$oSicasPessoa->uf_identidade = $reg['sicas_pessoa_uf_identidade'];
		
		$oSicasServidor->oSicasPessoa = $oSicasPessoa;
		$oRhCargo = new RhCargo ();
		$oRhCargo->cd_cargo              = $reg['rh_cargo_cd_cargo'];
		$oRhCargo->descricao_cargo       = $reg['rh_cargo_descricao_cargo'];
		$oRhCargo->descricao_cargo_abrev = $reg['rh_cargo_descricao_cargo_abrev'];
		$oRhCargo->num_siape_cargo       = $reg['rh_cargo_num_siape_cargo'];
		$oRhCargo->status                = $reg['rh_cargo_status'];
		
		$oSicasServidor->oRhCargo = $oRhCargo;
		$oSicasMedico->oSicasServidor = $oSicasServidor;
		
		return $oSicasMedico;		   
	}
}
