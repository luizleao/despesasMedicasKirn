<?php
class SicasEspecialidadeMedicaMAP{
    static function getMetaData($alias='sicas_especialidade_medica'){
	    return [$alias => ['cd_especialidade_medica', 'nm_especialidade', 'status']];
	}
	
	static function dataToSelect(){
		foreach(self::getMetaData() as $tabela => $aCampo){
			foreach($aCampo as $sCampo){
				$aux[] = "$tabela.$sCampo as $tabela"."_$sCampo";
			}
		}
	
		return implode(",\n", $aux);
	}
	
	static function filterLike($valor){
		foreach(self::getMetaData() as $tabela => $aCampo){
			foreach($aCampo as $sCampo){
				$aux[] = "$tabela.$sCampo like '$valor'";
			}
		}
	
		return implode("\nor ", $aux);
	}
	
	static function objToRsInsert($oSicasEspecialidadeMedica){
		$reg['nm_especialidade'] = $oSicasEspecialidadeMedica->nm_especialidade;
		$reg['status'] = $oSicasEspecialidadeMedica->status;
		return $reg;
	}
	
	static function objToRs($oSicasEspecialidadeMedica){
	    $reg['cd_especialidade_medica'] = $oSicasEspecialidadeMedica->cd_especialidade_medica;
	    $reg['nm_especialidade'] = $oSicasEspecialidadeMedica->nm_especialidade;
	    $reg['status'] = $oSicasEspecialidadeMedica->status;
	    return $reg;
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo => $valor){
			$reg[$campo] = $valor;
		}
		$oSicasEspecialidadeMedica = new SicasEspecialidadeMedica ();
		$oSicasEspecialidadeMedica->cd_especialidade_medica = $reg['sicas_especialidade_medica_cd_especialidade_medica'];
		$oSicasEspecialidadeMedica->nm_especialidade = $reg['sicas_especialidade_medica_nm_especialidade'];
		$oSicasEspecialidadeMedica->status = $reg['sicas_especialidade_medica_status'];
		return $oSicasEspecialidadeMedica;
	}
}
