<?php
class SicasTipoDespesaMAP {
	static function getMetaData($alias = 'sicas_tipo_despesa') {
	    return [$alias => ['cd_tipo_despesa', 'nm_despesa', 'credenciado', 'status']];
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

	static function objToRs($oSicasTipoDespesa){
		$reg['cd_tipo_despesa'] = $oSicasTipoDespesa->cd_tipo_despesa;
		$reg['nm_despesa'] = $oSicasTipoDespesa->nm_despesa;
		$reg['credenciado'] = $oSicasTipoDespesa->credenciado;
		$reg['status'] = $oSicasTipoDespesa->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasTipoDespesa){
		$reg['nm_despesa'] = $oSicasTipoDespesa->nm_despesa;
		$reg['credenciado'] = $oSicasTipoDespesa->credenciado;
		$reg['status'] = $oSicasTipoDespesa->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasTipoDespesa = new SicasTipoDespesa();
		$oSicasTipoDespesa->cd_tipo_despesa = $reg['sicas_tipo_despesa_cd_tipo_despesa'];
		$oSicasTipoDespesa->nm_despesa = $reg['sicas_tipo_despesa_nm_despesa'];
		$oSicasTipoDespesa->credenciado = $reg['sicas_tipo_despesa_credenciado'];
		$oSicasTipoDespesa->status = $reg['sicas_tipo_despesa_status'];
		return $oSicasTipoDespesa;		   
	}
}
