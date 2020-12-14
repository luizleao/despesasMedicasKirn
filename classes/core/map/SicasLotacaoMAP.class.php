<?php
class SicasLotacaoMAP {
    static function getMetaData($alias='sicas_lotacao'){
	    return [$alias => ['cd_lotacao', 
	                                'sigla', 
                        	        'cd_siged', 
                        	        'nm_lotacao', 
                        	        'status', 
                        	        'cd_lotacao_pai'],
    	        'lotacao_pai' => ['cd_lotacao',
                    	            'sigla',
                    	            'cd_siged',
                    	            'nm_lotacao',
                    	            'status',
                    	            'cd_lotacao_pai']];
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
	
	static function objToRsInsert($oSicasLotacao) {
		$reg['sigla'] 		    = $oSicasLotacao->sigla;
		$reg['cd_siged'] 	    = $oSicasLotacao->cd_siged;
		$reg['nm_lotacao'] 	    = $oSicasLotacao->nm_lotacao;
		$reg['status']          = $oSicasLotacao->status;
		$reg['cd_lotacao_pai']	= $oSicasLotacao->oSicasLotacao->cd_lotacao;
		return $reg;
	}
	
	static function objToRs($oSicasLotacao) {
		$reg['cd_lotacao'] 	   = $oSicasLotacao->cd_lotacao;
		$reg['sigla'] 		   = $oSicasLotacao->sigla;
		$reg['cd_siged'] 	   = $oSicasLotacao->cd_siged;
		$reg['nm_lotacao'] 	   = $oSicasLotacao->nm_lotacao;
		$reg['status'] 		   = $oSicasLotacao->status;
		$reg['cd_lotacao_pai'] = $oSicasLotacao->oSicasLotacao->cd_lotacao;
		return $reg;
	}
	
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg[$campo] = $valor;
		}
		$oSicasLotacao = new SicasLotacao();
		$oSicasLotacao->cd_lotacao = $reg['sicas_lotacao_cd_lotacao'];
		$oSicasLotacao->sigla      = $reg['sicas_lotacao_sigla'];
		$oSicasLotacao->cd_siged   = $reg['sicas_lotacao_cd_siged'];
		$oSicasLotacao->nm_lotacao = $reg['sicas_lotacao_nm_lotacao'];
		$oSicasLotacao->status     = $reg['sicas_lotacao_status'];
		
		$oSicasLotacaoPai = new SicasLotacao();
		$oSicasLotacaoPai->cd_lotacao = $reg['lotacao_pai_cd_lotacao'];
		$oSicasLotacaoPai->sigla      = $reg['lotacao_pai_sigla'];
		$oSicasLotacaoPai->cd_siged   = $reg['lotacao_pai_cd_siged'];
		$oSicasLotacaoPai->nm_lotacao = $reg['lotacao_pai_nm_lotacao'];
		$oSicasLotacaoPai->status     = $reg['lotacao_pai_status'];
		
		$oSicasLotacao->oSicasLotacao = $oSicasLotacaoPai;
		return $oSicasLotacao;
	}
}
