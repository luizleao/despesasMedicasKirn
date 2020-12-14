<?php
class RhFeriadoMAP {
    static function getMetaData($alias='rh_feriado'){
	    return [$alias => ['cd_feriado',
                    	   'data_feriado',
                    	   'descricao_feriado',
                    	   'esfera_feriado']];
	}
	
	static function dataToSelect(){
		foreach(self::getMetaData()as $tabela => $aCampo){
			foreach($aCampo as $sCampo){
				$aux[] = "$tabela.$sCampo as $tabela"."_$sCampo";
			}
		}
	
		return implode(",\n", $aux);
	}
	
	static function filterLike($valor){
		foreach(self::getMetaData()as $tabela => $aCampo){
			foreach($aCampo as $sCampo){
				$aux[] = "$tabela.$sCampo like '$valor'";
			}
		}
	
		return implode("\nor ", $aux);
	}
	
	static function objToRs($oRhFeriado){
		$reg['cd_feriado'] = $oRhFeriado->cd_feriado;
		$reg['data_feriado'] = $oRhFeriado->data_feriado;
		$reg['descricao_feriado'] = $oRhFeriado->descricao_feriado;
		$reg['esfera_feriado'] = $oRhFeriado->esfera_feriado;
		return $reg;
	}
	static function objToRsInsert($oRhFeriado){
		$reg['data_feriado'] = $oRhFeriado->data_feriado;
		$reg['descricao_feriado'] = $oRhFeriado->descricao_feriado;
		$reg['esfera_feriado'] = $oRhFeriado->esfera_feriado;
		return $reg;
	}
	static function rsToObj($reg){
		foreach($reg as $campo => $valor){
			$reg[$campo] = $valor;
		}
		$oRhFeriado = new RhFeriado();
		$oRhFeriado->cd_feriado = $reg['rh_feriado_cd_feriado'];
		$oRhFeriado->data_feriado = $reg['rh_feriado_data_feriado'];
		$oRhFeriado->descricao_feriado = $reg['rh_feriado_descricao_feriado'];
		$oRhFeriado->esfera_feriado = $reg['rh_feriado_esfera_feriado'];
		return $oRhFeriado;
	}
}
