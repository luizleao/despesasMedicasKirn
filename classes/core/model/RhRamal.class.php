<?php
class RhRamal {
	
	public $cd_ramal;
	public $oSicasLotacao;
	public $ramal;
	public $descricao;
	
	function __construct($cd_ramal = NULL, SicasLotacao $oSicasLotacao = NULL, $ramal = NULL, $descricao = NULL){
		$this->cd_ramal = $cd_ramal;
		$this->oSicasLotacao = $oSicasLotacao;
		$this->ramal = $ramal;
		$this->descricao = $descricao;
		
	}
}