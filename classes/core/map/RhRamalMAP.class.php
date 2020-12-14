<?php
class RhRamalMAP {
    static function getMetaData($alias='rh_ramal'){
	    return [$alias => ['cd_ramal', 'cd_lotacao', 
	                       'ramal', 'descricao']];
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
	
	static function objToRs($oRhRamal){
		$reg['cd_ramal']   = $oRhRamal->cd_ramal;
		$oSicasLotacao 	   = $oRhRamal->oSicasLotacao;
		$reg['cd_lotacao'] = $oSicasLotacao->cd_lotacao;
		$reg['ramal'] 	   = $oRhRamal->ramal;
		$reg['descricao']  = $oRhRamal->descricao;
		
		foreach($reg as $campo=>$valor){
			$reg[$campo] = utf8_encode($valor);
		}
		
		return $reg;		   
	}

	static function objToRsInsert($oRhRamal){
		$reg['cd_lotacao'] = $oRhRamal->oSicasLotacao->cd_lotacao;
		$reg['ramal'] 	   = $oRhRamal->ramal;
		$reg['descricao']  = $oRhRamal->descricao;
		
		foreach($reg as $campo=>$valor){
			$reg[$campo] = utf8_encode($valor);
		}
		
		return $reg;		   
	}
	
	static function rsToObj($reg){
		$oRhRamal = new RhRamal();
		$oRhRamal->cd_ramal = $reg['rh_ramal_cd_ramal'];

		$oSicasLotacao = new SicasLotacao();
		$oSicasLotacao->cd_lotacao = $reg['sicas_lotacao_cd_lotacao'];
		$oSicasLotacao->sigla	   = $reg['sicas_lotacao_sigla'];
		$oSicasLotacao->cd_siged   = $reg['sicas_lotacao_cd_siged'];
		$oSicasLotacao->nm_lotacao = $reg['sicas_lotacao_nm_lotacao'];
		$oSicasLotacao->status	   = $reg['sicas_lotacao_status'];
		$oRhRamal->oSicasLotacao   = $oSicasLotacao;
		$oRhRamal->ramal 	  	   = $reg['rh_ramal_ramal'];
		$oRhRamal->descricao  	   = $reg['rh_ramal_descricao'];
		return $oRhRamal;		   
	}
}
