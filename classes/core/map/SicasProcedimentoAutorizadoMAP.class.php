<?php
class SicasProcedimentoAutorizadoMAP {
	static function getMetaData($alias='sicas_procedimento_autorizado') {
		return array_merge([$alias => ['cd_procedimento_autorizado', 
		                               'cd_encaminhamento', 
                                       'cd_procedimento', 
		                               'qtd_servico_autorizado', 
		                               'status']], 
                		    SicasEncaminhamentoMAP::getMetaData(), 
                		    SicasProcedimentoMAP::getMetaData());
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

	static function objToRs($oSicasProcedimentoAutorizado){
		$reg['cd_procedimento_autorizado'] = $oSicasProcedimentoAutorizado->cd_procedimento_autorizado;
		$oSicasEncaminhamento = $oSicasProcedimentoAutorizado->oSicasEncaminhamento;
		$reg['cd_encaminhamento'] = $oSicasEncaminhamento->cd_encaminhamento;
		$oSicasProcedimento = $oSicasProcedimentoAutorizado->oSicasProcedimento;
		$reg['cd_procedimento'] = $oSicasProcedimento->cd_procedimento;
		$reg['qtd_servico_autorizado'] = $oSicasProcedimentoAutorizado->qtd_servico_autorizado;
		$reg['status'] = $oSicasProcedimentoAutorizado->status;
		return $reg;		   
	}

	static function objToRsInsert($oSicasProcedimentoAutorizado){
		$oSicasEncaminhamento = $oSicasProcedimentoAutorizado->oSicasEncaminhamento;
		$reg['cd_encaminhamento'] = $oSicasEncaminhamento->cd_encaminhamento;
		$oSicasProcedimento = $oSicasProcedimentoAutorizado->oSicasProcedimento;
		$reg['cd_procedimento'] = $oSicasProcedimento->cd_procedimento;
		$reg['qtd_servico_autorizado'] = $oSicasProcedimentoAutorizado->qtd_servico_autorizado;
		$reg['status'] = $oSicasProcedimentoAutorizado->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oSicasProcedimentoAutorizado = new SicasProcedimentoAutorizado();
		$oSicasProcedimentoAutorizado->cd_procedimento_autorizado = $reg['sicas_procedimento_autorizado_cd_procedimento_autorizado'];

		$oSicasEncaminhamento = new SicasEncaminhamento();
		$oSicasEncaminhamento->cd_encaminhamento = $reg['sicas_encaminhamento_cd_encaminhamento'];
		$oSicasEncaminhamento->dt_encaminhamento = $reg['sicas_encaminhamento_dt_encaminhamento'];
		$oSicasEncaminhamento->tipo_guia = $reg['sicas_encaminhamento_tipo_guia'];
		$oSicasEncaminhamento->status = $reg['sicas_encaminhamento_status'];
		
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
		
		
		$oSicasProcedimentoAutorizado->oSicasEncaminhamento = $oSicasEncaminhamento;

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
		$oSicasProcedimentoAutorizado->oSicasProcedimento = $oSicasProcedimento;
		$oSicasProcedimentoAutorizado->qtd_servico_autorizado = $reg['sicas_procedimento_autorizado_qtd_servico_autorizado'];
		$oSicasProcedimentoAutorizado->status = $reg['sicas_procedimento_autorizado_status'];
		
		$oSicasProcedimentoAutorizado->percentualDesconto = Calculadora::getDescontoServidor($reg['sicas_pessoa_cd_pessoa'], false);
		
		return $oSicasProcedimentoAutorizado;		   
	}
}
