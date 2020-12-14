<?php
class SicasHistoricoImpressaoMAP {
	static function getMetaData($alias='sicas_historico_impressao') {
	    return array_merge([$alias => ['cd_carteira', 'cd_pessoa', 'dt_impressao']], 
	                       SicasPessoaMAP::getMetaData());
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
	
	static function objToRs($oSicasHistoricoImpressao) {
		$reg['cd_carteira']  = $oSicasHistoricoImpressao->cd_carteira;
		$oSicasPessoa        = $oSicasHistoricoImpressao->oSicasPessoa;
		$reg['cd_pessoa']    = $oSicasPessoa->cd_pessoa;
		$reg['dt_impressao'] = $oSicasHistoricoImpressao->dt_impressao;
		return $reg;
	}
	static function rsToObj($reg) {
		foreach($reg as $campo => $valor){
			$reg[$campo] = $valor;
		}
		$oSicasHistoricoImpressao = new SicasHistoricoImpressao();
		$oSicasHistoricoImpressao->cd_carteira = $reg['sicas_historico_impressao_cd_carteira'];
		
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
		$oSicasHistoricoImpressao->oSicasPessoa = $oSicasPessoa;
		$oSicasHistoricoImpressao->dt_impressao = $reg['sicas_historico_impressao_dt_impressao'];
		return $oSicasHistoricoImpressao;
	}
}
