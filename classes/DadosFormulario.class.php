<?php
class DadosFormulario {
	static function formularioCadastroSicasAtendimento($post = NULL, $acao = ''){
		if($post == NULL)
			$post = $_REQUEST;
		
		if($acao == 2){
			$post["cd_atendimento"] = strip_tags(addslashes(trim($post["cd_atendimento"])));
		}
		$post["cd_pessoa"] = strip_tags(addslashes(trim($_REQUEST["cd_pessoa"])));
		$post["dt_ini_atendimento"] = Util::formataDataHoraFormBanco(strip_tags(addslashes(trim($post["dt_ini_atendimento"]))));
		$post["dt_fim_atendimento"] = Util::formataDataHoraFormBanco(strip_tags(addslashes(trim($post["dt_fim_atendimento"]))));
		$post["cd_medico"] = strip_tags(addslashes(trim($post["cd_medico"])));
		$post["status"] = strip_tags(addslashes(trim($post["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasCid($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_cid"] = strip_tags(addslashes(trim($_REQUEST["cd_cid"])));
		}
		$post["desc_cid"] = strip_tags(addslashes(trim($_REQUEST["desc_cid"])));
		$post["desc_cid_abrev"] = strip_tags(addslashes(trim($_REQUEST["desc_cid_abrev"])));
		$post["cd_cid_pai"] = strip_tags(addslashes(trim($_REQUEST["cd_cid_pai"])));
		
		return $post;
	}
	static function formularioCadastroSicasConsultaMedica($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_consulta_medica"] = strip_tags(addslashes(trim($_REQUEST["cd_consulta_medica"])));
		}
		$post["cd_atendimento"] = strip_tags(addslashes(trim($_REQUEST["cd_atendimento"])));
		$post["dt_consulta"] = Util::formataDataHoraFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_consulta"]))));
		$post["cd_medico"] = strip_tags(addslashes(trim($_REQUEST["cd_medico"])));
		$post["qp_paciente"] = strip_tags(addslashes(trim($_REQUEST["qp_paciente"])));
		$post["exame_fisico"] = strip_tags(addslashes(trim($_REQUEST["exame_fisico"])));
		$post["exame_solicitado"] = strip_tags(addslashes(trim($_REQUEST["exame_solicitado"])));
		$post["diag_paciente"] = strip_tags(addslashes(trim($_REQUEST["diag_paciente"])));
		$post["cd_tipo_atendimento"] = strip_tags(addslashes(trim($_REQUEST["cd_tipo_atendimento"])));
		$post["resultado"] = strip_tags(addslashes(trim($_REQUEST["resultado"])));
		$post["tratamento"] = strip_tags(addslashes(trim($_REQUEST["tratamento"])));
		$post["status"] = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasConsultaMedicaCid($acao = ''){
		$post = array();
		
		$post["cd_cid"] = strip_tags(addslashes(trim($_REQUEST["cd_cid"])));
		$post["cd_consulta_medica"] = strip_tags(addslashes(trim($_REQUEST["cd_consulta_medica"])));
		
		return $post;
	}
	
	static function formSicasCredenciado($post=NULL, $acao=''){
	    if($post == NULL)
	        $post = $_REQUEST;
	        
        if($acao == 2){
            $post["cd_credenciado"] = strip_tags(addslashes(trim($post["cd_credenciado"])));
        }
        $post["nm_credenciado"] = strip_tags(addslashes(trim($post["nm_credenciado"])));
        $post["dt_nascimento"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($post["dt_nascimento"]))));
        $post["hora_atendimento"] = strip_tags(addslashes(trim($post["hora_atendimento"])));
        $post["nm_servicos"] = strip_tags(addslashes(trim($post["nm_servicos"])));
        $post["profissional_liberal"] = strip_tags(addslashes(trim($post["profissional_liberal"])));
        $post["endereco"] = strip_tags(addslashes(trim($post["endereco"])));
        $post["complemento"] = strip_tags(addslashes(trim($post["complemento"])));
        $post["bairro"] = strip_tags(addslashes(trim($post["bairro"])));
        $post["cidade"] = strip_tags(addslashes(trim($post["cidade"])));
        $post["uf"] = strip_tags(addslashes(trim($post["uf"])));
        $post["cep"] = strip_tags(addslashes(trim($post["cep"])));
        $post["telefone1"] = strip_tags(addslashes(trim($post["telefone1"])));
        $post["telefone2"] = strip_tags(addslashes(trim($post["telefone2"])));
        $post["fax1"] = strip_tags(addslashes(trim($post["fax1"])));
        $post["ramal1"] = strip_tags(addslashes(trim($post["ramal1"])));
        $post["tipo"] = strip_tags(addslashes(trim($post["tipo"])));
        $post["cd_pis_pasep"] = strip_tags(addslashes(trim($post["cd_pis_pasep"])));
        $post["cpf"] = strip_tags(addslashes(trim($post["cpf"])));
        $post["cgc"] = strip_tags(addslashes(trim($post["cgc"])));
        $post["guia_prev_social"] = strip_tags(addslashes(trim($post["guia_prev_social"])));
        $post["status"] = strip_tags(addslashes(trim($post["status"])));
        
        return $post;
	}
	
