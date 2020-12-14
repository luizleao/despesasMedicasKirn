<?php
class SicasFaturaMAP {
	static function getMetaData() {
		return ['sicas_fatura' => ['cd_fatura', 
            						'cd_credenciado', 
            						'num_fatura', 
            						'dt_cadastro',
            		                'vl_fatura',
            						'status',
		                            'mes_ano_lancamento'], 
				'sicas_credenciado' => ['cd_credenciado', 
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

	static function objToRs($oSicasFatura){
		$reg['cd_fatura'] = $oSicasFatura->cd_fatura;
		$oSicasCredenciado = $oSicasFatura->oSicasCredenciado;
		$reg['cd_credenciado'] = $oSicasCredenciado->cd_credenciado;
		$reg['num_fatura'] = $oSicasFatura->num_fatura;
		$reg['dt_cadastro'] = $oSicasFatura->dt_cadastro;
		$reg['vl_fatura'] = $oSicasFatura->vl_fatura;
		$reg['status'] = $oSicasFatura->status;
		$reg['mes_ano_lancamento'] = $oSicasFatura->mes_ano_lancamento;
		return $reg;		   
	}

	static function objToRsInsert($oSicasFatura){
		$oSicasCredenciado = $oSicasFatura->oSicasCredenciado;
		$reg['cd_credenciado'] = $oSicasCredenciado->cd_credenciado;
		$reg['num_fatura'] = $oSicasFatura->num_fatura;
		$reg['dt_cadastro'] = $oSicasFatura->dt_cadastro;
		$reg['vl_fatura'] = $oSicasFatura->vl_fatura;
		$reg['status'] = $oSicasFatura->status;
		$reg['mes_ano_lancamento'] = $oSicasFatura->mes_ano_lancamento;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasFatura = new SicasFatura();
		$oSicasFatura->cd_fatura = $reg['sicas_fatura_cd_fatura'];

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
		$oSicasFatura->oSicasCredenciado = $oSicasCredenciado;
		$oSicasFatura->num_fatura = $reg['sicas_fatura_num_fatura'];
		$oSicasFatura->dt_cadastro = $reg['sicas_fatura_dt_cadastro'];
		$oSicasFatura->vl_fatura = $reg['sicas_fatura_vl_fatura'];
		$oSicasFatura->status = $reg['sicas_fatura_status'];
		$oSicasFatura->mes_ano_lancamento = $reg['sicas_fatura_mes_ano_lancamento'];
		return $oSicasFatura;		   
	}
}
