<?php
class SicasEstadoCivilMAP {
    static function getMetaData($alias='sicas_estado_civil') {
        return [$alias => ['cd_estado_civil', 'nm_estado_civil', 'status']];
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
	
	static function objToRs($oSicasEstadoCivil) {
		$reg ['cd_estado_civil'] = $oSicasEstadoCivil->cd_estado_civil;
		$reg ['nm_estado_civil'] = $oSicasEstadoCivil->nm_estado_civil;
		$reg ['status'] = $oSicasEstadoCivil->status;
		return $reg;
	}
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg [$campo] = $valor;
		}
		$oSicasEstadoCivil = new SicasEstadoCivil ();
		$oSicasEstadoCivil->cd_estado_civil = $reg ['sicas_estado_civil_cd_estado_civil'];
		$oSicasEstadoCivil->nm_estado_civil = $reg ['sicas_estado_civil_nm_estado_civil'];
		$oSicasEstadoCivil->status = $reg ['sicas_estado_civil_status'];
		return $oSicasEstadoCivil;
	}
}
