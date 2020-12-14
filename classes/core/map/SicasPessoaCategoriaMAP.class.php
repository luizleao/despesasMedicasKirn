<?php
class SicasPessoaCategoriaMAP {
    static function getMetaData($alias='sicas_pessoa_categoria') {
        return [$alias => ['cd_categoria', 'desc_categoria', 'desc_categoria_abrev']];
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
	
	static function objToRs($oSicasPessoaCategoria) {
		$reg ['cd_categoria'] = $oSicasPessoaCategoria->cd_categoria;
		$reg ['desc_categoria'] = $oSicasPessoaCategoria->desc_categoria;
		$reg ['desc_categoria_abrev'] = $oSicasPessoaCategoria->desc_categoria_abrev;
		return $reg;
	}
	
	static function objToRsInsert($oSicasPessoaCategoria) {
	    $reg ['desc_categoria'] = $oSicasPessoaCategoria->desc_categoria;
	    $reg ['desc_categoria_abrev'] = $oSicasPessoaCategoria->desc_categoria_abrev;
	    return $reg;
	}
	
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg [$campo] = $valor;
		}
		$oSicasPessoaCategoria = new SicasPessoaCategoria ();
		$oSicasPessoaCategoria->cd_categoria = $reg ['sicas_pessoa_categoria_cd_categoria'];
		$oSicasPessoaCategoria->desc_categoria = $reg ['sicas_pessoa_categoria_desc_categoria'];
		$oSicasPessoaCategoria->desc_categoria_abrev = $reg ['sicas_pessoa_categoria_desc_categoria_abrev'];
		return $oSicasPessoaCategoria;
	}
}
