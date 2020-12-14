<?php
class SicasDependente {
	public $cd_dependente;
	public $oSicasServidor;
	public $oSicasPessoa;
	public $cd_seq_dependente;
	public $oSicasGrauParentesco;
	public $oSicasEscolaridade;
	public $dt_inclusao;
	public $dt_manutencao;
	public $dependente_financ;
	public $dependente_proas;
	public $status;
	function __construct($cd_dependente = NULL, SicasServidor $oSicasServidor = NULL, SicasPessoa $oSicasPessoa = NULL, $cd_seq_dependente = NULL, SicasGrauParentesco $oSicasGrauParentesco = NULL, SicasEscolaridade $oSicasEscolaridade = NULL, $dt_inclusao = NULL, $dt_manutencao = NULL, $dependente_financ = NULL, $dependente_proas = NULL, $status = NULL) {
		$this->cd_dependente = $cd_dependente;
		$this->oSicasServidor = $oSicasServidor;
		$this->oSicasPessoa = $oSicasPessoa;
		$this->cd_seq_dependente = $cd_seq_dependente;
		$this->oSicasGrauParentesco = $oSicasGrauParentesco;
		$this->oSicasEscolaridade = $oSicasEscolaridade;
		$this->dt_inclusao = $dt_inclusao;
		$this->dt_manutencao = $dt_manutencao;
		$this->dependente_financ = $dependente_financ;
		$this->dependente_proas = $dependente_proas;
		$this->status = $status;
	}
}