<?php
class SicasProcedimentoAutorizado {
	public $cd_procedimento_autorizado;
	public $oSicasEncaminhamento;
	public $oSicasProcedimento;
	public $qtd_servico_autorizado;
	public $status;
	
	public $percentualDesconto;
	
	function __construct($cd_procedimento_autorizado = NULL, SicasEncaminhamento $oSicasEncaminhamento = NULL, SicasProcedimento $oSicasProcedimento = NULL, $qtd_servico_autorizado = NULL, $status = NULL, $percentualDesconto = NULL) {
		$this->cd_procedimento_autorizado = $cd_procedimento_autorizado;
		$this->oSicasEncaminhamento       = $oSicasEncaminhamento;
		$this->oSicasProcedimento         = $oSicasProcedimento;
		$this->qtd_servico_autorizado     = $qtd_servico_autorizado;
		$this->status                     = $status;
		$this->percentualDesconto         = $percentualDesconto;
	}
}