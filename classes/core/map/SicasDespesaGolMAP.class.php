<?php
class SicasDespesaGolMAP {
	static function getMetaData($alias='sicas_despesa_gol') {
	    return array_merge([$alias => ['cd_despesa_gol',
                                	    'ano_mes',
                                	    'matricula',
                                	    'cd_pessoa',
                                	    'cd_credenciado',
                                	    'vl_despesa',
                                	    'vl_d_despesa',
                                	    'porcentagem_desconto',
                                	    'remuneracao',
                                	    'cd_tipo_despesa',
                                	    'flg_desconta',
                                	    'flg_fis_jur']],
	        SicasPessoaMAP::getMetaData(),
	        SicasCredenciadoMAP::getMetaData(),
	        SicasTipoDespesaMAP::getMetaData());
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
	
	static function objToRs($oSicasDespesaGol) {
		$reg ['cd_despesa_gol'] = $oSicasDespesaGol->cd_despesa_gol;
		$reg ['ano_mes'] = $oSicasDespesaGol->ano_mes;
		$reg ['matricula'] = $oSicasDespesaGol->matricula;
		$oSicasPessoa = $oSicasDespesaGol->oSicasPessoa;
		$reg ['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$oSicasCredenciado = $oSicasDespesaGol->oSicasCredenciado;
		$reg ['cd_credenciado'] = $oSicasCredenciado->cd_credenciado;
		$reg ['vl_despesa'] = $oSicasDespesaGol->vl_despesa;
		$reg ['vl_d_despesa'] = $oSicasDespesaGol->vl_d_despesa;
		$reg ['porcentagem_desconto'] = $oSicasDespesaGol->porcentagem_desconto;
		$reg ['remuneracao'] = $oSicasDespesaGol->remuneracao;
		$oSicasTipoDespesa = $oSicasDespesaGol->oSicasTipoDespesa;
		$reg ['cd_tipo_despesa'] = $oSicasTipoDespesa->cd_tipo_despesa;
		$reg ['flg_desconta'] = $oSicasDespesaGol->flg_desconta;
		$reg ['flg_fis_jur'] = $oSicasDespesaGol->flg_fis_jur;
		return $reg;
	}
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg [$campo] = $valor;
		}
		$oSicasDespesaGol = new SicasDespesaGol ();
		$oSicasDespesaGol->cd_despesa_gol = $reg ['sicas_despesa_gol_cd_despesa_gol'];
		$oSicasDespesaGol->ano_mes = $reg ['sicas_despesa_gol_ano_mes'];
		$oSicasDespesaGol->matricula = $reg ['sicas_despesa_gol_matricula'];
		
		$oSicasPessoa = new SicasPessoa ();
		$oSicasPessoa->cd_pessoa = $reg ['sicas_pessoa_cd_pessoa'];
		$oSicasPessoa->nm_pessoa = $reg ['sicas_pessoa_nm_pessoa'];
		$oSicasPessoa->email = $reg ['sicas_pessoa_email'];
		$oSicasPessoa->dt_nascimento = $reg ['sicas_pessoa_dt_nascimento'];
		$oSicasPessoa->genero = $reg ['sicas_pessoa_genero'];
		$oSicasPessoa->identidade = $reg ['sicas_pessoa_identidade'];
		$oSicasPessoa->nm_orgao_emissor = $reg ['sicas_pessoa_nm_orgao_emissor'];
		$oSicasPessoa->dt_emissao = $reg ['sicas_pessoa_dt_emissao'];
		$oSicasPessoa->cpf = $reg ['sicas_pessoa_cpf'];
		$oSicasPessoa->endereco = $reg ['sicas_pessoa_endereco'];
		$oSicasPessoa->complemento = $reg ['sicas_pessoa_complemento'];
		$oSicasPessoa->bairro = $reg ['sicas_pessoa_bairro'];
		$oSicasPessoa->cidade = $reg ['sicas_pessoa_cidade'];
		$oSicasPessoa->uf = $reg ['sicas_pessoa_uf'];
		$oSicasPessoa->cep = $reg ['sicas_pessoa_cep'];
		$oSicasPessoa->telefone = $reg ['sicas_pessoa_telefone'];
		$oSicasPessoa->grupo_sanguineo = $reg ['sicas_pessoa_grupo_sanguineo'];
		$oSicasPessoa->tipo_beneficiario = $reg ['sicas_pessoa_tipo_beneficiario'];
		$oSicasPessoa->status = $reg ['sicas_pessoa_status'];
		$oSicasPessoa->foto = $reg ['sicas_pessoa_foto'];
		$oSicasPessoa->uf_identidade = $reg ['sicas_pessoa_uf_identidade'];
		$oSicasDespesaGol->oSicasPessoa = $oSicasPessoa;
		
		$oSicasCredenciado = new SicasCredenciado ();
		$oSicasCredenciado->cd_credenciado = $reg ['sicas_credenciado_cd_credenciado'];
		$oSicasCredenciado->nm_credenciado = $reg ['sicas_credenciado_nm_credenciado'];
		$oSicasCredenciado->dt_nascimento = $reg ['sicas_credenciado_dt_nascimento'];
		$oSicasCredenciado->hora_atendimento = $reg ['sicas_credenciado_hora_atendimento'];
		$oSicasCredenciado->nm_servicos = $reg ['sicas_credenciado_nm_servicos'];
		$oSicasCredenciado->profissional_liberal = $reg ['sicas_credenciado_profissional_liberal'];
		$oSicasCredenciado->endereco = $reg ['sicas_credenciado_endereco'];
		$oSicasCredenciado->complemento = $reg ['sicas_credenciado_complemento'];
		$oSicasCredenciado->bairro = $reg ['sicas_credenciado_bairro'];
		$oSicasCredenciado->cidade = $reg ['sicas_credenciado_cidade'];
		$oSicasCredenciado->uf = $reg ['sicas_credenciado_uf'];
		$oSicasCredenciado->cep = $reg ['sicas_credenciado_cep'];
		$oSicasCredenciado->telefone1 = $reg ['sicas_credenciado_telefone1'];
		$oSicasCredenciado->telefone2 = $reg ['sicas_credenciado_telefone2'];
		$oSicasCredenciado->fax1 = $reg ['sicas_credenciado_fax1'];
		$oSicasCredenciado->ramal1 = $reg ['sicas_credenciado_ramal1'];
		$oSicasCredenciado->tipo = $reg ['sicas_credenciado_tipo'];
		$oSicasCredenciado->cd_pis_pasep = $reg ['sicas_credenciado_cd_pis_pasep'];
		$oSicasCredenciado->cpf = $reg ['sicas_credenciado_cpf'];
		$oSicasCredenciado->cgc = $reg ['sicas_credenciado_cgc'];
		$oSicasCredenciado->guia_prev_social = $reg ['sicas_credenciado_guia_prev_social'];
		$oSicasCredenciado->status = $reg ['sicas_credenciado_status'];
		$oSicasDespesaGol->oSicasCredenciado = $oSicasCredenciado;
		$oSicasDespesaGol->vl_despesa = $reg ['sicas_despesa_gol_vl_despesa'];
		$oSicasDespesaGol->vl_d_despesa = $reg ['sicas_despesa_gol_vl_d_despesa'];
		$oSicasDespesaGol->porcentagem_desconto = $reg ['sicas_despesa_gol_porcentagem_desconto'];
		$oSicasDespesaGol->remuneracao = $reg ['sicas_despesa_gol_remuneracao'];
		
		$oSicasTipoDespesa = new SicasTipoDespesa ();
		$oSicasTipoDespesa->cd_tipo_despesa = $reg ['sicas_tipo_despesa_cd_tipo_despesa'];
		$oSicasTipoDespesa->nm_despesa = $reg ['sicas_tipo_despesa_nm_despesa'];
		$oSicasTipoDespesa->credenciado = $reg ['sicas_tipo_despesa_credenciado'];
		$oSicasTipoDespesa->status = $reg ['sicas_tipo_despesa_status'];
		$oSicasDespesaGol->oSicasTipoDespesa = $oSicasTipoDespesa;
		$oSicasDespesaGol->flg_desconta = $reg ['sicas_despesa_gol_flg_desconta'];
		$oSicasDespesaGol->flg_fis_jur = $reg ['sicas_despesa_gol_flg_fis_jur'];
		return $oSicasDespesaGol;
	}
}
