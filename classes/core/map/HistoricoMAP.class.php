<?php
class HistoricoMAP {
    static function getMetaData($alias='historico') {
		return [$alias => ['codigo', 'data_historico', 'entidade', 'ip', 
		                   'tipo_persistencia', 'usuario', 'xml']];
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
	
	static function objToRs($oHistorico) {
		$reg ['codigo'] = $oHistorico->codigo;
		$reg ['data_historico'] = $oHistorico->data_historico;
		$reg ['entidade'] = $oHistorico->entidade;
		$reg ['ip'] = $oHistorico->ip;
		$reg ['tipo_persistencia'] = $oHistorico->tipo_persistencia;
		$reg ['usuario'] = $oHistorico->usuario;
		$reg ['xml'] = $oHistorico->xml;
		return $reg;
	}
	static function rsToObj($reg) {
		foreach ( $reg as $campo => $valor ) {
			$reg [$campo] = $valor;
		}
		$oHistorico = new Historico ();
		$oHistorico->codigo = $reg ['historico_codigo'];
		$oHistorico->data_historico = $reg ['historico_data_historico'];
		$oHistorico->entidade = $reg ['historico_entidade'];
		$oHistorico->ip = $reg ['historico_ip'];
		$oHistorico->tipo_persistencia = $reg ['historico_tipo_persistencia'];
		$oHistorico->usuario = $reg ['historico_usuario'];
		$oHistorico->xml = $reg ['historico_xml'];
		return $oHistorico;
	}
}
