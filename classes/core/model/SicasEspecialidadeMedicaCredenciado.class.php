<?php
class SicasEspecialidadeMedicaCredenciado {
	public $cd_especialidade_medica_credenciado;
	public $oSicasCredenciado;
	public $oSicasEspecialidadeMedica;
	public $status;
	function __construct($cd_especialidade_medica_credenciado = NULL, SicasCredenciado $oSicasCredenciado = NULL, SicasEspecialidadeMedica $oSicasEspecialidadeMedica = NULL, $status = NULL) {
		$this->cd_especialidade_medica_credenciado = $cd_especialidade_medica_credenciado;
		$this->oSicasCredenciado 				   = $oSicasCredenciado;
		$this->oSicasEspecialidadeMedica 		   = $oSicasEspecialidadeMedica;
		$this->status = $status;
	}
}