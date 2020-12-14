<?php
class SicasProcedimento {
	public $cd_procedimento;
	public $num_procedimento;
	public $nm_procedimento;
	public $num_custo_operacional;
	public $num_honorario;
	public $num_med_filme;
	public $num_auxiliares;
	public $num_port_anest;
	public $sigla;
	public $red_registro;
	public $status;
	function __construct($cd_procedimento = NULL, $num_procedimento = NULL, $nm_procedimento = NULL, $num_custo_operacional = NULL, $num_honorario = NULL, $num_med_filme = NULL, $num_auxiliares = NULL, $num_port_anest = NULL, $sigla = NULL, $red_registro = NULL, $status = NULL) {
		$this->cd_procedimento = $cd_procedimento;
		$this->num_procedimento = $num_procedimento;
		$this->nm_procedimento = $nm_procedimento;
		$this->num_custo_operacional = $num_custo_operacional;
		$this->num_honorario = $num_honorario;
		$this->num_med_filme = $num_med_filme;
		$this->num_auxiliares = $num_auxiliares;
		$this->num_port_anest = $num_port_anest;
		$this->sigla = $sigla;
		$this->red_registro = $red_registro;
		$this->status = $status;
	}
}