<?php
class SicasEncaminhamentoMAP {
    static function getMetaData($alias='sicas_encaminhamento') {
		return array_merge([$alias => ['cd_encaminhamento', 'dt_encaminhamento', 'cd_medico', 'cd_pessoa', 
                    				   'cd_consulta_medica', 'cd_credenciado', 'tipo_guia', 'status', 'cd_tipo_despesa', 'observacao']], 
		                  
		                    SicasMedicoMAP::getMetaData(),
		                    SicasPessoaMAP::getMetaData(),
		                    SicasConsultaMedicaMAP::getMetaData(),
		                    SicasCredenciadoMAP::getMetaData(),
		                    SicasTipoDespesaMAP::getMetaData(),
		                    SicasPessoaMAP::getMetaData('pessoa_servidor'));
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

	static function objToRs($oSicasEncaminhamento){
		$reg['cd_encaminhamento'] = $oSicasEncaminhamento->cd_encaminhamento;
		$reg['dt_encaminhamento'] = $oSicasEncaminhamento->dt_encaminhamento;
		$oSicasMedico = $oSicasEncaminhamento->oSicasMedico;
		$reg['cd_medico'] = $oSicasMedico->cd_medico;
		$oSicasPessoa = $oSicasEncaminhamento->oSicasPessoa;
		$reg['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$oSicasConsultaMedica = $oSicasEncaminhamento->oSicasConsultaMedica;
		$reg['cd_consulta_medica'] = $oSicasConsultaMedica->cd_consulta_medica;
		$oSicasCredenciado = $oSicasEncaminhamento->oSicasCredenciado;
		$reg['cd_credenciado'] = $oSicasCredenciado->cd_credenciado;
		$reg['tipo_guia'] = $oSicasEncaminhamento->tipo_guia;
		$reg['status'] = $oSicasEncaminhamento->status;
		$oSicasTipoDespesa = $oSicasEncaminhamento->oSicasTipoDespesa;
		$reg['cd_tipo_despesa'] = $oSicasTipoDespesa->cd_tipo_despesa;
		$reg['observacao'] = $oSicasEncaminhamento->observacao;
		
		return $reg;		   
	}

	static function objToRsInsert($oSicasEncaminhamento){
		$reg['dt_encaminhamento'] = $oSicasEncaminhamento->dt_encaminhamento;
		$oSicasMedico = $oSicasEncaminhamento->oSicasMedico;
		$reg['cd_medico'] = $oSicasMedico->cd_medico;
		$oSicasPessoa = $oSicasEncaminhamento->oSicasPessoa;
		$reg['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$oSicasConsultaMedica = $oSicasEncaminhamento->oSicasConsultaMedica;
		$reg['cd_consulta_medica'] = $oSicasConsultaMedica->cd_consulta_medica;
		$oSicasCredenciado = $oSicasEncaminhamento->oSicasCredenciado;
		$reg['cd_credenciado'] = $oSicasCredenciado->cd_credenciado;
		$reg['tipo_guia'] = $oSicasEncaminhamento->tipo_guia;
		$reg['status'] = $oSicasEncaminhamento->status;
		$oSicasTipoDespesa = $oSicasEncaminhamento->oSicasTipoDespesa;
		$reg['cd_tipo_despesa'] = $oSicasTipoDespesa->cd_tipo_despesa;
		$reg['observacao'] = $oSicasEncaminhamento->observacao;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasEncaminhamento = new SicasEncaminhamento();
		$oSicasEncaminhamento->cd_encaminhamento = $reg['sicas_encaminhamento_cd_encaminhamento'];
		$oSicasEncaminhamento->dt_encaminhamento = $reg['sicas_encaminhamento_dt_encaminhamento'];

		$oSicasMedico = new SicasMedico();
		$oSicasMedico->cd_medico = $reg['sicas_medico_cd_medico'];
		$oSicasMedico->login = $reg['sicas_medico_login'];
		$oSicasMedico->status = $reg['sicas_medico_status'];
		$oSicasMedico->crm = $reg['sicas_medico_crm'];
		
		$oSicasServidor = new SicasServidor ();
		$oSicasServidor->cd_servidor 		= $reg['sicas_servidor_cd_servidor'];
		$oSicasServidor->cd_matricula 		= $reg['sicas_servidor_cd_matricula'];
		$oSicasServidor->status 			= $reg['sicas_servidor_status'];
		$oSicasServidor->serv_efetivo 		= $reg['sicas_servidor_serv_efetivo'];
		$oSicasServidor->ramal1 			= $reg['sicas_servidor_ramal1'];
		$oSicasServidor->ramal2 			= $reg['sicas_servidor_ramal2'];
		$oSicasServidor->ramal3 			= $reg['sicas_servidor_ramal3'];
		$oSicasServidor->foto 				= $reg['sicas_servidor_foto'];
		$oSicasServidor->descricao_perfil	= $reg['sicas_servidor_descricao_perfil'];
		$oSicasServidor->usuario_proas	    = $reg['sicas_servidor_usuario_proas'];
		
		$oSicasPessoaServidor = new SicasPessoa();
		$oSicasPessoaServidor->cd_pessoa          = $reg['pessoa_servidor_cd_pessoa'];
		$oSicasPessoaServidor->nm_pessoa          = $reg['pessoa_servidor_nm_pessoa'];
		$oSicasPessoaServidor->email              = $reg['pessoa_servidor_email'];
		$oSicasPessoaServidor->dt_nascimento      = $reg['pessoa_servidor_dt_nascimento'];
		$oSicasPessoaServidor->genero             = $reg['pessoa_servidor_genero'];
		$oSicasPessoaServidor->uf_identidade      = $reg['pessoa_servidor_uf_identidade'];
		$oSicasPessoaServidor->tipo_identidade    = $reg['pessoa_servidor_tipo_identidade'];
		$oSicasPessoaServidor->descricao_perfil   = $reg['pessoa_servidor_descricao_perfil'];
		$oSicasPessoaServidor->usuario_proas      = $reg['pessoa_servidor_usuario_proas'];
		$oSicasPessoaServidor->identidade         = $reg['pessoa_servidor_identidade'];
		$oSicasPessoaServidor->nm_orgao_emissor   = $reg['pessoa_servidor_nm_orgao_emissor'];
		$oSicasPessoaServidor->dt_emissao         = $reg['pessoa_servidor_dt_emissao'];
		$oSicasPessoaServidor->cpf                = $reg['pessoa_servidor_cpf'];
		$oSicasPessoaServidor->endereco           = $reg['pessoa_servidor_endereco'];
		$oSicasPessoaServidor->complemento        = $reg['pessoa_servidor_complemento'];
		$oSicasPessoaServidor->bairro             = $reg['pessoa_servidor_bairro'];
		$oSicasPessoaServidor->cidade             = $reg['pessoa_servidor_cidade'];
		$oSicasPessoaServidor->uf                 = $reg['pessoa_servidor_uf'];
		$oSicasPessoaServidor->cep                = $reg['pessoa_servidor_cep'];
		$oSicasPessoaServidor->telefone           = $reg['pessoa_servidor_telefone'];
		$oSicasPessoaServidor->grupo_sanguineo    = $reg['pessoa_servidor_grupo_sanguineo'];
		$oSicasPessoaServidor->tipo_beneficiario  = $reg['pessoa_servidor_tipo_beneficiario'];
		$oSicasPessoaServidor->status             = $reg['pessoa_servidor_status'];
		$oSicasPessoaServidor->foto               = $reg['pessoa_servidor_foto'];
		
		$oRhCargo = new RhCargo();
		$oRhCargo->cd_cargo              = $reg['rh_cargo_cd_cargo'];
		$oRhCargo->descricao_cargo       = $reg['rh_cargo_descricao_cargo'];
		$oRhCargo->descricao_cargo_abrev = $reg['rh_cargo_descricao_cargo_abrev'];
		$oRhCargo->num_siape_cargo       = $reg['rh_cargo_num_siape_cargo'];
		$oRhCargo->status                = $reg['rh_cargo_status'];
		
		$oSicasServidor->oSicasPessoa       = $oSicasPessoaServidor;
		$oSicasServidor->oRhCargo           = $oRhCargo;
		$oSicasMedico->oSicasServidor       = $oSicasServidor;
		$oSicasEncaminhamento->oSicasMedico = $oSicasMedico;

		$oSicasPessoa = new SicasPessoa();
		$oSicasPessoa->cd_pessoa = $reg['sicas_pessoa_cd_pessoa'];
		$oSicasPessoa->nm_pessoa = $reg['sicas_pessoa_nm_pessoa'];
		$oSicasPessoa->email = $reg['sicas_pessoa_email'];
		$oSicasPessoa->dt_nascimento = $reg['sicas_pessoa_dt_nascimento'];
		$oSicasPessoa->genero = $reg['sicas_pessoa_genero'];
		$oSicasPessoa->uf_identidade = $reg['sicas_pessoa_uf_identidade'];
		$oSicasPessoa->tipo_identidade = $reg['sicas_pessoa_tipo_identidade'];
		$oSicasPessoa->descricao_perfil = $reg['sicas_pessoa_descricao_perfil'];
		$oSicasPessoa->usuario_proas= $reg['sicas_pessoa_usuario_proas'];
		$oSicasPessoa->identidade = $reg['sicas_pessoa_identidade'];
		$oSicasPessoa->nm_orgao_emissor = $reg['sicas_pessoa_nm_orgao_emissor'];
		$oSicasPessoa->dt_emissao = $reg['sicas_pessoa_dt_emissao'];
		$oSicasPessoa->cpf = $reg['sicas_pessoa_cpf'];
		$oSicasPessoa->endereco = $reg['sicas_pessoa_endereco'];
		$oSicasPessoa->complemento = $reg['sicas_pessoa_complemento'];
		$oSicasPessoa->bairro = $reg['sicas_pessoa_bairro'];
		$oSicasPessoa->cidade = $reg['sicas_pessoa_cidade'];
		$oSicasPessoa->uf = $reg['sicas_pessoa_uf'];
		$oSicasPessoa->cep = $reg['sicas_pessoa_cep'];
		$oSicasPessoa->telefone = $reg['sicas_pessoa_telefone'];
		$oSicasPessoa->grupo_sanguineo = $reg['sicas_pessoa_grupo_sanguineo'];
		$oSicasPessoa->tipo_beneficiario = $reg['sicas_pessoa_tipo_beneficiario'];
		$oSicasPessoa->status = $reg['sicas_pessoa_status'];
		$oSicasPessoa->foto = $reg['sicas_pessoa_foto'];
		$oSicasPessoa->uf_identidade = $reg['sicas_pessoa_uf_identidade'];
		$oSicasPessoa->tipo_identidade = $reg['sicas_pessoa_tipo_identidade'];
		$oSicasPessoa->descricao_perfil = $reg['sicas_pessoa_descricao_perfil'];
		$oSicasPessoa->usuario_proas = $reg['sicas_pessoa_usuario_proas'];
		    
		$oSicasEstadoCivil = new SicasEstadoCivil();
		$oSicasEstadoCivil->cd_estado_civil = $reg['sicas_estado_civil_cd_estado_civil'];
		$oSicasEstadoCivil->nm_estado_civil = $reg['sicas_estado_civil_nm_estado_civil'];
		$oSicasEstadoCivil->status = $reg['sicas_estado_civil_status'];
		$oSicasPessoa->oSicasEstadoCivil = $oSicasEstadoCivil;
		
		$oSicasPessoaCategoria = new SicasPessoaCategoria ();
		$oSicasPessoaCategoria->cd_categoria = $reg['sicas_pessoa_categoria_cd_categoria'];
		$oSicasPessoaCategoria->desc_categoria = $reg['sicas_pessoa_categoria_desc_categoria'];
		$oSicasPessoaCategoria->desc_categoria_abrev = $reg['sicas_pessoa_categoria_desc_categoria_abrev'];
		$oSicasPessoa->oSicasPessoaCategoria = $oSicasPessoaCategoria;
		
		$oSicasEncaminhamento->oSicasPessoa = $oSicasPessoa;

		$oSicasConsultaMedica = new SicasConsultaMedica();
		$oSicasConsultaMedica->cd_consulta_medica = $reg['sicas_consulta_medica_cd_consulta_medica'];
		$oSicasConsultaMedica->dt_consulta = $reg['sicas_consulta_medica_dt_consulta'];
		$oSicasConsultaMedica->qp_paciente = $reg['sicas_consulta_medica_qp_paciente'];
		$oSicasConsultaMedica->exame_fisico = $reg['sicas_consulta_medica_exame_fisico'];
		$oSicasConsultaMedica->exame_solicitado = $reg['sicas_consulta_medica_exame_solicitado'];
		$oSicasConsultaMedica->diag_paciente = $reg['sicas_consulta_medica_diag_paciente'];
		$oSicasConsultaMedica->resultado = $reg['sicas_consulta_medica_resultado'];
		$oSicasConsultaMedica->tratamento = $reg['sicas_consulta_medica_tratamento'];
		$oSicasConsultaMedica->status = $reg['sicas_consulta_medica_status'];
		$oSicasEncaminhamento->oSicasConsultaMedica = $oSicasConsultaMedica;

		$oSicasCredenciado = new SicasCredenciado();
		$oSicasCredenciado->cd_credenciado = $reg['sicas_credenciado_cd_credenciado'];
		$oSicasCredenciado->nm_credenciado = $reg['sicas_credenciado_nm_credenciado'];
		$oSicasCredenciado->dt_nascimento = $reg['sicas_credenciado_dt_nascimento'];
		$oSicasCredenciado->hora_atendimento = $reg['sicas_credenciado_hora_atendimento'];
		$oSicasCredenciado->nm_servicos = $reg['sicas_credenciado_nm_servicos'];
		$oSicasCredenciado->profissional_liberal = $reg['sicas_credenciado_profissional_liberal'];
		$oSicasCredenciado->endereco = $reg['sicas_credenciado_endereco'];
		$oSicasCredenciado->complemento = $reg['sicas_credenciado_complemento'];
		$oSicasCredenciado->bairro = $reg['sicas_credenciado_bairro'];
		$oSicasCredenciado->cidade = $reg['sicas_credenciado_cidade'];
		$oSicasCredenciado->uf = $reg['sicas_credenciado_uf'];
		$oSicasCredenciado->cep = $reg['sicas_credenciado_cep'];
		$oSicasCredenciado->telefone1 = $reg['sicas_credenciado_telefone1'];
		$oSicasCredenciado->telefone2 = $reg['sicas_credenciado_telefone2'];
		$oSicasCredenciado->fax1 = $reg['sicas_credenciado_fax1'];
		$oSicasCredenciado->ramal1 = $reg['sicas_credenciado_ramal1'];
		$oSicasCredenciado->tipo = $reg['sicas_credenciado_tipo'];
		$oSicasCredenciado->cd_pis_pasep = $reg['sicas_credenciado_cd_pis_pasep'];
		$oSicasCredenciado->cpf = $reg['sicas_credenciado_cpf'];
		$oSicasCredenciado->cgc = $reg['sicas_credenciado_cgc'];
		$oSicasCredenciado->guia_prev_social = $reg['sicas_credenciado_guia_prev_social'];
		$oSicasCredenciado->status = $reg['sicas_credenciado_status'];
		$oSicasEncaminhamento->oSicasCredenciado = $oSicasCredenciado;
		$oSicasEncaminhamento->tipo_guia = $reg['sicas_encaminhamento_tipo_guia'];
		$oSicasEncaminhamento->status = $reg['sicas_encaminhamento_status'];

		$oSicasTipoDespesa = new SicasTipoDespesa();
		$oSicasTipoDespesa->cd_tipo_despesa = $reg['sicas_tipo_despesa_cd_tipo_despesa'];
		$oSicasTipoDespesa->nm_despesa = $reg['sicas_tipo_despesa_nm_despesa'];
		$oSicasTipoDespesa->credenciado = $reg['sicas_tipo_despesa_credenciado'];
		$oSicasTipoDespesa->status = $reg['sicas_tipo_despesa_status'];
		$oSicasEncaminhamento->oSicasTipoDespesa = $oSicasTipoDespesa;
		
		$oSicasEncaminhamento->observacao = $reg['sicas_encaminhamento_observacao'];
		
		return $oSicasEncaminhamento;		   
	}
}
