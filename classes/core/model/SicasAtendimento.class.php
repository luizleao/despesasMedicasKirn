<?php
class SicasAtendimento {
	public $cd_atendimento;
	public $oSicasPessoa;
	public $dt_ini_atendimento;
	public $dt_fim_atendimento;
	public $oSicasMedico;
	public $status;
	function __construct($cd_atendimento = NULL, SicasPessoa $oSicasPessoa = NULL, $dt_ini_atendimento = NULL, $dt_fim_atendimento = NULL, SicasMedico $oSicasMedico = NULL, $status = NULL) {
		$this->cd_atendimento = $cd_atendimento;
		$this->oSicasPessoa = $oSicasPessoa;
		$this->dt_ini_atendimento = $dt_ini_atendimento;
		$this->dt_fim_atendimento = $dt_fim_atendimento;
		$this->oSicasMedico = $oSicasMedico;
		$this->status = $status;
	}
}