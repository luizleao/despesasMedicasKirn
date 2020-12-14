<?php
class SicasDespesaGol {
	public $cd_despesa_gol;
	public $ano_mes;
	public $matricula;
	public $oSicasPessoa;
	public $oSicasCredenciado;
	public $vl_despesa;
	public $vl_d_despesa;
	public $porcentagem_desconto;
	public $remuneracao;
	public $oSicasTipoDespesa;
	public $flg_desconta;
	public $flg_fis_jur;
	function __construct($cd_despesa_gol = NULL, $ano_mes = NULL, $matricula = NULL, SicasPessoa $oSicasPessoa = NULL, SicasCredenciado $oSicasCredenciado = NULL, $vl_despesa = NULL, $vl_d_despesa = NULL, $porcentagem_desconto = NULL, $remuneracao = NULL, SicasTipoDespesa $oSicasTipoDespesa = NULL, $flg_desconta = NULL, $flg_fis_jur = NULL) {
		$this->cd_despesa_gol = $cd_despesa_gol;
		$this->ano_mes = $ano_mes;
		$this->matricula = $matricula;
		$this->oSicasPessoa = $oSicasPessoa;
		$this->oSicasCredenciado = $oSicasCredenciado;
		$this->vl_despesa = $vl_despesa;
		$this->vl_d_despesa = $vl_d_despesa;
		$this->porcentagem_desconto = $porcentagem_desconto;
		$this->remuneracao = $remuneracao;
		$this->oSicasTipoDespesa = $oSicasTipoDespesa;
		$this->flg_desconta = $flg_desconta;
		$this->flg_fis_jur = $flg_fis_jur;
	}
}