	static function formSicasCredenciamento($post=NULL, $acao = ''){
	    if($post == NULL)
	        $post = $_REQUEST;
		
		if($acao == 2){
			$post["cd_credenciamento"] = strip_tags(addslashes(trim($_REQUEST["cd_credenciamento"])));
		}
		$post["cd_credenciado"] = strip_tags(addslashes(trim($_REQUEST["cd_credenciado"])));
		$post["dt_ini_credenciamento"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_ini_credenciamento"]))));
		$post["dt_fim_credenciamento"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_fim_credenciamento"]))));
		$post["status"] = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasDependente($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_dependente"] = strip_tags(addslashes(trim($_REQUEST["cd_dependente"])));
		}
		$post["cd_servidor"] = strip_tags(addslashes(trim($_REQUEST["cd_servidor"])));
		$post["cd_pessoa"] = strip_tags(addslashes(trim($_REQUEST["cd_pessoa"])));
		$post["cd_seq_dependente"] = strip_tags(addslashes(trim($_REQUEST["cd_seq_dependente"])));
		$post["cd_grau_parentesco"] = strip_tags(addslashes(trim($_REQUEST["cd_grau_parentesco"])));
		$post["cd_escolaridade"] = strip_tags(addslashes(trim($_REQUEST["cd_escolaridade"])));
		$post["dt_inclusao"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_inclusao"]))));
		$post["dt_manutencao"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_manutencao"]))));
		$post["dependente_financ"] = strip_tags(addslashes(trim($_REQUEST["dependente_financ"])));
		$post["dependente_proas"] = strip_tags(addslashes(trim($_REQUEST["dependente_proas"])));
		$post["status"] = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formSicasDespesa($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_despesa"] = strip_tags(addslashes(trim($_REQUEST["cd_despesa"])));
		}
		$post["cd_procedimento_autorizado"] = strip_tags(addslashes(trim($_REQUEST["cd_procedimento_autorizado"])));
		$post["cd_salario"] = strip_tags(addslashes(trim($_REQUEST["cd_salario"])));
		$post["qtd_servico_realizado"] = strip_tags(addslashes(trim($_REQUEST["qtd_servico_realizado"])));
		$post["val_servico_realizado"] = strip_tags(addslashes(trim($_REQUEST["val_servico_realizado"])));
		$post["dt_atendimento"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_atendimento"]))));
		$post["dt_cadastro"] = Util::formataDataHoraFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_cadastro"]))));
		$post["desconto_servidor"] = strip_tags(addslashes(trim($_REQUEST["desconto_servidor"])));
		$post["status"] = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasDespesaGol($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_despesa_gol"] = strip_tags(addslashes(trim($_REQUEST["cd_despesa_gol"])));
		}
		$post["ano_mes"] = strip_tags(addslashes(trim($_REQUEST["ano_mes"])));
		$post["matricula"] = strip_tags(addslashes(trim($_REQUEST["matricula"])));
		$post["cd_pessoa"] = strip_tags(addslashes(trim($_REQUEST["cd_pessoa"])));
		$post["cd_credenciado"] = strip_tags(addslashes(trim($_REQUEST["cd_credenciado"])));
		$post["vl_despesa"] = strip_tags(addslashes(trim($_REQUEST["vl_despesa"])));
		$post["vl_d_despesa"] = strip_tags(addslashes(trim($_REQUEST["vl_d_despesa"])));
		$post["porcentagem_desconto"] = strip_tags(addslashes(trim($_REQUEST["porcentagem_desconto"])));
		$post["remuneracao"] = strip_tags(addslashes(trim($_REQUEST["remuneracao"])));
		$post["cd_tipo_despesa"] = strip_tags(addslashes(trim($_REQUEST["cd_tipo_despesa"])));
		$post["flg_desconta"] = strip_tags(addslashes(trim($_REQUEST["flg_desconta"])));
		$post["flg_fis_jur"] = strip_tags(addslashes(trim($_REQUEST["flg_fis_jur"])));
		
		return $post;
	}
	static function formularioCadastroSicasEncaminhamento($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_encaminhamento"] = strip_tags(addslashes(trim($_REQUEST["cd_encaminhamento"])));
		}
		$post["dt_encaminhamento"]  = Util::formataDataHoraFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_encaminhamento"]))));
		$post["cd_medico"] 			= strip_tags(addslashes(trim($_REQUEST["cd_medico"])));
		$post["cd_pessoa"] 			= strip_tags(addslashes(trim($_REQUEST["cd_pessoa"])));
		$post["cd_consulta_medica"] = strip_tags(addslashes(trim($_REQUEST["cd_consulta_medica"])));
		$post["cd_credenciado"] 	= strip_tags(addslashes(trim($_REQUEST["cd_credenciado"])));
		$post["tipo_guia"] 		 	= strip_tags(addslashes(trim($_REQUEST["tipo_guia"])));
		$post["cd_tipo_despesa"] 	= strip_tags(addslashes(trim($_REQUEST["cd_tipo_despesa"])));
		$post["status"] 		 	= strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasEscolaridade($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_escolaridade"] = strip_tags(addslashes(trim($_REQUEST["cd_escolaridade"])));
		}
		$post["nm_escolaridade"] = strip_tags(addslashes(trim($_REQUEST["nm_escolaridade"])));
		$post["status"] 		 = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasEspecialidadeMedica($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_especialidade_medica"] = strip_tags(addslashes(trim($_REQUEST["cd_especialidade_medica"])));
		}
		$post["nm_especialidade"] = strip_tags(addslashes(trim($_REQUEST["nm_especialidade"])));
		$post["status"] 		  = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasEspecialidadeMedicaCredenciado($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_especialidade_medica_credenciado"] = strip_tags(addslashes(trim($_REQUEST["cd_especialidade_medica_credenciado"])));
		}
		$post["cd_credenciado"] 		 = strip_tags(addslashes(trim($_REQUEST["cd_credenciado"])));
		$post["cd_especialidade_medica"] = strip_tags(addslashes(trim($_REQUEST["cd_especialidade_medica"])));
		$post["status"] 				 = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasEstadoCivil($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_estado_civil"] = strip_tags(addslashes(trim($_REQUEST["cd_estado_civil"])));
		}
		$post["nm_estado_civil"] = strip_tags(addslashes(trim($_REQUEST["nm_estado_civil"])));
		$post["status"] 		 = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	
	static function formSicasFatura($post = NULL, $acao = ''){
	    if($post == NULL)
	        $post = $_REQUEST;
	    
	    if($acao == 2){
	        $post["cd_fatura"] = strip_tags(addslashes(trim($_REQUEST["cd_fatura"])));
	    }
	    $post["cd_credenciado"] = strip_tags(addslashes(trim($_REQUEST["cd_credenciado"])));
	    $post["num_fatura"]     = strip_tags(addslashes(trim($_REQUEST["num_fatura"])));
	    $post["dt_cadastro"]    = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_cadastro"]))));
	    $post["vl_fatura"]      = strip_tags(addslashes(trim($_REQUEST["vl_fatura"])));
	    $post["status"] 	    = strip_tags(addslashes(trim($_REQUEST["status"])));
	    
	    return $post;
	}
	
	static function formularioCadastroSicasGrauParentesco($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_grau_parentesco"] = strip_tags(addslashes(trim($_REQUEST["cd_grau_parentesco"])));
		}
		$post["desc_grauparentesco"] = strip_tags(addslashes(trim($_REQUEST["desc_grauparentesco"])));
		$post["nm_grau_parentesco"]  = strip_tags(addslashes(trim($_REQUEST["nm_grau_parentesco"])));
		$post["status"] 			 = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasHistoricoImpressao($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_carteira"] = strip_tags(addslashes(trim($_REQUEST["cd_carteira"])));
		}
		$post["cd_pessoa"] 	  = strip_tags(addslashes(trim($_REQUEST["cd_pessoa"])));
		$post["dt_impressao"] = Util::formataDataHoraFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_impressao"]))));
		
		return $post;
	}
	static function formularioCadastroSicasLotacao($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_lotacao"] = strip_tags(addslashes(trim($_REQUEST["cd_lotacao"])));
		}
		$post["sigla"] 		= strip_tags(addslashes(trim($_REQUEST["sigla"])));
		$post["cd_siged"] 	= strip_tags(addslashes(trim($_REQUEST["cd_siged"])));
		$post["nm_lotacao"] = strip_tags(addslashes(trim($_REQUEST["nm_lotacao"])));
		$post["status"] 	= strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formSicasMedico($post=NULL, $acao=NULL){
	    if($post == NULL)
	        $post = $_REQUEST;
		
		if($acao == 2){
			$post["cd_medico"] = strip_tags(addslashes(trim($_REQUEST["cd_medico"])));
		}
		$post["login"] = strip_tags(addslashes(trim($_REQUEST["login"])));
		$post["crm"] = strip_tags(addslashes(trim($_REQUEST["crm"])));
		$post["cd_servidor"] = strip_tags(addslashes(trim($_REQUEST["cd_servidor"])));
		$post["status"] = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasParamDesconto($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_param_desc"] = strip_tags(addslashes(trim($_REQUEST["cd_param_desc"])));
		}
		$post["descricao_param"] 	  = strip_tags(addslashes(trim($_REQUEST["descricao_param"])));
		$post["percentagem_desconto"] = strip_tags(addslashes(trim($_REQUEST["percentagem_desconto"])));
		$post["status"] 			  = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasParamFaixaSalarial($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_param_faixa_sal"] = strip_tags(addslashes(trim($_REQUEST["cd_param_faixa_sal"])));
		}
		$post["val_faixa_inicial"] 		 = strip_tags(addslashes(trim($_REQUEST["val_faixa_inicial"])));
		$post["flg_faixa_ini_inclusive"] = strip_tags(addslashes(trim($_REQUEST["flg_faixa_ini_inclusive"])));
		$post["val_faixa_final"] 		 = strip_tags(addslashes(trim($_REQUEST["val_faixa_final"])));
		$post["flg_faixa_fin_inclusive"] = strip_tags(addslashes(trim($_REQUEST["flg_faixa_fin_inclusive"])));
		$post["percentagem_desconto"] 	 = strip_tags(addslashes(trim($_REQUEST["percentagem_desconto"])));
		$post["status"] 				 = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	
	static function formSicasPessoa($post=NULL, $acao=NULL){
		if($post == NULL)
			$post = $_REQUEST;
		
		if($acao == 2){
			$post["cd_pessoa"] = strip_tags(addslashes(trim($post["cd_pessoa"])));
		}
		$post["nm_pessoa"] 			= strtoupper(strip_tags(addslashes(trim($post["nm_pessoa"]))));
		$post["email"] 				= strip_tags(addslashes(trim($post["email"])));
		$post["dt_nascimento"] 		= strip_tags(addslashes(trim($post["dt_nascimento"])));
		$post["genero"] 			= strip_tags(addslashes(trim($post["genero"])));
		$post["cd_estado_civil"] 	= strip_tags(addslashes(trim($post["cd_estado_civil"])));
		$post["identidade"] 		= strip_tags(addslashes(trim($post["identidade"])));
		$post["nm_orgao_emissor"] 	= strip_tags(addslashes(trim($post["nm_orgao_emissor"])));
		$post["dt_emissao"] 		= strip_tags(addslashes(trim($post["dt_emissao"])));
		$post["cpf"] 				= Util::limpaCampo(strip_tags(addslashes(trim($post["cpf"]))));
		$post["endereco"] 			= strip_tags(addslashes(trim($post["endereco"])));
		$post["complemento"] 		= strip_tags(addslashes(trim($post["complemento"])));
		$post["bairro"] 			= strip_tags(addslashes(trim($post["bairro"])));
		$post["cidade"] 			= strip_tags(addslashes(trim($post["cidade"])));
		$post["uf"] 				= strip_tags(addslashes(trim($post["uf"])));
		$post["cep"] 				= Util::limpaCampo(strip_tags(addslashes(trim($post["cep"]))));
		$post["telefone"] 			= Util::limpaCampo(strip_tags(addslashes(trim($post["telefone"]))));
		$post["grupo_sanguineo"] 	= strip_tags(addslashes(trim($post["grupo_sanguineo"])));
		$post["tipo_beneficiario"] 	= strip_tags(addslashes(trim($post["tipo_beneficiario"])));
		$post["status"] 			= strip_tags(addslashes(trim($post["status"])));
		$post["foto"] 				= strip_tags(addslashes(trim($post["foto"])));
		$post["cd_categoria"] 		= strip_tags(addslashes(trim($post["cd_categoria"])));
		$post["uf_identidade"] 		= strip_tags(addslashes(trim($post["uf_identidade"])));
		$post["tipo_identidade"] 	= strip_tags(addslashes(trim($post["tipo_identidade"])));
		$post["descricao_perfil"] 	= utf8_encode(strip_tags(addslashes(trim($post["descricao_perfil"]))));

		//Util::trace($post);
		
		return $post;
	}
	
	static function formularioCadastroSicasPessoaCategoria($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_categoria"] 	  = strip_tags(addslashes(trim($_REQUEST["cd_categoria"])));
		}
		$post["desc_categoria"] 	  = strip_tags(addslashes(trim($_REQUEST["desc_categoria"])));
		$post["desc_categoria_abrev"] = strip_tags(addslashes(trim($_REQUEST["desc_categoria_abrev"])));
		
		return $post;
	}
	static function formSicasProcedimento($post=NULL, $acao=NULL){
	    if($post == NULL)
	        $post = $_REQUEST;
		
		if($acao == 2){
			$post["cd_procedimento"] = strip_tags(addslashes(trim($_REQUEST["cd_procedimento"])));
		}
		$post["num_procedimento"] 	   = strip_tags(addslashes(trim($_REQUEST["num_procedimento"])));
		$post["nm_procedimento"] 	   = strip_tags(addslashes(trim($_REQUEST["nm_procedimento"])));
		$post["num_custo_operacional"] = strip_tags(addslashes(trim(Util::formataMoedaBanco($_REQUEST["num_custo_operacional"]))));
		$post["num_honorario"] 		   = strip_tags(addslashes(trim(Util::formataMoedaBanco($_REQUEST["num_honorario"]))));
		$post["num_med_filme"] 		   = strip_tags(addslashes(trim($_REQUEST["num_med_filme"])));
		$post["num_auxiliares"] 	   = strip_tags(addslashes(trim($_REQUEST["num_auxiliares"])));
		$post["num_port_anest"] 	   = strip_tags(addslashes(trim($_REQUEST["num_port_anest"])));
		$post["sigla"] 				   = strip_tags(addslashes(trim($_REQUEST["sigla"])));
		$post["red_registro"]		   = strip_tags(addslashes(trim($_REQUEST["red_registro"])));
		$post["status"] 			   = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasProcedimentoAutorizado($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_procedimento_autorizado"] = strip_tags(addslashes(trim($_REQUEST["cd_procedimento_autorizado"])));
		}
		$post["cd_encaminhamento"] 		= strip_tags(addslashes(trim($_REQUEST["cd_encaminhamento"])));
		$post["cd_procedimento"] 		= strip_tags(addslashes(trim($_REQUEST["cd_procedimento"])));
		$post["qtd_servico_autorizado"] = strip_tags(addslashes(trim($_REQUEST["qtd_servico_autorizado"])));
		$post["status"] 				= strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formSicasSalario($post=null, $acao=null){
	    if($post == NULL)
	        $post = $_REQUEST;
		
		if($acao == 2){
			$post["cd_salario"] = strip_tags(addslashes(trim($_REQUEST["cd_salario"])));
		}
		$post["cd_servidor"] 	= strip_tags(addslashes(trim($_REQUEST["cd_servidor"])));
		$post["val_salario"] 	= Util::formataMoedaBanco(strip_tags(addslashes(trim($_REQUEST["val_salario"]))));
		$post["dt_ini_salario"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_ini_salario"]))));
		$post["dt_fim_salario"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_fim_salario"]))));
		$post["serv_efetivo"] 	= strip_tags(addslashes(trim($_REQUEST["serv_efetivo"])));
		$post["obs"] 			= strip_tags(addslashes(trim($_REQUEST["obs"])));
		$post["status"] 		= strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formSicasSalarioMinimo($post=NULL, $acao=NULL){
	    if($post == NULL)
	        $post = $_REQUEST;
		
		if($acao == 2){
			$post["cd_salario_minimo"] = strip_tags(addslashes(trim($_REQUEST["cd_salario_minimo"])));
		}
		$post["valor"] 		 = strip_tags(addslashes(trim(Util::formataMoedaBanco($_REQUEST["valor"]))));
		$post["dt_cadastro"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["dt_cadastro"]))));
		$post["status"] 	 = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formSicasServidor($post=NULL, $acao=NULL){
		if($post == NULL)
		    $post = $_REQUEST;
		
		if($acao == 2){
			$post["cd_servidor"] = strip_tags(addslashes(trim($_REQUEST["cd_servidor"])));
		}
		$post["cd_pessoa"] 	           = strip_tags(addslashes(trim($_REQUEST["cd_pessoa"])));
		$post["cd_matricula"]          = strip_tags(addslashes(trim($_REQUEST["cd_matricula"])));
		$post["cd_lotacao"]            = strip_tags(addslashes(trim($_REQUEST["cd_lotacao"])));
		$post["status_servidor"] 	   = strip_tags(addslashes(trim($_REQUEST["status_servidor"])));
		$post["serv_efetivo"]          = strip_tags(addslashes(trim($_REQUEST["serv_efetivo"])));
		$post["cd_cargo"] 	           = strip_tags(addslashes(trim($_REQUEST["cd_cargo"])));
		$post["ramal1"] 	           = strip_tags(addslashes(trim($_REQUEST["ramal1"])));
		$post["ramal2"] 	           = strip_tags(addslashes(trim($_REQUEST["ramal2"])));
		$post["ramal3"] 	           = strip_tags(addslashes(trim($_REQUEST["ramal3"])));
		$post["cd_categoria_servidor"] = strip_tags(addslashes(trim($_REQUEST["cd_categoria_servidor"])));
		$post["foto_servidor"]         = strip_tags(addslashes(trim($_REQUEST["foto_servidor"])));
		$post["descricao_perfil"]      = strip_tags(addslashes(trim($_REQUEST["descricao_perfil"])));
		$post["usuario_proas"]         = strip_tags(addslashes(trim($_REQUEST["usuario_proas"])));
		$post["vl_saldo_odonto"]       = strip_tags(addslashes(trim($_REQUEST["vl_saldo_odonto"])));
		
		return $post;
	}
	static function formularioCadastroSicasTipoAtendimento($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_tipo_atendimento"] = strip_tags(addslashes(trim($_REQUEST["cd_tipo_atendimento"])));
		}
		$post["nm_tipo_atendimento"] = strip_tags(addslashes(trim($_REQUEST["nm_tipo_atendimento"])));
		$post["fl_atendimento"] 	 = strip_tags(addslashes(trim($_REQUEST["fl_atendimento"])));
		$post["pericia"] 			 = strip_tags(addslashes(trim($_REQUEST["pericia"])));
		$post["status"] 			 = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formularioCadastroSicasTipoDespesa($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_tipo_despesa"] = strip_tags(addslashes(trim($_REQUEST["cd_tipo_despesa"])));
		}
		$post["nm_despesa"]  = strip_tags(addslashes(trim($_REQUEST["nm_despesa"])));
		$post["credenciado"] = strip_tags(addslashes(trim($_REQUEST["credenciado"])));
		$post["status"]      = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	
	static function formularioCadastroRhIes($post=NULL, $acao=''){
	    if($post == NULL)
	        $post = $_REQUEST;
	        
	        if($acao == 2){
	            $post["cd_ies"] = strip_tags(addslashes(trim($post["cd_ies"])));
	        }
	        $post["sigla"] = strip_tags(addslashes(trim($post["sigla"])));
	        $post["descricao"] = strip_tags(addslashes(trim($post["descricao"])));
	        $post["endereco"] = strip_tags(addslashes(trim($post["endereco"])));
	        $post["telefone1"] = strip_tags(addslashes(trim($post["telefone1"])));
	        $post["telefone2"] = strip_tags(addslashes(trim($post["telefone2"])));
	        $post["telefone3"] = strip_tags(addslashes(trim($post["telefone3"])));
	        $post["email"] = strip_tags(addslashes(trim($post["email"])));
	        $post["status"] = strip_tags(addslashes(trim($post["status"])));
	        
	        return $post;
	}
	
	static function formularioCadastroRhEstagiario($post=NULL, $acao=''){
	    if($post == NULL)
	        $post = $_REQUEST;
	        
        if($acao == 2){
            $post["cd_estagiario"] = strip_tags(addslashes(trim($post["cd_estagiario"])));
        }
        $post["cd_pessoa"] = strip_tags(addslashes(trim($post["cd_pessoa"])));
        $post["cd_lotacao"] = strip_tags(addslashes(trim($post["cd_lotacao"])));
        $post["cd_ies"] = strip_tags(addslashes(trim($post["cd_ies"])));
        $post["num_processo"] = strip_tags(addslashes(trim($post["num_processo"])));
        $post["dt_inicio"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($post["dt_inicio"]))));
        $post["dt_renovacao"] = Util::formataDataFormBanco(strip_tags(addslashes(trim($post["dt_renovacao"]))));
        $post["status"] = strip_tags(addslashes(trim($post["status"])));
        
        return $post;
	}
	
	static function formularioCadastroRhFeriado($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_feriado"] = strip_tags(addslashes(trim($_REQUEST["cd_feriado"])));
		}
		$post["data_feriado"] 	   = Util::formataDataFormBanco(strip_tags(addslashes(trim($_REQUEST["data_feriado"]))));
		$post["descricao_feriado"] = strip_tags(addslashes(trim($_REQUEST["descricao_feriado"])));
		$post["esfera_feriado"]    = strip_tags(addslashes(trim($_REQUEST["esfera_feriado"])));
		
		return $post;
	}
	static function formularioCadastroRhCargo($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["cd_cargo"] = strip_tags(addslashes(trim($_REQUEST["cd_cargo"])));
		}
		$post["descricao_cargo"] 	   = strip_tags(addslashes(trim($_REQUEST["descricao_cargo"])));
		$post["descricao_cargo_abrev"] = strip_tags(addslashes(trim($_REQUEST["descricao_cargo_abrev"])));
		$post["num_siape_cargo"]	   = strip_tags(addslashes(trim($_REQUEST["num_siape_cargo"])));
		$post["status"] 			   = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	static function formRhCargoComissao($post=NULL, $acao=NULL){
	    if($post == NULL)
	        $post = $_REQUEST;
		
		if($acao == 2){
			$post["cd_cargo_comissao"] = strip_tags(addslashes(trim($_REQUEST["cd_cargo_comissao"])));
		}
		$post["cd_lotacao"]  = strip_tags(addslashes(trim($_REQUEST["cd_lotacao"])));
		$post["cd_servidor"] = strip_tags(addslashes(trim($_REQUEST["cd_servidor"])));
		$post["descricao"]   = strip_tags(addslashes(trim($_REQUEST["descricao"])));
		$post["das"]         = strip_tags(addslashes(trim($_REQUEST["das"])));
		$post["status"]      = strip_tags(addslashes(trim($_REQUEST["status"])));
		
		return $post;
	}
	
	static function formularioCadastroRhRamal($acao=''){
		$post = array();
	
		if($acao == 2){
			$post["cd_ramal"] 	= strip_tags(addslashes(trim($_REQUEST["cd_ramal"])));
		}
		$post["cd_servidor"] 	= strip_tags(addslashes(trim($_REQUEST["cd_servidor"])));
		$post["cd_lotacao"] 	= strip_tags(addslashes(trim($_REQUEST["cd_lotacao"])));
		$post["ramal"] 			= strip_tags(addslashes(trim($_REQUEST["ramal"])));
		$post["descricao"] 		= strip_tags(addslashes(trim($_REQUEST["descricao"])));
		//$post["aSicasServidor"] = json_decode(urldecode($_REQUEST["aSicasServidor"]));
	
		return $post;
	}
		
	static function formularioCadastroHistorico($acao = ''){
		$post = array();
		
		if($acao == 2){
			$post["codigo"] = strip_tags(addslashes(trim($_REQUEST["codigo"])));
		}
		$post["data_historico"] = Util::formataDataHoraFormBanco(strip_tags(addslashes(trim($_REQUEST["data_historico"]))));
		$post["entidade"] = strip_tags(addslashes(trim($_REQUEST["entidade"])));
		$post["ip"] = strip_tags(addslashes(trim($_REQUEST["ip"])));
		$post["tipo_persistencia"] = strip_tags(addslashes(trim($_REQUEST["tipo_persistencia"])));
		$post["usuario"] = strip_tags(addslashes(trim($_REQUEST["usuario"])));
		$post["xml"] = strip_tags(addslashes(trim($_REQUEST["xml"])));
		
		return $post;
	}
}
