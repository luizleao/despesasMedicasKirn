<?php
class RhCargoComissaoMAP {
    static function getMetaData($alias='rh_cargo_comissao') {
		return array_merge([$alias => ['cd_cargo_comissao','cd_lotacao','cd_servidor','descricao','das', 'status']],
			                SicasServidorMAP::getMetaData());
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
	
	static function objToRs($oRhCargoComissao){
		$reg['cd_cargo_comissao'] = $oRhCargoComissao->cd_cargo_comissao;
		$oSicasLotacao            = $oRhCargoComissao->oSicasLotacao;
		$reg['cd_lotacao']        = $oSicasLotacao->cd_lotacao;
		$oSicasServidor           = $oRhCargoComissao->oSicasServidor;
		$reg['cd_servidor']       = $oSicasServidor->cd_servidor;
		$reg['descricao']         = $oRhCargoComissao->descricao;
		$reg['das']               = $oRhCargoComissao->das;
		$reg['status']            = $oRhCargoComissao->status;
		return $reg;
	}
	
	static function objToRsInsert($oRhCargoComissao){
	    $oSicasLotacao            = $oRhCargoComissao->oSicasLotacao;
	    $reg['cd_lotacao']        = $oSicasLotacao->cd_lotacao;
	    $oSicasServidor           = $oRhCargoComissao->oSicasServidor;
	    $reg['cd_servidor']       = $oSicasServidor->cd_servidor;
	    $reg['descricao']         = $oRhCargoComissao->descricao;
	    $reg['das']               = $oRhCargoComissao->das;
	    $reg['status']            = $oRhCargoComissao->status;
	    return $reg;
	}
	
	static function rsToObj($reg) {
		foreach($reg as $campo => $valor){
			$reg[$campo] = $valor;
		}
		$oRhCargoComissao = new RhCargoComissao();
		$oRhCargoComissao->cd_cargo_comissao = $reg['rh_cargo_comissao_cd_cargo_comissao'];
		$oRhCargoComissao->cd_lotacao        = $reg['rh_cargo_comissao_cd_lotacao'];
		$oRhCargoComissao->cd_servidor       = $reg['rh_cargo_comissao_cd_servidor'];
		$oRhCargoComissao->descricao         = $reg['rh_cargo_comissao_descricao'];
		$oRhCargoComissao->das               = $reg['rh_cargo_comissao_das'];
		$oRhCargoComissao->status            = $reg['rh_cargo_comissao_status'];
		
		$oSicasPessoa = new SicasPessoa();
		$oSicasPessoa->cd_pessoa 	 = $reg['sicas_pessoa_cd_pessoa'];
		$oSicasPessoa->nm_pessoa 	 = $reg['sicas_pessoa_nm_pessoa'];
		$oSicasPessoa->email 		 = $reg['sicas_pessoa_email'];
		$oSicasPessoa->dt_nascimento = $reg['sicas_pessoa_dt_nascimento'];
		$oSicasPessoa->genero		 = $reg['sicas_pessoa_genero'];

		$oSicasEstadoCivil = new SicasEstadoCivil();
		$oSicasEstadoCivil->cd_estado_civil = $reg['sicas_estado_civil_cd_estado_civil'];
		$oSicasEstadoCivil->nm_estado_civil = $reg['sicas_estado_civil_nm_estado_civil'];
		$oSicasEstadoCivil->status 			= $reg['sicas_estado_civil_status'];
		$oSicasPessoa->oSicasEstadoCivil 	= $oSicasEstadoCivil;
		$oSicasPessoa->identidade 			= $reg['sicas_pessoa_identidade'];
		$oSicasPessoa->nm_orgao_emissor 	= $reg['sicas_pessoa_nm_orgao_emissor'];
		$oSicasPessoa->dt_emissao 			= $reg['sicas_pessoa_dt_emissao'];
		$oSicasPessoa->cpf 					= $reg['sicas_pessoa_cpf'];
		$oSicasPessoa->endereco 			= $reg['sicas_pessoa_endereco'];
		$oSicasPessoa->complemento 			= $reg['sicas_pessoa_complemento'];
		$oSicasPessoa->bairro 				= $reg['sicas_pessoa_bairro'];
		$oSicasPessoa->cidade 				= $reg['sicas_pessoa_cidade'];
		$oSicasPessoa->uf 					= $reg['sicas_pessoa_uf'];
		$oSicasPessoa->cep 					= $reg['sicas_pessoa_cep'];
		$oSicasPessoa->telefone 			= $reg['sicas_pessoa_telefone'];
		$oSicasPessoa->grupo_sanguineo 		= $reg['sicas_pessoa_grupo_sanguineo'];
		$oSicasPessoa->tipo_beneficiario 	= $reg['sicas_pessoa_tipo_beneficiario'];
		$oSicasPessoa->status 				= $reg['sicas_pessoa_status'];
		$oSicasPessoa->foto 				= $reg['sicas_pessoa_foto'];
		
		$oSicasPessoaCategoria = new SicasPessoaCategoria();
		$oSicasPessoaCategoria->cd_categoria 		 = $reg['sicas_pessoa_categoria_cd_categoria'];
		$oSicasPessoaCategoria->desc_categoria 		 = $reg['sicas_pessoa_categoria_desc_categoria'];
		$oSicasPessoaCategoria->desc_categoria_abrev = $reg['sicas_pessoa_categoria_desc_categoria_abrev'];
		$oSicasPessoa->oSicasPessoaCategoria 		 = $oSicasPessoaCategoria;
		$oSicasPessoa->uf_identidade 				 = $reg['sicas_pessoa_uf_identidade'];
		
		$oSicasServidor = new SicasServidor();
		$oSicasServidor->cd_servidor 	  = $reg['sicas_servidor_cd_servidor'];
		$oSicasServidor->cd_matricula 	  = $reg['sicas_servidor_cd_matricula'];
		$oSicasServidor->status 		  = $reg['sicas_servidor_status'];
		$oSicasServidor->serv_efetivo 	  = $reg['sicas_servidor_serv_efetivo'];
		$oSicasServidor->ramal1 		  = $reg['sicas_servidor_ramal1'];
		$oSicasServidor->ramal2 		  = $reg['sicas_servidor_ramal2'];
		$oSicasServidor->ramal3 		  = $reg['sicas_servidor_ramal3'];
		$oSicasServidor->foto 			  = $reg['sicas_servidor_foto'];
		$oSicasServidor->descricao_perfil = $reg['sicas_servidor_descricao_perfil'];
		$oSicasServidor->usuario_proas    = $reg['sicas_servidor_usuario_proas'];
		$oSicasServidor->vl_saldo_odonto  = $reg['sicas_servidor_vl_saldo_odonto'];
		
		$oCategoriaServidor = new SicasPessoaCategoria();
		$oCategoriaServidor->cd_categoria         = $reg['categoria_servidor_cd_categoria'];
		$oCategoriaServidor->desc_categoria       = $reg['categoria_servidor_desc_categoria'];
		$oCategoriaServidor->desc_categoria_abrev = $reg['categoria_servidor_desc_categoria_abrev'];
		
		$oSicasServidor->oSicasPessoaCategoria = $oCategoriaServidor;
		$oSicasServidor->oSicasPessoa = $oSicasPessoa;
		$oSicasServidor->cd_matricula = $reg['sicas_servidor_cd_matricula'];
		
		$oSicasLotacao = new SicasLotacao();
		$oSicasLotacao->cd_lotacao 	   = $reg['sicas_lotacao_cd_lotacao'];
		$oSicasLotacao->sigla 		   = $reg['sicas_lotacao_sigla'];
		$oSicasLotacao->cd_siged 	   = $reg['sicas_lotacao_cd_siged'];
		$oSicasLotacao->nm_lotacao 	   = $reg['sicas_lotacao_nm_lotacao'];
		$oSicasLotacao->status 		   = $reg['sicas_lotacao_status'];
		$oSicasServidor->oSicasLotacao = $oSicasLotacao;

		$oRhCargoComissao->oSicasServidor = $oSicasServidor;
		$oRhCargoComissao->oSicasLotacao  = $oSicasLotacao;

		return $oRhCargoComissao;
	}
}
