<?php
class RhCargoMAP {
	static function getMetaData($alias='rh_cargo') {
	    return [$alias => ['cd_cargo',
                	        'descricao_cargo',
                	        'descricao_cargo_abrev',
                	        'num_siape_cargo',
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
	
	static function objToRs($oRhCargo) {
		$reg ['cd_cargo'] = $oRhCargo->cd_cargo;
		$reg ['descricao_cargo'] = $oRhCargo->descricao_cargo;
		$reg ['descricao_cargo_abrev'] = $oRhCargo->descricao_cargo_abrev;
		$reg ['num_siape_cargo'] = $oRhCargo->num_siape_cargo;
		$reg ['status'] = $oRhCargo->status;
		return $reg;
	}
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg [$campo] = $valor;
		}
		$oRhCargo = new RhCargo ();
		$oRhCargo->cd_cargo = $reg ['rh_cargo_cd_cargo'];
		$oRhCargo->descricao_cargo = $reg ['rh_cargo_descricao_cargo'];
		$oRhCargo->descricao_cargo_abrev = $reg ['rh_cargo_descricao_cargo_abrev'];
		$oRhCargo->num_siape_cargo = $reg ['rh_cargo_num_siape_cargo'];
		$oRhCargo->status = $reg ['rh_cargo_status'];
		return $oRhCargo;
	}
}
