<?php
class SicasTipoDespesa {
	public $cd_tipo_despesa;
	public $nm_despesa;
	public $credenciado;
	public $status;
	function __construct($cd_tipo_despesa = NULL, $nm_despesa = NULL, $credenciado = NULL, $status = NULL) {
		$this->cd_tipo_despesa = $cd_tipo_despesa;
		$this->nm_despesa = $nm_despesa;
		$this->credenciado = $credenciado;
		$this->status = $status;
	}
}