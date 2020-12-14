<?php
class SicasParamDescontoMAP {
    static function getMetaData($alias='sicas_param_desconto') {
		return [$alias => ['cd_param_desc', 'descricao_param', 'percentagem_desconto', 'status']];
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

	static function objToRs($oSicasParamDesconto){
		$reg['cd_param_desc'] = $oSicasParamDesconto->cd_param_desc;
		$reg['descricao_param'] = $oSicasParamDesconto->descricao_param;
		$reg['percentagem_desconto'] = $oSicasParamDesconto->percentagem_desconto;
		$reg['status'] = $oSicasParamDesconto->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasParamDesconto){
		$reg['descricao_param'] = $oSicasParamDesconto->descricao_param;
		$reg['percentagem_desconto'] = $oSicasParamDesconto->percentagem_desconto;
		$reg['status'] = $oSicasParamDesconto->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasParamDesconto = new SicasParamDesconto();
		$oSicasParamDesconto->cd_param_desc = $reg['sicas_param_desconto_cd_param_desc'];
		$oSicasParamDesconto->descricao_param = $reg['sicas_param_desconto_descricao_param'];
		$oSicasParamDesconto->percentagem_desconto = $reg['sicas_param_desconto_percentagem_desconto'];
		$oSicasParamDesconto->status = $reg['sicas_param_desconto_status'];
		return $oSicasParamDesconto;		   
	}
}
