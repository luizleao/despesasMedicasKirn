<?php
class SicasCredenciamento {
	public $cd_credenciamento;
	public $oSicasCredenciado;
	public $dt_ini_credenciamento;
	public $dt_fim_credenciamento;
	public $status;
	function __construct($cd_credenciamento = NULL, SicasCredenciado $oSicasCredenciado = NULL, $dt_ini_credenciamento = NULL, $dt_fim_credenciamento = NULL, $status = NULL) {
		$this->cd_credenciamento = $cd_credenciamento;
		$this->oSicasCredenciado = $oSicasCredenciado;
		$this->dt_ini_credenciamento = $dt_ini_credenciamento;
		$this->dt_fim_credenciamento = $dt_fim_credenciamento;
		$this->status = $status;
	}
}