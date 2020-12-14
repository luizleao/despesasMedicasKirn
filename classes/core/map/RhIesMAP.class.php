<?php
class RhIesMAP {

    static function getMetaData($alias='rh_ies') {
		return [$alias => ['cd_ies', 'sigla', 'descricao', 'endereco', 'telefone1', 
		                   'telefone2', 'telefone3', 'email', 'status']];
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

	static function objToRs($oRhIes){
		$reg['cd_ies'] = $oRhIes->cd_ies;
		$reg['sigla'] = $oRhIes->sigla;
		$reg['descricao'] = $oRhIes->descricao;
		$reg['endereco'] = $oRhIes->endereco;
		$reg['telefone1'] = $oRhIes->telefone1;
		$reg['telefone2'] = $oRhIes->telefone2;
		$reg['telefone3'] = $oRhIes->telefone3;
		$reg['email'] = $oRhIes->email;
		$reg['status'] = $oRhIes->status;
		return $reg;		   
	}

	static function objToRsInsert($oRhIes){
		$reg['sigla'] = $oRhIes->sigla;
		$reg['descricao'] = $oRhIes->descricao;
		$reg['endereco'] = $oRhIes->endereco;
		$reg['telefone1'] = $oRhIes->telefone1;
		$reg['telefone2'] = $oRhIes->telefone2;
		$reg['telefone3'] = $oRhIes->telefone3;
		$reg['email'] = $oRhIes->email;
		$reg['status'] = $oRhIes->status;
		return $reg;		   
	}
	
	static function rsToObj($reg){
		foreach($reg as $campo=>$valor){
			$reg[$campo] = $valor;
		}
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
		return $oRhIes;		   
	}
}
