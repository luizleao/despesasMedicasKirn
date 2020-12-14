<?php
class RhServidorRamalMAP {
	static function getMetaData() {
		return ['sicas_pessoa' => ['cd_pessoa', 'nm_pessoa', 'email', 'dt_nascimento', 'genero', 'cd_estado_civil', 'identidade', 'nm_orgao_emissor',
									'dt_emissao', 'cpf', 'endereco', 'complemento', 'bairro', 'cidade', 'uf', 'cep', 'telefone',
									'grupo_sanguineo', 'tipo_beneficiario', 'status', 'foto', 'cd_categoria', 'uf_identidade'],
				'sicas_servidor' => ['cd_servidor', 'cd_matricula', 'status', 'serv_efetivo', 'ramal1', 'ramal2', 'ramal3'],
				'sicas_lotacao' => ['cd_lotacao', 'sigla', 'cd_siged', 'nm_lotacao', 'status'],
				'rh_ramal' 		=> ['cd_ramal', 'ramal', 'descricao']];
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
		
	static function objToRs($oRhServidorRamal){
		$reg['cd_servidor'] = $oRhServidorRamal->oSicasServidor->cd_servidor;
		$reg['cd_ramal']   = $oRhServidorRamal->oRhRamal->cd_ramal;	
		return $reg;		   
	}

	static function objToRsInsert($oRhServidorRamal){
		$reg['cd_servidor'] = $oRhServidorRamal->oSicasServidor->cd_servidor;
		$reg['cd_ramal']   = $oRhServidorRamal->oRhRamal->cd_ramal;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oRhServidorRamal = new RhServidorRamal();

		$oSicasServidor = new SicasServidor();
		$oSicasServidor->cd_servidor  = $reg['sicas_servidor_cd_servidor'];
		$oSicasServidor->cd_matricula = $reg['sicas_servidor_cd_matricula'];
		$oSicasServidor->status 	  = $reg['sicas_servidor_status'];
		$oSicasServidor->serv_efetivo = $reg['sicas_servidor_serv_efetivo'];
		$oSicasServidor->ramal1 	  = $reg['sicas_servidor_ramal1'];
		$oSicasServidor->ramal2 	  = $reg['sicas_servidor_ramal2'];
		$oSicasServidor->ramal3 	  = $reg['sicas_servidor_ramal3'];
		
		$oSicasPessoa = new SicasPessoa();
		$oSicasPessoa->cd_pessoa 	 = $reg['sicas_pessoa_cd_pessoa'];
		$oSicasPessoa->nm_pessoa 	 = $reg['sicas_pessoa_nm_pessoa'];
		$oSicasPessoa->email 		 = $reg['sicas_pessoa_email'];
		$oSicasPessoa->dt_nascimento = $reg['sicas_pessoa_dt_nascimento'];
		$oSicasPessoa->genero 		 = $reg['sicas_pessoa_genero'];
		
		$oSicasServidor->oSicasPessoa = $oSicasPessoa;
		
		$oRhServidorRamal->oSicasServidor = $oSicasServidor;

		$oRhRamal = new RhRamal();
		$oRhRamal->cd_ramal 	  = $reg['rh_ramal_cd_ramal'];
		$oRhRamal->ramal 		  = $reg['rh_ramal_ramal'];
		$oRhRamal->descricao 	  = $reg['rh_ramal_descricao'];
		
		$oSicasLotacao = new SicasLotacao();
		$oSicasLotacao->cd_lotacao = $reg['sicas_lotacao_cd_lotacao'];
		$oSicasLotacao->cd_siged   = $reg['sicas_lotacao_cd_siged'];
		$oSicasLotacao->nm_lotacao = $reg['sicas_lotacao_nm_lotacao'];
		$oSicasLotacao->sigla 	   = $reg['sicas_lotacao_sigla'];
		$oSicasLotacao->status 	   = $reg['sicas_lotacao_status'];
		
		$oRhRamal->oSicasLotacao = $oSicasLotacao; 
		
		$oRhServidorRamal->oRhRamal = $oRhRamal;
		
		return $oRhServidorRamal;		 
	}
}
