<?php
class SicasSalarioMinimoMAP {
    static function getMetaData($alias='sicas_salario_minimo') {
		return [$alias => ['cd_salario_minimo', 
    						'valor', 
    						'dt_cadastro', 
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

	static function objToRs($oSicasSalarioMinimo){
		$reg['cd_salario_minimo'] = $oSicasSalarioMinimo->cd_salario_minimo;
		$reg['valor'] = $oSicasSalarioMinimo->valor;
		$reg['dt_cadastro'] = $oSicasSalarioMinimo->dt_cadastro;
		$reg['status'] = $oSicasSalarioMinimo->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasSalarioMinimo){
		$reg['valor'] = $oSicasSalarioMinimo->valor;
		$reg['dt_cadastro'] = $oSicasSalarioMinimo->dt_cadastro;
		$reg['status'] = $oSicasSalarioMinimo->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasSalarioMinimo = new SicasSalarioMinimo();
		$oSicasSalarioMinimo->cd_salario_minimo = $reg['sicas_salario_minimo_cd_salario_minimo'];
		$oSicasSalarioMinimo->valor = $reg['sicas_salario_minimo_valor'];
		$oSicasSalarioMinimo->dt_cadastro = $reg['sicas_salario_minimo_dt_cadastro'];
		$oSicasSalarioMinimo->status = $reg['sicas_salario_minimo_status'];
		return $oSicasSalarioMinimo;		   
	}
}
