<?php
class SicasHistoricoImpressao {
	public $cd_carteira;
	public $oSicasPessoa;
	public $dt_impressao;
	function __construct($cd_carteira = NULL, SicasPessoa $oSicasPessoa = NULL, $dt_impressao = NULL) {
		$this->cd_carteira = $cd_carteira;
		$this->oSicasPessoa = $oSicasPessoa;
		$this->dt_impressao = $dt_impressao;
	}
}