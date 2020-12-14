<?php
class SicasTipoAtendimento {
	public $cd_tipo_atendimento;
	public $nm_tipo_atendimento;
	public $fl_atendimento;
	public $pericia;
	public $status;
	function __construct($cd_tipo_atendimento = NULL, $nm_tipo_atendimento = NULL, $fl_atendimento = NULL, $pericia = NULL, $status = NULL) {
		$this->cd_tipo_atendimento = $cd_tipo_atendimento;
		$this->nm_tipo_atendimento = $nm_tipo_atendimento;
		$this->fl_atendimento = $fl_atendimento;
		$this->pericia = $pericia;
		$this->status = $status;
	}
}