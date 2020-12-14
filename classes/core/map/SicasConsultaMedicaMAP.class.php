<?php
class SicasConsultaMedicaMAP {
    static function getMetaData($alias='sicas_consulta_medica') {
	    return array_merge([$alias => ['cd_consulta_medica', 
                    						'cd_atendimento', 
                    						'dt_consulta', 
                    						'cd_medico', 
                    						'qp_paciente', 
                    						'exame_fisico', 
                    						'exame_solicitado', 
                    						'diag_paciente', 
                    						'cd_tipo_atendimento', 
                    						'resultado', 
                    						'tratamento', 
                    						'status']],  
		    SicasAtendimentoMAP::getMetaData(), 
	        SicasMedicoMAP::getMetaData(), 
	        SicasTipoAtendimentoMAP::getMetaData());
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

	static function objToRs($oSicasConsultaMedica){
		$reg['cd_consulta_medica'] = $oSicasConsultaMedica->cd_consulta_medica;
		$oSicasAtendimento = $oSicasConsultaMedica->oSicasAtendimento;
		$reg['cd_atendimento'] = $oSicasAtendimento->cd_atendimento;
		$reg['dt_consulta'] = $oSicasConsultaMedica->dt_consulta;
		$oSicasMedico = $oSicasConsultaMedica->oSicasMedico;
		$reg['cd_medico'] = $oSicasMedico->cd_medico;
		$reg['qp_paciente'] = $oSicasConsultaMedica->qp_paciente;
		$reg['exame_fisico'] = $oSicasConsultaMedica->exame_fisico;
		$reg['exame_solicitado'] = $oSicasConsultaMedica->exame_solicitado;
		$reg['diag_paciente'] = $oSicasConsultaMedica->diag_paciente;
		$oSicasTipoAtendimento = $oSicasConsultaMedica->oSicasTipoAtendimento;
		$reg['cd_tipo_atendimento'] = $oSicasTipoAtendimento->cd_tipo_atendimento;
		$reg['resultado'] = $oSicasConsultaMedica->resultado;
		$reg['tratamento'] = $oSicasConsultaMedica->tratamento;
		$reg['status'] = $oSicasConsultaMedica->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasConsultaMedica){
		$oSicasAtendimento = $oSicasConsultaMedica->oSicasAtendimento;
		$reg['cd_atendimento'] = $oSicasAtendimento->cd_atendimento;
		$reg['dt_consulta'] = $oSicasConsultaMedica->dt_consulta;
		$oSicasMedico = $oSicasConsultaMedica->oSicasMedico;
		$reg['cd_medico'] = $oSicasMedico->cd_medico;
		$reg['qp_paciente'] = $oSicasConsultaMedica->qp_paciente;
		$reg['exame_fisico'] = $oSicasConsultaMedica->exame_fisico;
		$reg['exame_solicitado'] = $oSicasConsultaMedica->exame_solicitado;
		$reg['diag_paciente'] = $oSicasConsultaMedica->diag_paciente;
		$oSicasTipoAtendimento = $oSicasConsultaMedica->oSicasTipoAtendimento;
		$reg['cd_tipo_atendimento'] = $oSicasTipoAtendimento->cd_tipo_atendimento;
		$reg['resultado'] = $oSicasConsultaMedica->resultado;
		$reg['tratamento'] = $oSicasConsultaMedica->tratamento;
		$reg['status'] = $oSicasConsultaMedica->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasConsultaMedica = new SicasConsultaMedica();
		$oSicasConsultaMedica->cd_consulta_medica = $reg['sicas_consulta_medica_cd_consulta_medica'];

		$oSicasAtendimento = new SicasAtendimento();
		$oSicasAtendimento->cd_atendimento = $reg['sicas_atendimento_cd_atendimento'];
		$oSicasAtendimento->dt_fim_atendimento = $reg['sicas_atendimento_dt_fim_atendimento'];
		$oSicasAtendimento->dt_ini_atendimento = $reg['sicas_atendimento_dt_ini_atendimento'];
		$oSicasAtendimento->oSicasMedico = new SicasMedico();
		$oSicasAtendimento->oSicasPessoa = new SicasPessoa();
		$oSicasAtendimento->status = $reg['sicas_atendimento_status'];
		$oSicasConsultaMedica->oSicasAtendimento = $oSicasAtendimento;
		$oSicasConsultaMedica->dt_consulta = $reg['sicas_consulta_medica_dt_consulta'];

		$oSicasMedico = new SicasMedico();
		$oSicasMedico->cd_medico = $reg['sicas_medico_cd_medico'];
		$oSicasMedico->login = $reg['sicas_medico_login'];
		$oSicasMedico->status = $reg['sicas_medico_status'];
		$oSicasMedico->crm = $reg['sicas_medico_crm'];
		$oSicasConsultaMedica->oSicasMedico = $oSicasMedico;
		$oSicasConsultaMedica->qp_paciente = $reg['sicas_consulta_medica_qp_paciente'];
		$oSicasConsultaMedica->exame_fisico = $reg['sicas_consulta_medica_exame_fisico'];
		$oSicasConsultaMedica->exame_solicitado = $reg['sicas_consulta_medica_exame_solicitado'];
		$oSicasConsultaMedica->diag_paciente = $reg['sicas_consulta_medica_diag_paciente'];

		$oSicasTipoAtendimento = new SicasTipoAtendimento();
		$oSicasTipoAtendimento->cd_tipo_atendimento = $reg['sicas_tipo_atendimento_cd_tipo_atendimento'];
		$oSicasTipoAtendimento->nm_tipo_atendimento = $reg['sicas_tipo_atendimento_nm_tipo_atendimento'];
		$oSicasTipoAtendimento->fl_atendimento = $reg['sicas_tipo_atendimento_fl_atendimento'];
		$oSicasTipoAtendimento->pericia = $reg['sicas_tipo_atendimento_pericia'];
		$oSicasTipoAtendimento->status = $reg['sicas_tipo_atendimento_status'];
		$oSicasConsultaMedica->oSicasTipoAtendimento = $oSicasTipoAtendimento;
		$oSicasConsultaMedica->resultado = $reg['sicas_consulta_medica_resultado'];
		$oSicasConsultaMedica->tratamento = $reg['sicas_consulta_medica_tratamento'];
		$oSicasConsultaMedica->status = $reg['sicas_consulta_medica_status'];
		return $oSicasConsultaMedica;		   
	}
}
