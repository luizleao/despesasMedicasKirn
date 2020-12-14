<?php
class SicasDespesa {
	public $cd_despesa;
	public $oSicasProcedimentoAutorizado;
	public $oSicasSalario;
	public $oSicasFatura;
	public $qtd_servico_realizado;
	public $val_servico_realizado;
	public $dt_atendimento;
	public $dt_cadastro;
	public $desconto_servidor;
	public $status;
	public $mes_ano_desconto;
	
	function __construct($cd_despesa = NULL, SicasProcedimentoAutorizado $oSicasProcedimentoAutorizado = NULL, SicasSalario $oSicasSalario = NULL, SicasFatura $oSicasFatura = NULL, $qtd_servico_realizado = NULL, $val_servico_realizado = NULL, $dt_atendimento = NULL, $dt_cadastro = NULL, $desconto_servidor = NULL, $status = NULL, $mes_ano_desconto = NULL) {
		$this->cd_despesa                   = $cd_despesa;
		$this->oSicasProcedimentoAutorizado = $oSicasProcedimentoAutorizado;
		$this->oSicasSalario                = $oSicasSalario;
		$this->oSicasFatura                 = $oSicasFatura;
		$this->qtd_servico_realizado        = $qtd_servico_realizado;
		$this->val_servico_realizado        = $val_servico_realizado;
		$this->dt_atendimento               = $dt_atendimento;
		$this->dt_cadastro                  = $dt_cadastro;
		$this->desconto_servidor            = $desconto_servidor;
		$this->status                       = $status;
		$this->mes_ano_desconto             = $mes_ano_desconto;
	}
}