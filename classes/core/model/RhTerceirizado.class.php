<?php
class RhTerceirizado {
	
	public $cd_terceirizado;
	public $oSicasPessoa;
	public $oSicasLotacao;
	public $cargo;
	public $status;
	
	function __construct($cd_terceirizado = NULL, SicasPessoa $oSicasPessoa = NULL, SicasLotacao $oSicasLotacao = NULL, $cargo = NULL, $status = NULL){
		$this->cd_terceirizado = $cd_terceirizado;
		$this->oSicasPessoa = $oSicasPessoa;
		$this->oSicasLotacao = $oSicasLotacao;
		$this->cargo = $cargo;
		$this->status = $status;
	}
}