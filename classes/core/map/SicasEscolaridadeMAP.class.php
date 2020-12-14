<?php
class SicasEscolaridadeMAP {
    static function getMetaData($alias='sicas_escolaridade') {
	    return [$alias => ['cd_escolaridade', 'nm_escolaridade', 'status']];
		
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
	
	static function objToRs($oSicasEscolaridade){
		$reg['cd_escolaridade'] = $oSicasEscolaridade->cd_escolaridade;
		$reg['nm_escolaridade'] = $oSicasEscolaridade->nm_escolaridade;
		$reg['status']          = $oSicasEscolaridade->status;
		return $reg;
	}
	
	static function objToRsInsert($oSicasEscolaridade){
	    $reg['nm_escolaridade'] = $oSicasEscolaridade->nm_escolaridade;
	    $reg['status']          = $oSicasEscolaridade->status;
	    return $reg;
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo => $valor){
			$reg[$campo] = $valor;
		}
		$oSicasEscolaridade = new SicasEscolaridade ();
		$oSicasEscolaridade->cd_escolaridade = $reg['sicas_escolaridade_cd_escolaridade'];
		$oSicasEscolaridade->nm_escolaridade = $reg['sicas_escolaridade_nm_escolaridade'];
		$oSicasEscolaridade->status = $reg['sicas_escolaridade_status'];
		return $oSicasEscolaridade;
	}
}
