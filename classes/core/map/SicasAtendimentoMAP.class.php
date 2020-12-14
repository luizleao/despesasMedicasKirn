<?php
class SicasAtendimentoMAP {
	static function getMetaData($alias='sicas_atendimento') {
	    return [$alias => ['cd_pessoa',
                	        'dt_ini_atendimento',
                	        'dt_fim_atendimento',
                	        'cd_medico',
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
	
	static function objToRsInsert($oSicasAtendimento) {
	    $oSicasPessoa = $oSicasAtendimento->oSicasPessoa;
	    $reg ['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
	    $reg ['dt_ini_atendimento'] = $oSicasAtendimento->dt_ini_atendimento;
	    $reg ['dt_fim_atendimento'] = $oSicasAtendimento->dt_fim_atendimento;
	    $oSicasMedico = $oSicasAtendimento->oSicasMedico;
	    $reg ['cd_medico'] = $oSicasMedico->cd_medico;
	    $reg ['status'] = $oSicasAtendimento->status;
	    return $reg;
	}
	
	static function objToRs($oSicasAtendimento) {
		$reg ['cd_atendimento'] = $oSicasAtendimento->cd_atendimento;
		$oSicasPessoa = $oSicasAtendimento->oSicasPessoa;
		$reg ['cd_pessoa'] = $oSicasPessoa->cd_pessoa;
		$reg ['dt_ini_atendimento'] = $oSicasAtendimento->dt_ini_atendimento;
		$reg ['dt_fim_atendimento'] = $oSicasAtendimento->dt_fim_atendimento;
		$oSicasMedico = $oSicasAtendimento->oSicasMedico;
		$reg ['cd_medico'] = $oSicasMedico->cd_medico;
		$reg ['status'] = $oSicasAtendimento->status;
		return $reg;
	}
	
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg [$campo] = $valor;
		}
		$oSicasAtendimento = new SicasAtendimento ();
		$oSicasAtendimento->cd_atendimento = $reg ['sicas_atendimento_cd_atendimento'];
		
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
		$oSicasAtendimento->oSicasPessoa = $oSicasPessoa;
		$oSicasAtendimento->dt_ini_atendimento = $reg ['sicas_atendimento_dt_ini_atendimento'];
		$oSicasAtendimento->dt_fim_atendimento = $reg ['sicas_atendimento_dt_fim_atendimento'];
		
		$oSicasMedico = new SicasMedico ();
		$oSicasMedico->cd_medico = $reg ['sicas_medico_cd_medico'];
		$oSicasMedico->login = $reg ['sicas_medico_login'];
		$oSicasMedico->status = $reg ['sicas_medico_status'];
		$oSicasAtendimento->oSicasMedico = $oSicasMedico;
		$oSicasAtendimento->status = $reg ['sicas_atendimento_status'];
		return $oSicasAtendimento;
	}
}
