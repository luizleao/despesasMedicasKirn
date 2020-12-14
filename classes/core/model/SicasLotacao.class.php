<?php
class SicasLotacao {
	public $cd_lotacao;
	public $sigla;
	public $cd_siged;
	public $nm_lotacao;
	public $status;
	public $oSicasLotacao;
	
	function __construct($cd_lotacao = NULL, $sigla = NULL, $cd_siged = NULL, $nm_lotacao = NULL, $status = NULL, SicasLotacao $oSicasLotacao = NULL) {
		$this->cd_lotacao 	 = $cd_lotacao;
		$this->sigla 	  	 = $sigla;
		$this->cd_siged	 	 = $cd_siged;
		$this->nm_lotacao 	 = $nm_lotacao;
		$this->status 	  	 = $status;
		$this->oSicasLotacao = $oSicasLotacao;
	}
}