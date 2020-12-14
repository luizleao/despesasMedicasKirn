<?php
class SicasSalarioMAP {
	static function getMetaData($alias='sicas_salario') {
		return array_merge([$alias => ['cd_salario', 
		                               'cd_servidor', 
		                               'val_salario', 
		                               'dt_ini_salario', 
    					               'dt_fim_salario', 
		                               'serv_efetivo', 
                            		   'obs', 
                            		   'status']],
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

	static function objToRs($oSicasSalario){
		$reg['cd_salario'] = $oSicasSalario->cd_salario;
		$oSicasServidor = $oSicasSalario->oSicasServidor;
		$reg['cd_servidor'] = $oSicasServidor->cd_servidor;
		$reg['val_salario'] = $oSicasSalario->val_salario;
		$reg['dt_ini_salario'] = $oSicasSalario->dt_ini_salario;
		$reg['dt_fim_salario'] = $oSicasSalario->dt_fim_salario;
		$reg['serv_efetivo'] = $oSicasSalario->serv_efetivo;
		$reg['obs'] = $oSicasSalario->obs;
		$reg['status'] = $oSicasSalario->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasSalario){
		$oSicasServidor = $oSicasSalario->oSicasServidor;
		$reg['cd_servidor'] = $oSicasServidor->cd_servidor;
		$reg['val_salario'] = $oSicasSalario->val_salario;
		$reg['dt_ini_salario'] = $oSicasSalario->dt_ini_salario;
		$reg['dt_fim_salario'] = $oSicasSalario->dt_fim_salario;
		$reg['serv_efetivo'] = $oSicasSalario->serv_efetivo;
		$reg['obs'] = $oSicasSalario->obs;
		$reg['status'] = $oSicasSalario->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasSalario = new SicasSalario();
		$oSicasSalario->cd_salario = $reg['sicas_salario_cd_salario'];
		$oSicasSalario->val_salario = $reg['sicas_salario_val_salario'];
		$oSicasSalario->dt_ini_salario = $reg['sicas_salario_dt_ini_salario'];
		$oSicasSalario->dt_fim_salario = $reg['sicas_salario_dt_fim_salario'];
		$oSicasSalario->serv_efetivo = $reg['sicas_salario_serv_efetivo'];
		$oSicasSalario->obs = $reg['sicas_salario_obs'];
		$oSicasSalario->status = $reg['sicas_salario_status'];
		
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
		$oSicasPessoa->cd_pessoa          = $reg['sicas_pessoa_cd_pessoa'];
		$oSicasPessoa->nm_pessoa          = $reg['sicas_pessoa_nm_pessoa'];
		$oSicasPessoa->email              = $reg['sicas_pessoa_email'];
		$oSicasPessoa->dt_nascimento      = $reg['sicas_pessoa_dt_nascimento'];
		$oSicasPessoa->genero             = $reg['sicas_pessoa_genero'];
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
		$oSicasPessoa->uf_identidade = $reg['sicas_pessoa_uf_identidade'];
		
		$oSicasEstadoCivil = new SicasEstadoCivil();
		$oSicasEstadoCivil->cd_estado_civil = $reg['sicas_estado_civil_cd_estado_civil'];
		$oSicasEstadoCivil->nm_estado_civil = $reg['sicas_estado_civil_nm_estado_civil'];
		$oSicasEstadoCivil->status          = $reg['sicas_estado_civil_status'];
		$oSicasPessoa->oSicasEstadoCivil = $oSicasEstadoCivil;
		
		$oSicasPessoaCategoria = new SicasPessoaCategoria();
		$oSicasPessoaCategoria->cd_categoria         = $reg['categoria_servidor_cd_categoria'];
		$oSicasPessoaCategoria->desc_categoria       = $reg['categoria_servidor_desc_categoria'];
		$oSicasPessoaCategoria->desc_categoria_abrev = $reg['categoria_servidor_desc_categoria_abrev'];
		
		$oSicasServidor->oSicasPessoaCategoria = $oSicasPessoaCategoria;
		
		$oSicasServidor->oSicasPessoa = $oSicasPessoa;
		$oSicasSalario->oSicasServidor = $oSicasServidor;
		
		return $oSicasSalario;		   
	}
}
