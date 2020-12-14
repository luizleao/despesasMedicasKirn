<?php
class SicasCredenciamentoMAP {
    static function getMetaData($alias='sicas_credenciamento') {
		return array_merge([$alias => ['cd_credenciamento', 
                						'cd_credenciado', 
                						'dt_ini_credenciamento', 
                						'dt_fim_credenciamento', 
                						'status']],
		                  SicasCredenciadoMAP::getMetaData());
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

	static function objToRs($oSicasCredenciamento){
		$reg['cd_credenciamento'] = $oSicasCredenciamento->cd_credenciamento;
		$oSicasCredenciado = $oSicasCredenciamento->oSicasCredenciado;
		$reg['cd_credenciado'] = $oSicasCredenciado->cd_credenciado;
		$reg['dt_ini_credenciamento'] = $oSicasCredenciamento->dt_ini_credenciamento;
		$reg['dt_fim_credenciamento'] = $oSicasCredenciamento->dt_fim_credenciamento;
		$reg['status'] = $oSicasCredenciamento->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasCredenciamento){
		$oSicasCredenciado = $oSicasCredenciamento->oSicasCredenciado;
		$reg['cd_credenciado'] = $oSicasCredenciado->cd_credenciado;
		$reg['dt_ini_credenciamento'] = $oSicasCredenciamento->dt_ini_credenciamento;
		$reg['dt_fim_credenciamento'] = $oSicasCredenciamento->dt_fim_credenciamento;
		$reg['status'] = $oSicasCredenciamento->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasCredenciamento = new SicasCredenciamento();
		$oSicasCredenciamento->cd_credenciamento = $reg['sicas_credenciamento_cd_credenciamento'];

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
		$oSicasCredenciamento->oSicasCredenciado = $oSicasCredenciado;
		$oSicasCredenciamento->dt_ini_credenciamento = $reg['sicas_credenciamento_dt_ini_credenciamento'];
		$oSicasCredenciamento->dt_fim_credenciamento = $reg['sicas_credenciamento_dt_fim_credenciamento'];
		$oSicasCredenciamento->status = $reg['sicas_credenciamento_status'];
		return $oSicasCredenciamento;		   
	}
}
