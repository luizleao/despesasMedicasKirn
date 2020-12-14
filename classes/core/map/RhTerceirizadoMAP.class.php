<?php
class RhTerceirizadoMAP {
    static function getMetaData($alias='rh_terceirizado') {
		return array_merge([$alias => ['cd_terceirizado', 'cd_pessoa', 'cd_lotacao', 'cargo', 'status']], 
		                   SicasPessoaMAP::getMetaData(),
	                       SicasLotacaoMAP::getMetaData());
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

	static function objToRs($oRhTerceirizado){
		$reg['cd_terceirizado'] = $oRhTerceirizado->cd_terceirizado;
		$oSicasPessoa = $oRhTerceirizado->oSicasPessoa;
		$reg['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$oSicasLotacao = $oRhTerceirizado->oSicasLotacao;
		$reg['cd_lotacao'] = $oSicasLotacao->cd_lotacao;
		$reg['cargo'] = $oRhTerceirizado->cargo;
		$reg['status'] = $oRhTerceirizado->status;
		return $reg;		   
	}

	static function objToRsInsert($oRhTerceirizado){
		$oSicasPessoa = $oRhTerceirizado->oSicasPessoa;
		$reg['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$oSicasLotacao = $oRhTerceirizado->oSicasLotacao;
		$reg['cd_lotacao'] = $oSicasLotacao->cd_lotacao;
		$reg['cargo'] = $oRhTerceirizado->cargo;
		$reg['status'] = $oRhTerceirizado->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oRhTerceirizado = new RhTerceirizado();
		$oRhTerceirizado->cd_terceirizado = $reg['rh_terceirizado_cd_terceirizado'];

		$oSicasPessoa = new SicasPessoa();
		$oSicasPessoa->cd_pessoa = $reg['sicas_pessoa_cd_pessoa'];
		$oSicasPessoa->nm_pessoa = $reg['sicas_pessoa_nm_pessoa'];
		$oSicasPessoa->email = $reg['sicas_pessoa_email'];
		$oSicasPessoa->dt_nascimento = $reg['sicas_pessoa_dt_nascimento'];
		$oSicasPessoa->genero = $reg['sicas_pessoa_genero'];
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
		$oRhTerceirizado->oSicasPessoa = $oSicasPessoa;

		$oSicasLotacao = new SicasLotacao();
		$oSicasLotacao->cd_lotacao = $reg['sicas_lotacao_cd_lotacao'];
		$oSicasLotacao->sigla = $reg['sicas_lotacao_sigla'];
		$oSicasLotacao->cd_siged = $reg['sicas_lotacao_cd_siged'];
		$oSicasLotacao->nm_lotacao = $reg['sicas_lotacao_nm_lotacao'];
		$oSicasLotacao->status = $reg['sicas_lotacao_status'];
		$oRhTerceirizado->oSicasLotacao = $oSicasLotacao;
		$oRhTerceirizado->cargo = $reg['rh_terceirizado_cargo'];
		$oRhTerceirizado->status = $reg['rh_terceirizado_status'];
		return $oRhTerceirizado;		   
	}
}
