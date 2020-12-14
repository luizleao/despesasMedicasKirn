<?php
class SicasParamFaixaSalarialMAP {
	static function getMetaData($alias='sicas_param_faixa_salarial') {
		return [$alias => ['cd_param_faixa_sal', 'val_faixa_inicial', 'flg_faixa_ini_inclusive', 
    					   'val_faixa_final', 'flg_faixa_fin_inclusive', 
    					   'percentagem_desconto', 'status', 'servidor_efetivo']];
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

	static function objToRs($oSicasParamFaixaSalarial){
		$reg['cd_param_faixa_sal'] = $oSicasParamFaixaSalarial->cd_param_faixa_sal;
		$reg['val_faixa_inicial'] = $oSicasParamFaixaSalarial->val_faixa_inicial;
		$reg['flg_faixa_ini_inclusive'] = $oSicasParamFaixaSalarial->flg_faixa_ini_inclusive;
		$reg['val_faixa_final'] = $oSicasParamFaixaSalarial->val_faixa_final;
		$reg['flg_faixa_fin_inclusive'] = $oSicasParamFaixaSalarial->flg_faixa_fin_inclusive;
		$reg['percentagem_desconto'] = $oSicasParamFaixaSalarial->percentagem_desconto;
		$reg['status'] = $oSicasParamFaixaSalarial->status;
		$reg['servidor_efetivo'] = $oSicasParamFaixaSalarial->servidor_efetivo;
		return $reg;		   
	}

	static function objToRsInsert($oSicasParamFaixaSalarial){
		$reg['val_faixa_inicial'] = $oSicasParamFaixaSalarial->val_faixa_inicial;
		$reg['flg_faixa_ini_inclusive'] = $oSicasParamFaixaSalarial->flg_faixa_ini_inclusive;
		$reg['val_faixa_final'] = $oSicasParamFaixaSalarial->val_faixa_final;
		$reg['flg_faixa_fin_inclusive'] = $oSicasParamFaixaSalarial->flg_faixa_fin_inclusive;
		$reg['percentagem_desconto'] = $oSicasParamFaixaSalarial->percentagem_desconto;
		$reg['status'] = $oSicasParamFaixaSalarial->status;
		$reg['servidor_efetivo'] = $oSicasParamFaixaSalarial->servidor_efetivo;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasParamFaixaSalarial = new SicasParamFaixaSalarial();
		$oSicasParamFaixaSalarial->cd_param_faixa_sal = $reg['sicas_param_faixa_salarial_cd_param_faixa_sal'];
		$oSicasParamFaixaSalarial->val_faixa_inicial = $reg['sicas_param_faixa_salarial_val_faixa_inicial'];
		$oSicasParamFaixaSalarial->flg_faixa_ini_inclusive = $reg['sicas_param_faixa_salarial_flg_faixa_ini_inclusive'];
		$oSicasParamFaixaSalarial->val_faixa_final = $reg['sicas_param_faixa_salarial_val_faixa_final'];
		$oSicasParamFaixaSalarial->flg_faixa_fin_inclusive = $reg['sicas_param_faixa_salarial_flg_faixa_fin_inclusive'];
		$oSicasParamFaixaSalarial->percentagem_desconto = $reg['sicas_param_faixa_salarial_percentagem_desconto'];
		$oSicasParamFaixaSalarial->status = $reg['sicas_param_faixa_salarial_status'];
		$oSicasParamFaixaSalarial->servidor_efetivo = $reg['sicas_param_faixa_salarial_servidor_efetivo'];
		return $oSicasParamFaixaSalarial;		   
	}
}
