<?php
class SicasFatura {
	
	public $cd_fatura;
	public $oSicasCredenciado;
	public $num_fatura;
	public $dt_cadastro;
	public $vl_fatura;
	public $status;
	public $mes_ano_lancamento;
	
	function __construct($cd_fatura = NULL, SicasCredenciado $oSicasCredenciado = NULL, $num_fatura = NULL, $dt_cadastro = NULL, $vl_fatura = NULL, $status = NULL, $mes_ano_lancamento=NULL){
		$this->cd_fatura = $cd_fatura;
		$this->oSicasCredenciado = $oSicasCredenciado;
		$this->num_fatura = $num_fatura;
		$this->dt_cadastro = $dt_cadastro;
		$this->vl_fatura = $vl_fatura;
		$this->status = $status;
		$this->mes_ano_lancamento = $mes_ano_lancamento;
	}

	function __toString(){
		return $this->cd_fatura;
	}
}