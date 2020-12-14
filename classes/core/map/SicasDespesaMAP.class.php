<?php
class SicasDespesaMAP {
    static function getMetaData() {
        return ['sicas_despesa' => ['cd_despesa', 
                						'cd_procedimento_autorizado', 
                						'cd_salario', 
                						'qtd_servico_realizado', 
                						'val_servico_realizado', 
                						'dt_atendimento', 
                						'dt_cadastro', 
                						'desconto_servidor',
		                                'mes_ano_desconto',
                						'status'],
		    'sicas_procedimento_autorizado' => ['cd_procedimento_autorizado',
                                		        'cd_encaminhamento',
                                		        'cd_procedimento',
                                		        'qtd_servico_autorizado',
                                		        'status'],
            'sicas_salario' => ['cd_salario',
                                'cd_servidor',
                                'val_salario',
                                'dt_ini_salario',
                                'dt_fim_salario',
                                'serv_efetivo',
                                'obs',
                                'status'],
            'sicas_fatura' => ['cd_fatura',
                                'cd_credenciado',
                                'num_fatura',
                                'dt_cadastro',
                                'vl_fatura',
                                'status',
                                'mes_ano_lancamento'],
            'sicas_servidor' => ['cd_servidor', 
                                 'cd_matricula', 
                                 'serv_efetivo', 
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

	static function objToRs($oSicasDespesa){
		$reg['cd_despesa'] = $oSicasDespesa->cd_despesa;
		$oSicasProcedimentoAutorizado = $oSicasDespesa->oSicasProcedimentoAutorizado;
		$reg['cd_procedimento_autorizado'] = $oSicasProcedimentoAutorizado->cd_procedimento_autorizado;
		$oSicasSalario = $oSicasDespesa->oSicasSalario;
		$reg['cd_salario'] = $oSicasSalario->cd_salario;
		$reg['cd_fatura'] = $oSicasDespesa->oSicasFatura->cd_fatura;
		$reg['qtd_servico_realizado'] = $oSicasDespesa->qtd_servico_realizado;
		$reg['val_servico_realizado'] = $oSicasDespesa->val_servico_realizado;
		$reg['dt_atendimento'] = $oSicasDespesa->dt_atendimento;
		$reg['dt_cadastro'] = $oSicasDespesa->dt_cadastro;
		$reg['desconto_servidor'] = $oSicasDespesa->desconto_servidor;
		$reg['status'] = $oSicasDespesa->status;
		$reg['mes_ano_desconto'] = $oSicasDespesa->mes_ano_desconto;
		return $reg;		   
	}

	static function objToRsInsert($oSicasDespesa){
		$oSicasProcedimentoAutorizado = $oSicasDespesa->oSicasProcedimentoAutorizado;
		$reg['cd_procedimento_autorizado'] = $oSicasProcedimentoAutorizado->cd_procedimento_autorizado;
		$oSicasSalario = $oSicasDespesa->oSicasSalario;
		$reg['cd_salario'] = $oSicasSalario->cd_salario;
		$reg['cd_fatura'] = $oSicasDespesa->oSicasFatura->cd_fatura;
		$reg['qtd_servico_realizado'] = $oSicasDespesa->qtd_servico_realizado;
		$reg['val_servico_realizado'] = $oSicasDespesa->val_servico_realizado;
		$reg['dt_atendimento'] = $oSicasDespesa->dt_atendimento;
		$reg['dt_cadastro'] = $oSicasDespesa->dt_cadastro;
		$reg['desconto_servidor'] = $oSicasDespesa->desconto_servidor;
		$reg['status'] = $oSicasDespesa->status;
		$reg['mes_ano_desconto'] = $oSicasDespesa->mes_ano_desconto;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasDespesa = new SicasDespesa();
		$oSicasDespesa->cd_despesa = $reg['sicas_despesa_cd_despesa'];

		$oSicasProcedimentoAutorizado = new SicasProcedimentoAutorizado();
		$oSicasProcedimentoAutorizado->cd_procedimento_autorizado = $reg['sicas_procedimento_autorizado_cd_procedimento_autorizado'];
		$oSicasProcedimentoAutorizado->qtd_servico_autorizado = $reg['sicas_procedimento_autorizado_qtd_servico_autorizado'];
		$oSicasProcedimentoAutorizado->status = $reg['sicas_procedimento_autorizado_status'];
		$oSicasDespesa->oSicasProcedimentoAutorizado = $oSicasProcedimentoAutorizado;

		$oSicasSalario = new SicasSalario();
		$oSicasSalario->cd_salario = $reg['sicas_salario_cd_salario'];
		$oSicasSalario->val_salario = $reg['sicas_salario_val_salario'];
		$oSicasSalario->dt_ini_salario = $reg['sicas_salario_dt_ini_salario'];
		$oSicasSalario->dt_fim_salario = $reg['sicas_salario_dt_fim_salario'];
		$oSicasSalario->serv_efetivo = $reg['sicas_salario_serv_efetivo'];
		$oSicasSalario->obs = $reg['sicas_salario_obs'];
		$oSicasSalario->status = $reg['sicas_salario_status'];
		$oSicasDespesa->oSicasSalario = $oSicasSalario;
		
		$oSicasFatura = new SicasFatura();
		$oSicasFatura->cd_fatura = $reg['sicas_fatura_cd_fatura'];
		$oSicasFatura->oSicasCredenciado = $oSicasCredenciado;
		$oSicasFatura->num_fatura = $reg['sicas_fatura_num_fatura'];
		$oSicasFatura->dt_cadastro = $reg['sicas_fatura_dt_cadastro'];
		$oSicasFatura->vl_fatura = $reg['sicas_fatura_vl_fatura'];
		$oSicasFatura->status = $reg['sicas_fatura_status'];
		$oSicasFatura->mes_ano_lancamento = $reg['sicas_fatura_mes_ano_lancamento'];
		$oSicasDespesa->oSicasFatura = $oSicasFatura;
		
		$oSicasServidor = new SicasServidor();
		$oSicasServidor->cd_matricula = $reg['sicas_servidor_cd_matricula'];
		$oSicasServidor->cd_servidor = $reg['sicas_servidor_cd_servidor'];
		$oSicasServidor->serv_efetivo = $reg['sicas_servidor_serv_efetivo'];
		$oSicasServidor->status = $reg['sicas_servidor_status'];		
		$oSicasDespesa->oSicasSalario->oSicasServidor = $oSicasServidor;
		
		$oSicasDespesa->qtd_servico_realizado = $reg['sicas_despesa_qtd_servico_realizado'];
		$oSicasDespesa->val_servico_realizado = $reg['sicas_despesa_val_servico_realizado'];
		$oSicasDespesa->dt_atendimento = $reg['sicas_despesa_dt_atendimento'];
		$oSicasDespesa->dt_cadastro = $reg['sicas_despesa_dt_cadastro'];
		$oSicasDespesa->desconto_servidor = $reg['sicas_despesa_desconto_servidor'];
		$oSicasDespesa->status = $reg['sicas_despesa_status'];
		$oSicasDespesa->mes_ano_desconto = $reg['sicas_despesa_mes_ano_desconto'];
		
		return $oSicasDespesa;		   
	}
}
