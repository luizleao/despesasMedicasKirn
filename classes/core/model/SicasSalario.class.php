<?php
class SicasSalario {
	public $cd_salario;
	public $oSicasServidor;
	public $val_salario;
	public $dt_ini_salario;
	public $dt_fim_salario;
	public $serv_efetivo;
	public $obs;
	public $status;
	function __construct($cd_salario = NULL, SicasServidor $oSicasServidor = NULL, $val_salario = NULL, $dt_ini_salario = NULL, $dt_fim_salario = NULL, $serv_efetivo = NULL, $obs = NULL, $status = NULL) {
		$this->cd_salario = $cd_salario;
		$this->oSicasServidor = $oSicasServidor;
		$this->val_salario = $val_salario;
		$this->dt_ini_salario = $dt_ini_salario;
		$this->dt_fim_salario = $dt_fim_salario;
		$this->serv_efetivo = $serv_efetivo;
		$this->obs = $obs;
		$this->status = $status;
	}
}