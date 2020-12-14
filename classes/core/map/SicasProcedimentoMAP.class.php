<?php
class SicasProcedimentoMAP {
    static function getMetaData($alias='sicas_procedimento') {
		return [$alias => ['cd_procedimento', 'num_procedimento', 'nm_procedimento', 
    					   'num_custo_operacional', 'num_honorario', 'num_med_filme', 'num_auxiliares', 
		                   'num_port_anest', 'sigla', 'red_registro', 'status']];
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

	static function objToRs($oSicasProcedimento){
		$reg['cd_procedimento'] = $oSicasProcedimento->cd_procedimento;
		$reg['num_procedimento'] = $oSicasProcedimento->num_procedimento;
		$reg['nm_procedimento'] = $oSicasProcedimento->nm_procedimento;
		$reg['num_custo_operacional'] = $oSicasProcedimento->num_custo_operacional;
		$reg['num_honorario'] = $oSicasProcedimento->num_honorario;
		$reg['num_med_filme'] = $oSicasProcedimento->num_med_filme;
		$reg['num_auxiliares'] = $oSicasProcedimento->num_auxiliares;
		$reg['num_port_anest'] = $oSicasProcedimento->num_port_anest;
		$reg['sigla'] = $oSicasProcedimento->sigla;
		$reg['red_registro'] = $oSicasProcedimento->red_registro;
		$reg['status'] = $oSicasProcedimento->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasProcedimento){
		$reg['num_procedimento'] = $oSicasProcedimento->num_procedimento;
		$reg['nm_procedimento'] = $oSicasProcedimento->nm_procedimento;
		$reg['num_custo_operacional'] = $oSicasProcedimento->num_custo_operacional;
		$reg['num_honorario'] = $oSicasProcedimento->num_honorario;
		$reg['num_med_filme'] = $oSicasProcedimento->num_med_filme;
		$reg['num_auxiliares'] = $oSicasProcedimento->num_auxiliares;
		$reg['num_port_anest'] = $oSicasProcedimento->num_port_anest;
		$reg['sigla'] = $oSicasProcedimento->sigla;
		$reg['red_registro'] = $oSicasProcedimento->red_registro;
		$reg['status'] = $oSicasProcedimento->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasProcedimento = new SicasProcedimento();
		$oSicasProcedimento->cd_procedimento = $reg['sicas_procedimento_cd_procedimento'];
		$oSicasProcedimento->num_procedimento = $reg['sicas_procedimento_num_procedimento'];
		$oSicasProcedimento->nm_procedimento = $reg['sicas_procedimento_nm_procedimento'];
		$oSicasProcedimento->num_custo_operacional = $reg['sicas_procedimento_num_custo_operacional'];
		$oSicasProcedimento->num_honorario = $reg['sicas_procedimento_num_honorario'];
		$oSicasProcedimento->num_med_filme = $reg['sicas_procedimento_num_med_filme'];
		$oSicasProcedimento->num_auxiliares = $reg['sicas_procedimento_num_auxiliares'];
		$oSicasProcedimento->num_port_anest = $reg['sicas_procedimento_num_port_anest'];
		$oSicasProcedimento->sigla = $reg['sicas_procedimento_sigla'];
		$oSicasProcedimento->red_registro = $reg['sicas_procedimento_red_registro'];
		$oSicasProcedimento->status = $reg['sicas_procedimento_status'];
		return $oSicasProcedimento;		   
	}
}
