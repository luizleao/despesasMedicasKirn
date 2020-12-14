<?php
class SicasConsultaMedicaCid {
	public $oSicasCid;
	public $cd_consulta_medica;
	function __construct(SicasCid $oSicasCid = NULL, $cd_consulta_medica = NULL) {
		$this->oSicasCid = $oSicasCid;
		$this->cd_consulta_medica = $cd_consulta_medica;
	}
}