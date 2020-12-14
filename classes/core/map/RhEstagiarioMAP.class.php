<?php
class RhEstagiarioMAP {
    static function getMetaData($alias='rh_estagiario') {
		return array_merge([$alias => ['cd_estagiario', 'cd_pessoa', 'cd_lotacao', 'cd_ies', 
		                               'num_processo', 'dt_inicio', 'dt_renovacao', 'status']], 
                            SicasPessoaMAP::getMetaData(), 
                            SicasLotacaoMAP::getMetaData(), 
                            RhIesMAP::getMetaData());
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

	static function objToRs($oRhEstagiario){
		$reg['cd_estagiario'] = $oRhEstagiario->cd_estagiario;
		$oSicasPessoa = $oRhEstagiario->oSicasPessoa;
		$reg['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$oSicasLotacao = $oRhEstagiario->oSicasLotacao;
		$reg['cd_lotacao'] = $oSicasLotacao->cd_lotacao;
		$oRhIes = $oRhEstagiario->oRhIes;
		$reg['cd_ies'] = $oRhIes->cd_ies;
		$reg['num_processo'] = $oRhEstagiario->num_processo;
		$reg['dt_inicio'] = $oRhEstagiario->dt_inicio;
		$reg['dt_renovacao'] = $oRhEstagiario->dt_renovacao;
		$reg['status'] = $oRhEstagiario->status;
		return $reg;		   
	}

	static function objToRsInsert($oRhEstagiario){
		$oSicasPessoa = $oRhEstagiario->oSicasPessoa;
		$reg['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$oSicasLotacao = $oRhEstagiario->oSicasLotacao;
		$reg['cd_lotacao'] = $oSicasLotacao->cd_lotacao;
		$oRhIes = $oRhEstagiario->oRhIes;
		$reg['cd_ies'] = $oRhIes->cd_ies;
		$reg['num_processo'] = $oRhEstagiario->num_processo;
		$reg['dt_inicio'] = $oRhEstagiario->dt_inicio;
		$reg['dt_renovacao'] = $oRhEstagiario->dt_renovacao;
		$reg['status'] = $oRhEstagiario->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
		$oRhEstagiario = new RhEstagiario();
		$oRhEstagiario->cd_estagiario = $reg['rh_estagiario_cd_estagiario'];

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
		$oSicasPessoa->tipo_identidade = $reg['sicas_pessoa_tipo_identidade'];
		$oSicasPessoa->descricao_perfil = $reg['sicas_pessoa_descricao_perfil'];
		$oSicasPessoa->fotoPerfil = $reg['sicas_pessoa_fotoPerfil'];
		$oSicasPessoa->usuario_proas = $reg['sicas_pessoa_usuario_proas'];
		$oRhEstagiario->oSicasPessoa = $oSicasPessoa;

		$oSicasLotacao = new SicasLotacao();
		$oSicasLotacao->cd_lotacao = $reg['sicas_lotacao_cd_lotacao'];
		$oSicasLotacao->sigla = $reg['sicas_lotacao_sigla'];
		$oSicasLotacao->cd_siged = $reg['sicas_lotacao_cd_siged'];
		$oSicasLotacao->nm_lotacao = $reg['sicas_lotacao_nm_lotacao'];
		$oSicasLotacao->status = $reg['sicas_lotacao_status'];
		$oRhEstagiario->oSicasLotacao = $oSicasLotacao;

		$oRhIes = new RhIes();
		$oRhIes->cd_ies = $reg['rh_ies_cd_ies'];
		$oRhIes->sigla = $reg['rh_ies_sigla'];
		$oRhIes->descricao = $reg['rh_ies_descricao'];
		$oRhIes->endereco = $reg['rh_ies_endereco'];
		$oRhIes->telefone1 = $reg['rh_ies_telefone1'];
		$oRhIes->telefone2 = $reg['rh_ies_telefone2'];
		$oRhIes->telefone3 = $reg['rh_ies_telefone3'];
		$oRhIes->email = $reg['rh_ies_email'];
		$oRhIes->status = $reg['rh_ies_status'];
		$oRhEstagiario->oRhIes = $oRhIes;
		$oRhEstagiario->num_processo = $reg['rh_estagiario_num_processo'];
		$oRhEstagiario->dt_inicio = $reg['rh_estagiario_dt_inicio'];
		$oRhEstagiario->dt_renovacao = $reg['rh_estagiario_dt_renovacao'];
		$oRhEstagiario->status = $reg['rh_estagiario_status'];
		return $oRhEstagiario;		   
	}
}
