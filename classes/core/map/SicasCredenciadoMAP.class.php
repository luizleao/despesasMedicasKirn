<?php
class SicasCredenciadoMAP {
    static function getMetaData($alias='sicas_credenciado') {
		return [$alias => ['cd_credenciado', 
                						'nm_credenciado', 
                						'dt_nascimento', 
                						'hora_atendimento', 
                						'nm_servicos', 
                						'profissional_liberal', 
                						'endereco', 
                						'complemento', 
                						'bairro', 
                						'cidade', 
                						'uf', 
                						'cep', 
                						'telefone1', 
                						'telefone2', 
                						'fax1', 
                						'ramal1', 
                						'tipo', 
                						'cd_pis_pasep', 
                						'cpf', 
                						'cgc', 
                						'guia_prev_social', 
                						'status']];
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

	static function objToRs($oSicasCredenciado){
		$reg['cd_credenciado'] = $oSicasCredenciado->cd_credenciado;
		$reg['nm_credenciado'] = $oSicasCredenciado->nm_credenciado;
		$reg['dt_nascimento'] = $oSicasCredenciado->dt_nascimento;
		$reg['hora_atendimento'] = $oSicasCredenciado->hora_atendimento;
		$reg['nm_servicos'] = $oSicasCredenciado->nm_servicos;
		$reg['profissional_liberal'] = $oSicasCredenciado->profissional_liberal;
		$reg['endereco'] = $oSicasCredenciado->endereco;
		$reg['complemento'] = $oSicasCredenciado->complemento;
		$reg['bairro'] = $oSicasCredenciado->bairro;
		$reg['cidade'] = $oSicasCredenciado->cidade;
		$reg['uf'] = $oSicasCredenciado->uf;
		$reg['cep'] = $oSicasCredenciado->cep;
		$reg['telefone1'] = $oSicasCredenciado->telefone1;
		$reg['telefone2'] = $oSicasCredenciado->telefone2;
		$reg['fax1'] = $oSicasCredenciado->fax1;
		$reg['ramal1'] = $oSicasCredenciado->ramal1;
		$reg['tipo'] = $oSicasCredenciado->tipo;
		$reg['cd_pis_pasep'] = $oSicasCredenciado->cd_pis_pasep;
		$reg['cpf'] = $oSicasCredenciado->cpf;
		$reg['cgc'] = $oSicasCredenciado->cgc;
		$reg['guia_prev_social'] = $oSicasCredenciado->guia_prev_social;
		$reg['status'] = $oSicasCredenciado->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasCredenciado){
		$reg['nm_credenciado'] = $oSicasCredenciado->nm_credenciado;
		$reg['dt_nascimento'] = $oSicasCredenciado->dt_nascimento;
		$reg['hora_atendimento'] = $oSicasCredenciado->hora_atendimento;
		$reg['nm_servicos'] = $oSicasCredenciado->nm_servicos;
		$reg['profissional_liberal'] = $oSicasCredenciado->profissional_liberal;
		$reg['endereco'] = $oSicasCredenciado->endereco;
		$reg['complemento'] = $oSicasCredenciado->complemento;
		$reg['bairro'] = $oSicasCredenciado->bairro;
		$reg['cidade'] = $oSicasCredenciado->cidade;
		$reg['uf'] = $oSicasCredenciado->uf;
		$reg['cep'] = $oSicasCredenciado->cep;
		$reg['telefone1'] = $oSicasCredenciado->telefone1;
		$reg['telefone2'] = $oSicasCredenciado->telefone2;
		$reg['fax1'] = $oSicasCredenciado->fax1;
		$reg['ramal1'] = $oSicasCredenciado->ramal1;
		$reg['tipo'] = $oSicasCredenciado->tipo;
		$reg['cd_pis_pasep'] = $oSicasCredenciado->cd_pis_pasep;
		$reg['cpf'] = $oSicasCredenciado->cpf;
		$reg['cgc'] = $oSicasCredenciado->cgc;
		$reg['guia_prev_social'] = $oSicasCredenciado->guia_prev_social;
		$reg['status'] = $oSicasCredenciado->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasCredenciado = new SicasCredenciado();
		$oSicasCredenciado->cd_credenciado = $reg['sicas_credenciado_cd_credenciado'];
		$oSicasCredenciado->nm_credenciado = $reg['sicas_credenciado_nm_credenciado'];
		$oSicasCredenciado->dt_nascimento = $reg['sicas_credenciado_dt_nascimento'];
		$oSicasCredenciado->hora_atendimento = $reg['sicas_credenciado_hora_atendimento'];
		$oSicasCredenciado->nm_servicos = $reg['sicas_credenciado_nm_servicos'];
		$oSicasCredenciado->profissional_liberal = $reg['sicas_credenciado_profissional_liberal'];
		$oSicasCredenciado->endereco = $reg['sicas_credenciado_endereco'];
		$oSicasCredenciado->complemento = $reg['sicas_credenciado_complemento'];
		$oSicasCredenciado->bairro = $reg['sicas_credenciado_bairro'];
		$oSicasCredenciado->cidade = $reg['sicas_credenciado_cidade'];
		$oSicasCredenciado->uf = $reg['sicas_credenciado_uf'];
		$oSicasCredenciado->cep = $reg['sicas_credenciado_cep'];
		$oSicasCredenciado->telefone1 = $reg['sicas_credenciado_telefone1'];
		$oSicasCredenciado->telefone2 = $reg['sicas_credenciado_telefone2'];
		$oSicasCredenciado->fax1 = $reg['sicas_credenciado_fax1'];
		$oSicasCredenciado->ramal1 = $reg['sicas_credenciado_ramal1'];
		$oSicasCredenciado->tipo = $reg['sicas_credenciado_tipo'];
		$oSicasCredenciado->cd_pis_pasep = $reg['sicas_credenciado_cd_pis_pasep'];
		$oSicasCredenciado->cpf = $reg['sicas_credenciado_cpf'];
		$oSicasCredenciado->cgc = $reg['sicas_credenciado_cgc'];
		$oSicasCredenciado->guia_prev_social = $reg['sicas_credenciado_guia_prev_social'];
		$oSicasCredenciado->status = $reg['sicas_credenciado_status'];
		return $oSicasCredenciado;		   
	}
}
