<?php
class RhEstagiario {
	
	public $cd_estagiario;
	public $oSicasPessoa;
	public $oSicasLotacao;
	public $oRhIes;
	public $num_processo;
	public $dt_inicio;
	public $dt_renovacao;
	public $status;
	
	function __construct($cd_estagiario = NULL, SicasPessoa $oSicasPessoa = NULL, SicasLotacao $oSicasLotacao = NULL, RhIes $oRhIes = NULL, $num_processo = NULL, $dt_inicio = NULL, $dt_renovacao = NULL, $status = NULL){
		$this->cd_estagiario = $cd_estagiario;
		$this->oSicasPessoa = $oSicasPessoa;
		$this->oSicasLotacao = $oSicasLotacao;
		$this->oRhIes = $oRhIes;
		$this->num_processo = $num_processo;
		$this->dt_inicio = $dt_inicio;
		$this->dt_renovacao = $dt_renovacao;
		$this->status = $status;
	}
}