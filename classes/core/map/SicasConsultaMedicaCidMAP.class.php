<?php
class SicasConsultaMedicaCidMAP {
    static function getMetaData($alias='sicas_consulta_medica_cid') {
		return array_merge([$alias => ['cd_cid', 
	                                   'cd_consulta_medica']], 
                			SicasCidMAP::getMetaData(),
		                    SicasConsultaMedicaMAP::getMetaData());
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

	static function objToRs($oSicasConsultaMedicaCid){
		$oSicasCid = $oSicasConsultaMedicaCid->oSicasCid;
		$reg['cd_cid'] = $oSicasCid->cd_cid;
		$reg['cd_consulta_medica'] = $oSicasConsultaMedicaCid->cd_consulta_medica;
		return $reg;		   
	}

	static function objToRsInsert($oSicasConsultaMedicaCid){
		$oSicasCid = $oSicasConsultaMedicaCid->oSicasCid;
		$reg['cd_cid'] = $oSicasCid->cd_cid;
		$reg['cd_consulta_medica'] = $oSicasConsultaMedicaCid->cd_consulta_medica;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasConsultaMedicaCid = new SicasConsultaMedicaCid();

		$oSicasCid = new SicasCid();
		$oSicasCid->cd_cid = $reg['sicas_cid_cd_cid'];
		$oSicasCid->desc_cid = $reg['sicas_cid_desc_cid'];
		$oSicasCid->desc_cid_abrev = $reg['sicas_cid_desc_cid_abrev'];
		$oSicasConsultaMedicaCid->oSicasCid = $oSicasCid;
		$oSicasConsultaMedicaCid->cd_consulta_medica = $reg['sicas_consulta_medica_cid_cd_consulta_medica'];
		return $oSicasConsultaMedicaCid;		   
	}
}
