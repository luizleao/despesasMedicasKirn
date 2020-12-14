<?php
class SicasSalarioMinimo {
	public $cd_salario_minimo;
	public $valor;
	public $dt_cadastro;
	public $status;
	function __construct($cd_salario_minimo = NULL, $valor = NULL, $dt_cadastro = NULL, $status = NULL) {
		$this->cd_salario_minimo = $cd_salario_minimo;
		$this->valor = $valor;
		$this->dt_cadastro = $dt_cadastro;
		$this->status = $status;
	}
}