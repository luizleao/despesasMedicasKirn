<?php
class RhServidorRamal {
	
	public $oSicasServidor;
	public $oRhRamal;
	
	function __construct(SicasServidor $oSicasServidor = NULL, RhRamal $oRhRamal = NULL){
		$this->oSicasServidor = $oSicasServidor;
		$this->oRhRamal = $oRhRamal;
	}
}