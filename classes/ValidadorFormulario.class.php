<?php
class ValidadorFormulario {
	public $msg;
	function __construct($msg = NULL){
		$this->msg = $msg;
	}
	function validaFormularioCadastroSicasAtendimento(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
		/*
		if($acao == 2){
		if($cd_atendimento == ''){
		$this->msg = "Cd_atendimento invalido!";
		return false;
		}
		}
		if($cd_pessoa == ''){
		$this->msg = "Sicas_pessoa invalido!";
		return false;
		}
		if($dt_ini_atendimento == ''){
		$this->msg = "Dt_ini_atendimento invalido!";
		return false;
		}
		if($dt_fim_atendimento == ''){
		$this->msg = "Dt_fim_atendimento invalido!";
		return false;
		}
		if($cd_medico == ''){
		$this->msg = "Sicas_medico invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasCid(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_cid == ''){
		$this->msg = "Cd_cid invalido!";
		return false;
		}
		}
		if($desc_cid == ''){
		$this->msg = "Desc_cid invalido!";
		return false;
		}
		if($desc_cid_abrev == ''){
		$this->msg = "Desc_cid_abrev invalido!";
		return false;
		}
		if($cd_cid_pai == ''){
		$this->msg = "Sicas_cid invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasConsultaMedica(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_consulta_medica == ''){
		$this->msg = "Cd_consulta_medica invalido!";
		return false;
		}
		}
		if($cd_atendimento == ''){
		$this->msg = "Sicas_atendimento invalido!";
		return false;
		}
		if($dt_consulta == ''){
		$this->msg = "Dt_consulta invalido!";
		return false;
		}
		if($cd_medico == ''){
		$this->msg = "Sicas_medico invalido!";
		return false;
		}
		if($qp_paciente == ''){
		$this->msg = "Qp_paciente invalido!";
		return false;
		}
		if($exame_fisico == ''){
		$this->msg = "Exame_fisico invalido!";
		return false;
		}
		if($exame_solicitado == ''){
		$this->msg = "Exame_solicitado invalido!";
		return false;
		}
		if($diag_paciente == ''){
		$this->msg = "Diag_paciente invalido!";
		return false;
		}
		if($cd_tipo_atendimento == ''){
		$this->msg = "Sicas_tipo_atendimento invalido!";
		return false;
		}
		if($resultado == ''){
		$this->msg = "Resultado invalido!";
		return false;
		}
		if($tratamento == ''){
		$this->msg = "Tratamento invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasConsultaMedicaCid(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($cd_cid == ''){
		$this->msg = "Sicas_cid invalido!";
		return false;
		}
		if($cd_consulta_medica == ''){
		$this->msg = "Cd_consulta_medica invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormSicasCredenciado(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_credenciado == ''){
		$this->msg = "Cd_credenciado invalido!";
		return false;
		}
		}
		if($nm_credenciado == ''){
		$this->msg = "Nm_credenciado invalido!";
		return false;
		}
		if($dt_nascimento == ''){
		$this->msg = "Dt_nascimento invalido!";
		return false;
		}
		if($hora_atendimento == ''){
		$this->msg = "Hora_atendimento invalido!";
		return false;
		}
		if($nm_servicos == ''){
		$this->msg = "Nm_servicos invalido!";
		return false;
		}
		if($profissional_liberal == ''){
		$this->msg = "Profissional_liberal invalido!";
		return false;
		}
		if($endereco == ''){
		$this->msg = "Endereco invalido!";
		return false;
		}
		if($complemento == ''){
		$this->msg = "Complemento invalido!";
		return false;
		}
		if($bairro == ''){
		$this->msg = "Bairro invalido!";
		return false;
		}
		if($cidade == ''){
		$this->msg = "Cidade invalido!";
		return false;
		}
		if($uf == ''){
		$this->msg = "Uf invalido!";
		return false;
		}
		if($cep == ''){
		$this->msg = "Cep invalido!";
		return false;
		}
		if($telefone1 == ''){
		$this->msg = "Telefone1 invalido!";
		return false;
		}
		if($telefone2 == ''){
		$this->msg = "Telefone2 invalido!";
		return false;
		}
		if($fax1 == ''){
		$this->msg = "Fax1 invalido!";
		return false;
		}
		if($ramal1 == ''){
		$this->msg = "Ramal1 invalido!";
		return false;
		}
		if($tipo == ''){
		$this->msg = "Tipo invalido!";
		return false;
		}
		if($cd_pis_pasep == ''){
		$this->msg = "Cd_pis_pasep invalido!";
		return false;
		}
		if($cpf == ''){
		$this->msg = "Cpf invalido!";
		return false;
		}
		if($cgc == ''){
		$this->msg = "Cgc invalido!";
		return false;
		}
		if($guia_prev_social == ''){
		$this->msg = "Guia_prev_social invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormSicasCredenciamento(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_credenciamento == ''){
		$this->msg = "Cd_credenciamento invalido!";
		return false;
		}
		}
		if($cd_credenciado == ''){
		$this->msg = "Sicas_credenciado invalido!";
		return false;
		}
		if($dt_ini_credenciamento == ''){
		$this->msg = "Dt_ini_credenciamento invalido!";
		return false;
		}
		if($dt_fim_credenciamento == ''){
		$this->msg = "Dt_fim_credenciamento invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasDependente(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_dependente == ''){
		$this->msg = "Cd_dependente invalido!";
		return false;
		}
		}
		if($cd_servidor == ''){
		$this->msg = "Sicas_servidor invalido!";
		return false;
		}
		if($cd_pessoa == ''){
		$this->msg = "Sicas_pessoa invalido!";
		return false;
		}
		if($cd_seq_dependente == ''){
		$this->msg = "Cd_seq_dependente invalido!";
		return false;
		}
		if($cd_grau_parentesco == ''){
		$this->msg = "Sicas_grau_parentesco invalido!";
		return false;
		}
		if($cd_escolaridade == ''){
		$this->msg = "Sicas_escolaridade invalido!";
		return false;
		}
		if($dt_inclusao == ''){
		$this->msg = "Dt_inclusao invalido!";
		return false;
		}
		if($dt_manutencao == ''){
		$this->msg = "Dt_manutencao invalido!";
		return false;
		}
		if($dependente_financ == ''){
		$this->msg = "Dependente_financ invalido!";
		return false;
		}
		if($dependente_proas == ''){
		$this->msg = "Dependente_proas invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasDespesa(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_despesa == ''){
		$this->msg = "Cd_despesa invalido!";
		return false;
		}
		}
		if($cd_procedimento_autorizado == ''){
		$this->msg = "Sicas_procedimento_autorizado invalido!";
		return false;
		}
		if($cd_salario == ''){
		$this->msg = "Sicas_salario invalido!";
		return false;
		}
		if($qtd_servico_realizado == ''){
		$this->msg = "Qtd_servico_realizado invalido!";
		return false;
		}
		if($val_servico_realizado == ''){
		$this->msg = "Val_servico_realizado invalido!";
		return false;
		}
		if($dt_atendimento == ''){
		$this->msg = "Dt_atendimento invalido!";
		return false;
		}
		if($dt_cadastro == ''){
		$this->msg = "Dt_cadastro invalido!";
		return false;
		}
		if($desconto_servidor == ''){
		$this->msg = "Desconto_servidor invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasDespesaGol(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_despesa_gol == ''){
		$this->msg = "Cd_despesa_gol invalido!";
		return false;
		}
		}
		if($ano_mes == ''){
		$this->msg = "Ano_mes invalido!";
		return false;
		}
		if($matricula == ''){
		$this->msg = "Matricula invalido!";
		return false;
		}
		if($cd_pessoa == ''){
		$this->msg = "Sicas_pessoa invalido!";
		return false;
		}
		if($cd_credenciado == ''){
		$this->msg = "Sicas_credenciado invalido!";
		return false;
		}
		if($vl_despesa == ''){
		$this->msg = "Vl_despesa invalido!";
		return false;
		}
		if($vl_d_despesa == ''){
		$this->msg = "Vl_d_despesa invalido!";
		return false;
		}
		if($porcentagem_desconto == ''){
		$this->msg = "Porcentagem_desconto invalido!";
		return false;
		}
		if($remuneracao == ''){
		$this->msg = "Remuneracao invalido!";
		return false;
		}
		if($cd_tipo_despesa == ''){
		$this->msg = "Sicas_tipo_despesa invalido!";
		return false;
		}
		if($flg_desconta == ''){
		$this->msg = "Flg_desconta invalido!";
		return false;
		}
		if($flg_fis_jur == ''){
		$this->msg = "Flg_fis_jur invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasEncaminhamento(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_encaminhamento == ''){
		$this->msg = "Cd_encaminhamento invalido!";
		return false;
		}
		}
		if($dt_encaminhamento == ''){
		$this->msg = "Dt_encaminhamento invalido!";
		return false;
		}
		if($cd_medico == ''){
		$this->msg = "Sicas_medico invalido!";
		return false;
		}
		if($cd_pessoa == ''){
		$this->msg = "Sicas_pessoa invalido!";
		return false;
		}
		if($cd_consulta_medica == ''){
		$this->msg = "Sicas_consulta_medica invalido!";
		return false;
		}
		if($cd_credenciado == ''){
		$this->msg = "Sicas_credenciado invalido!";
		return false;
		}
		if($tipo_guia == ''){
		$this->msg = "Tipo_guia invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		if($cd_tipo_despesa == ''){
		$this->msg = "Sicas_tipo_despesa invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasEscolaridade(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_escolaridade == ''){
		$this->msg = "Cd_escolaridade invalido!";
		return false;
		}
		}
		if($nm_escolaridade == ''){
		$this->msg = "Nm_escolaridade invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasEspecialidadeMedica(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_especialidade_medica == ''){
		$this->msg = "Cd_especialidade_medica invalido!";
		return false;
		}
		}
		if($nm_especialidade == ''){
		$this->msg = "Nm_especialidade invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasEspecialidadeMedicaCredenciado(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_especialidade_medica_credenciado == ''){
		$this->msg = "Cd_especialidade_medica_credenciado invalido!";
		return false;
		}
		}
		if($cd_credenciado == ''){
		$this->msg = "Sicas_credenciado invalido!";
		return false;
		}
		if($cd_especialidade_medica == ''){
		$this->msg = "Sicas_especialidade_medica invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasEstadoCivil(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_estado_civil == ''){
		$this->msg = "Cd_estado_civil invalido!";
		return false;
		}
		}
		if($nm_estado_civil == ''){
		$this->msg = "Nm_estado_civil invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	
	function validaFormSicasFatura(&$post, $acao = ''){
	    // cria variaveis para validacao com as chaves do array
	    foreach($post as $i => $v)
	        $$i = $v;
	        // valida formulario - Inicia comentado para facilitar depuracao
	        /*
	         if($acao == 2){
	         if($cd_fatura == ''){
	         $this->msg = "Cd_estado_civil invalido!";
	         return false;
	         }
	         }
	         if($nm_estado_civil == ''){
	         $this->msg = "Nm_estado_civil invalido!";
	         return false;
	         }
	         if($status == ''){
	         $this->msg = "Status invalido!";
	         return false;
	         }
	         */
	        return true;
	}
	
	
	function validaFormularioCadastroSicasGrauParentesco(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_grau_parentesco == ''){
		$this->msg = "Cd_grau_parentesco invalido!";
		return false;
		}
		}
		if($desc_grauparentesco == ''){
		$this->msg = "Desc_grauparentesco invalido!";
		return false;
		}
		if($nm_grau_parentesco == ''){
		$this->msg = "Nm_grau_parentesco invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasHistoricoImpressao(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_carteira == ''){
		$this->msg = "Cd_carteira invalido!";
		return false;
		}
		}
		if($cd_pessoa == ''){
		$this->msg = "Sicas_pessoa invalido!";
		return false;
		}
		if($dt_impressao == ''){
		$this->msg = "Dt_impressao invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasLotacao(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_lotacao == ''){
		$this->msg = "Cd_lotacao invalido!";
		return false;
		}
		}
		if($sigla == ''){
		$this->msg = "Sigla invalido!";
		return false;
		}
		if($cd_siged == ''){
		$this->msg = "Cd_siged invalido!";
		return false;
		}
		if($nm_lotacao == ''){
		$this->msg = "Nm_lotacao invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormSicasMedico(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_medico == ''){
		$this->msg = "Cd_medico invalido!";
		return false;
		}
		}
		if($login == ''){
		$this->msg = "Login invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasParamDesconto(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_param_desc == ''){
		$this->msg = "Cd_param_desc invalido!";
		return false;
		}
		}
		if($descricao_param == ''){
		$this->msg = "Descricao_param invalido!";
		return false;
		}
		if($percentagem_desconto == ''){
		$this->msg = "Percentagem_desconto invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasParamFaixaSalarial(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_param_faixa_sal == ''){
		$this->msg = "Cd_param_faixa_sal invalido!";
		return false;
		}
		}
		if($val_faixa_inicial == ''){
		$this->msg = "Val_faixa_inicial invalido!";
		return false;
		}
		if($flg_faixa_ini_inclusive == ''){
		$this->msg = "Flg_faixa_ini_inclusive invalido!";
		return false;
		}
		if($val_faixa_final == ''){
		$this->msg = "Val_faixa_final invalido!";
		return false;
		}
		if($flg_faixa_fin_inclusive == ''){
		$this->msg = "Flg_faixa_fin_inclusive invalido!";
		return false;
		}
		if($percentagem_desconto == ''){
		$this->msg = "Percentagem_desconto invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	
	function validaFormSicasPessoa(&$post, $acao=NULL){
		// cria variaveis para validacao com as chaves do array
		foreach ($post as $i => $v) $$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao

		  if($acao == 2){
		  	if($cd_pessoa == ''){
			  	$this->msg = "Pessoa inválido!";
			  	return false;
			  }
		  }
		  
		  if($nm_pessoa == ''){
		  	$this->msg = "Nome inválido!";
		  	return false;
		  }
		  
		  if($dt_nascimento == ''){
		      $this->msg = "Data de Nascimento inválida!";
		      return false;
		  }
		  
		  if($genero == ''){
		  	$this->msg = "Gênero inválido!";
		  	return false;
		  }

		  if($identidade == ''){
		  	$this->msg = "Identidade inválida!";
		  	return false;
		  }
		  
		  if($nm_orgao_emissor == ''){
		  	$this->msg = "Órgão Emissor inválido!";
		  	return false;
		  }
		  /*
		  if($tipo_beneficiario == ''){
		  	$this->msg = "Tipo de Beneficiario inválido!";
		  	return false;
		  }
		  
		  if($cd_categoria == ''){
		  	$this->msg = "Categoria inválida!";
		  	return false;
		  }
		  
		  if($email == ''){
			  $this->msg = "Email invalido!";
			  return false;
		  }

		  if($cd_estado_civil == ''){
			  $this->msg = "Sicas_estado_civil invalido!";
			  return false;
		  }

		  if($dt_emissao == ''){
			  $this->msg = "Dt_emissao invalido!";
			  return false;
		  }
		  if($cpf == ''){
		  $this->msg = "Cpf invalido!";
		  return false;
		  }
		  if($endereco == ''){
		  $this->msg = "Endereco invalido!";
		  return false;
		  }
		  if($complemento == ''){
		  $this->msg = "Complemento invalido!";
		  return false;
		  }
		  if($bairro == ''){
		  $this->msg = "Bairro invalido!";
		  return false;
		  }
		  if($cidade == ''){
		  $this->msg = "Cidade invalido!";
		  return false;
		  }
		  if($uf == ''){
		  $this->msg = "Uf invalido!";
		  return false;
		  }
		  if($cep == ''){
		  $this->msg = "Cep invalido!";
		  return false;
		  }
		  if($telefone == ''){
		  $this->msg = "Telefone invalido!";
		  return false;
		  }
		  if($grupo_sanguineo == ''){
		  $this->msg = "Grupo_sanguineo invalido!";
		  return false;
		  }
		  
		  if($status == ''){
		  $this->msg = "Status invalido!";
		  return false;
		  }
		  if($foto == ''){
		  $this->msg = "Foto invalido!";
		  return false;
		  }
		  
		  if($uf_identidade == ''){
		  $this->msg = "Uf_identidade invalido!";
		  return false;
		  }
		*/
		return true;
	}
	function validaFormularioCadastroSicasPessoaCategoria(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
		/*	
		  if($acao == 2){
		  if($cd_categoria == ''){
		  $this->msg = "Cd_categoria invalido!";
		  return false;
		  }
		  }
		  if($desc_categoria == ''){
		  $this->msg = "Desc_categoria invalido!";
		  return false;
		  }
		  if($desc_categoria_abrev == ''){
		  $this->msg = "Desc_categoria_abrev invalido!";
		  return false;
		  }
		*/
		return true;
	}
	function validaFormSicasProcedimento(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
		/*
		  if($acao == 2){
		  if($cd_procedimento == ''){
		  $this->msg = "Cd_procedimento invalido!";
		  return false;
		  }
		  }
		  if($num_procedimento == ''){
		  $this->msg = "Num_procedimento invalido!";
		  return false;
		  }
		  if($nm_procedimento == ''){
		  $this->msg = "Nm_procedimento invalido!";
		  return false;
		  }
		  if($num_custo_operacional == ''){
		  $this->msg = "Num_custo_operacional invalido!";
		  return false;
		  }
		  if($num_honorario == ''){
		  $this->msg = "Num_honorario invalido!";
		  return false;
		  }
		  if($num_med_filme == ''){
		  $this->msg = "Num_med_filme invalido!";
		  return false;
		  }
		  if($num_auxiliares == ''){
		  $this->msg = "Num_auxiliares invalido!";
		  return false;
		  }
		  if($num_port_anest == ''){
		  $this->msg = "Num_port_anest invalido!";
		  return false;
		  }
		  if($sigla == ''){
		  $this->msg = "Sigla invalido!";
		  return false;
		  }
		  if($red_registro == ''){
		  $this->msg = "Red_registro invalido!";
		  return false;
		  }
		  if($status == ''){
		  $this->msg = "Status invalido!";
		  return false;
		  }
		*/
		return true;
	}
	function validaFormularioCadastroSicasProcedimentoAutorizado(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_procedimento_autorizado == ''){
		$this->msg = "Cd_procedimento_autorizado invalido!";
		return false;
		}
		}
		if($cd_encaminhamento == ''){
		$this->msg = "Sicas_encaminhamento invalido!";
		return false;
		}
		if($cd_procedimento == ''){
		$this->msg = "Sicas_procedimento invalido!";
		return false;
		}
		if($qtd_servico_autorizado == ''){
		$this->msg = "Qtd_servico_autorizado invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormSicasSalario(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_salario == ''){
		$this->msg = "Cd_salario invalido!";
		return false;
		}
		}
		if($cd_servidor == ''){
		$this->msg = "Sicas_servidor invalido!";
		return false;
		}
		if($val_salario == ''){
		$this->msg = "Val_salario invalido!";
		return false;
		}
		if($dt_ini_salario == ''){
		$this->msg = "Dt_ini_salario invalido!";
		return false;
		}
		if($dt_fim_salario == ''){
		$this->msg = "Dt_fim_salario invalido!";
		return false;
		}
		if($serv_efetivo == ''){
		$this->msg = "Serv_efetivo invalido!";
		return false;
		}
		if($obs == ''){
		$this->msg = "Obs invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormSicasSalarioMinimo(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_salario_minimo == ''){
		$this->msg = "Cd_salario_minimo invalido!";
		return false;
		}
		}
		if($valor == ''){
		$this->msg = "Valor invalido!";
		return false;
		}
		if($dt_cadastro == ''){
		$this->msg = "Dt_cadastro invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	
	function validaFormSicasServidor(&$post, $acao=NULL){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
		// valida formulario - Inicia comentado para facilitar depuracao	 
		if($acao == 2){
			if($cd_servidor == ''){
			  	$this->msg = "Servidor invalido!";
			  	return false;
	  		}
	  	}
	  
		if($cd_pessoa == ''){
			$this->msg = "Pessoa invalida!";
			return false;
		}
	  
		if($cd_matricula == ''){
			$this->msg = "Matricula invalida!";
			return false;
		}
		if($cd_lotacao == ''){
			$this->msg = "Lotação invalida!";
			return false;
		}
	  
		if($cd_cargo == ''){
			$this->msg = "Cargo invalido!";
			return false;
		}
		return true;
	}

	function validaFormularioCadastroSicasTipoAtendimento(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_tipo_atendimento == ''){
		$this->msg = "Cd_tipo_atendimento invalido!";
		return false;
		}
		}
		if($nm_tipo_atendimento == ''){
		$this->msg = "Nm_tipo_atendimento invalido!";
		return false;
		}
		if($fl_atendimento == ''){
		$this->msg = "Fl_atendimento invalido!";
		return false;
		}
		if($pericia == ''){
		$this->msg = "Pericia invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroSicasTipoDespesa(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_tipo_despesa == ''){
		$this->msg = "Cd_tipo_despesa invalido!";
		return false;
		}
		}
		if($nm_despesa == ''){
		$this->msg = "Nm_despesa invalido!";
		return false;
		}
		if($credenciado == ''){
		$this->msg = "Credenciado invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	
	
	function validaFormularioCadastroRhIes(&$post, $acao=''){
	    // cria variaveis para validacao com as chaves do array
	    foreach($post as $i => $v)
	        $$i = $v;
	        // valida formulario - Inicia comentado para facilitar depuracao
	        /*
	         if($acao == 2){
	         if($cd_ies == ''){
	         $this->msg = "Cd_ies inválido!";
	         return false;
	         }
	         }
	         if($sigla == ''){
	         $this->msg = "Sigla inválido!";
	         return false;
	         }
	         if($descricao == ''){
	         $this->msg = "Descricao inválido!";
	         return false;
	         }
	         if($endereco == ''){
	         $this->msg = "Endereco inválido!";
	         return false;
	         }
	         if($telefone == ''){
	         $this->msg = "Telefone inválido!";
	         return false;
	         }
	         if($status == ''){
	         $this->msg = "Status inválido!";
	         return false;
	         }
	         */
	        return true;
	}
	
	function validaFormularioCadastroRhEstagiario(&$post, $acao=''){
	    // cria variaveis para validacao com as chaves do array
	    foreach($post as $i => $v)
	        $$i = $v;
	        // valida formulario - Inicia comentado para facilitar depuracao
	        /*
	         if($acao == 2){
	         if($cd_estagiario == ''){
	         $this->msg = "Cd_estagiario inválido!";
	         return false;
	         }
	         }
	         if($cd_pessoa == ''){
	         $this->msg = "Sicas_pessoa inválido!";
	         return false;
	         }
	         if($cd_lotacao == ''){
	         $this->msg = "Sicas_lotacao inválido!";
	         return false;
	         }
	         if($cd_ies == ''){
	         $this->msg = "Rh_ies inválido!";
	         return false;
	         }
	         if($num_processo == ''){
	         $this->msg = "Num_processo inválido!";
	         return false;
	         }
	         if($dt_inicio == ''){
	         $this->msg = "Dt_inicio inválido!";
	         return false;
	         }
	         if($dt_renovacao == ''){
	         $this->msg = "Dt_renovacao inválido!";
	         return false;
	         }
	         if($status == ''){
	         $this->msg = "Status inválido!";
	         return false;
	         }
	         */
	        return true;
	}
	
	function validaFormularioCadastroRhFeriado(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_feriado == ''){
		$this->msg = "Cd_feriado invalido!";
		return false;
		}
		}
		if($data_feriado == ''){
		$this->msg = "Data_feriado invalido!";
		return false;
		}
		if($descricao_feriado == ''){
		$this->msg = "Descricao_feriado invalido!";
		return false;
		}
		if($esfera_feriado == ''){
		$this->msg = "Esfera_feriado invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormularioCadastroRhCargo(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_cargo == ''){
		$this->msg = "Cd_cargo invalido!";
		return false;
		}
		}
		if($descricao_cargo == ''){
		$this->msg = "Descricao_cargo invalido!";
		return false;
		}
		if($descricao_cargo_abrev == ''){
		$this->msg = "Descricao_cargo_abrev invalido!";
		return false;
		}
		if($num_siape_cargo == ''){
		$this->msg = "Num_siape_cargo invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	function validaFormRhCargoComissao(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($cd_cargo == ''){
		$this->msg = "Cd_cargo invalido!";
		return false;
		}
		}
		if($descricao_cargo == ''){
		$this->msg = "Descricao_cargo invalido!";
		return false;
		}
		if($descricao_cargo_abrev == ''){
		$this->msg = "Descricao_cargo_abrev invalido!";
		return false;
		}
		if($num_siape_cargo == ''){
		$this->msg = "Num_siape_cargo invalido!";
		return false;
		}
		if($status == ''){
		$this->msg = "Status invalido!";
		return false;
		}
		 */
		return true;
	}
	
	function validaFormularioCadastroRhRamal(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
		// valida formulario - Inicia comentado para facilitar depuracao
		if($acao == 2){
			if($cd_ramal == ''){
				$this->msg = "Código do Ramal invalido!";
				return false;
			}
		}
		if($cd_lotacao == ''){
			$this->msg = "Selecione a Lotação";
			return false;
		}
		if($ramal == ''){
			$this->msg = "Ramal inválido!";
			return false;
		}
		return true;
	}	
	
	function validaFormularioCadastroHistorico(&$post, $acao = ''){
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = $v;
			// valida formulario - Inicia comentado para facilitar depuracao
			/*
		if($acao == 2){
		if($codigo == ''){
		$this->msg = "Codigo invalido!";
		return false;
		}
		}
		if($data_historico == ''){
		$this->msg = "Data_historico invalido!";
		return false;
		}
		if($entidade == ''){
		$this->msg = "Entidade invalido!";
		return false;
		}
		if($ip == ''){
		$this->msg = "Ip invalido!";
		return false;
		}
		if($tipo_persistencia == ''){
		$this->msg = "Tipo_persistencia invalido!";
		return false;
		}
		if($usuario == ''){
		$this->msg = "Usuario invalido!";
		return false;
		}
		if($xml == ''){
		$this->msg = "Xml invalido!";
		return false;
		}
		 */
		return true;
	}
}