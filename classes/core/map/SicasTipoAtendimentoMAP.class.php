<?php
class SicasTipoAtendimentoMAP {
    static function getMetaData($alias='sicas_tipo_atendimento') {
		return [$alias => ['cd_tipo_atendimento', 'nm_tipo_atendimento', 'fl_atendimento', 'pericia', 'status']];
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

	static function objToRs($oSicasTipoAtendimento){
		$reg['cd_tipo_atendimento'] = $oSicasTipoAtendimento->cd_tipo_atendimento;
		$reg['nm_tipo_atendimento'] = $oSicasTipoAtendimento->nm_tipo_atendimento;
		$reg['fl_atendimento'] = $oSicasTipoAtendimento->fl_atendimento;
		$reg['pericia'] = $oSicasTipoAtendimento->pericia;
		$reg['status'] = $oSicasTipoAtendimento->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasTipoAtendimento){
		$reg['nm_tipo_atendimento'] = $oSicasTipoAtendimento->nm_tipo_atendimento;
		$reg['fl_atendimento'] = $oSicasTipoAtendimento->fl_atendimento;
		$reg['pericia'] = $oSicasTipoAtendimento->pericia;
		$reg['status'] = $oSicasTipoAtendimento->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasTipoAtendimento = new SicasTipoAtendimento();
		$oSicasTipoAtendimento->cd_tipo_atendimento = $reg['sicas_tipo_atendimento_cd_tipo_atendimento'];
		$oSicasTipoAtendimento->nm_tipo_atendimento = $reg['sicas_tipo_atendimento_nm_tipo_atendimento'];
		$oSicasTipoAtendimento->fl_atendimento = $reg['sicas_tipo_atendimento_fl_atendimento'];
		$oSicasTipoAtendimento->pericia = $reg['sicas_tipo_atendimento_pericia'];
		$oSicasTipoAtendimento->status = $reg['sicas_tipo_atendimento_status'];
		return $oSicasTipoAtendimento;		   
	}
}
