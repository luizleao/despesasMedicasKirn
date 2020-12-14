<?php
class SicasEspecialidadeMedica {
	public $cd_especialidade_medica;
	public $nm_especialidade;
	public $status;
	function __construct($cd_especialidade_medica = NULL, $nm_especialidade = NULL, $status = NULL) {
		$this->cd_especialidade_medica = $cd_especialidade_medica;
		$this->nm_especialidade = $nm_especialidade;
		$this->status = $status;
	}
}