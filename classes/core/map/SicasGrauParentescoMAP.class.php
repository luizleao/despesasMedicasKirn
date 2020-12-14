<?php
class SicasGrauParentescoMAP {
    static function getMetaData($alias='sicas_grau_parentesco'){
	    return [$alias => ['cd_grau_parentesco',
                	        'desc_grauparentesco',
                	        'nm_grau_parentesco',
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
	
	static function objToRs($oSicasGrauParentesco) {
		$reg['cd_grau_parentesco'] = $oSicasGrauParentesco->cd_grau_parentesco;
		$reg['desc_grauparentesco'] = $oSicasGrauParentesco->desc_grauparentesco;
		$reg['nm_grau_parentesco'] = $oSicasGrauParentesco->nm_grau_parentesco;
		$reg['status'] = $oSicasGrauParentesco->status;
		return $reg;
	}
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg[$campo] = $valor;
		}
		$oSicasGrauParentesco = new SicasGrauParentesco ();
		$oSicasGrauParentesco->cd_grau_parentesco = $reg['sicas_grau_parentesco_cd_grau_parentesco'];
		$oSicasGrauParentesco->desc_grauparentesco = $reg['sicas_grau_parentesco_desc_grauparentesco'];
		$oSicasGrauParentesco->nm_grau_parentesco = $reg['sicas_grau_parentesco_nm_grau_parentesco'];
		$oSicasGrauParentesco->status = $reg['sicas_grau_parentesco_status'];
		return $oSicasGrauParentesco;
	}
}
