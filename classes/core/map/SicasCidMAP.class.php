<?php
class SicasCidMAP {
    static function getMetaData($alias='sicas_cid') {
		return [$alias => ['cd_cid', 
        				   'desc_cid', 
        				   'desc_cid_abrev', 
        				   'cd_cid_pai'], 
		     'cid_pai' => ['cd_cid',
        		           'desc_cid',
        		           'desc_cid_abrev',
        		           'cd_cid_pai']
		];
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

	static function objToRs($oSicasCid){
		$reg['cd_cid'] = $oSicasCid->cd_cid;
		$reg['desc_cid'] = $oSicasCid->desc_cid;
		$reg['desc_cid_abrev'] = $oSicasCid->desc_cid_abrev;
		$oSicasCid = $oSicasCid->oSicasCid;
		$reg['cd_cid_pai'] = $oSicasCid->cd_cid;
		return $reg;		   
	}

	static function objToRsInsert($oSicasCid){
		$reg['desc_cid'] = $oSicasCid->desc_cid;
		$reg['desc_cid_abrev'] = $oSicasCid->desc_cid_abrev;
		$oSicasCid = $oSicasCid->oSicasCid;
		$reg['cd_cid_pai'] = $oSicasCid->cd_cid;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasCid = new SicasCid();
		$oSicasCid->cd_cid = $reg['sicas_cid_cd_cid'];
		$oSicasCid->desc_cid = $reg['sicas_cid_desc_cid'];
		$oSicasCid->desc_cid_abrev = $reg['sicas_cid_desc_cid_abrev'];

		$oCidPai = new SicasCid();
		$oCidPai->cd_cid = $reg['cid_pai_cd_cid'];
		$oCidPai->desc_cid = $reg['cid_pai_desc_cid'];
		$oCidPai->desc_cid_abrev = $reg['cid_pai_desc_cid_abrev'];
		$oSicasCid->oSicasCid = $oCidPai;
		return $oSicasCid;		   
	}
}
