<?php
class RhFeriado {
	public $cd_feriado;
	public $data_feriado;
	public $descricao_feriado;
	public $esfera_feriado;
	function __construct($cd_feriado = NULL, $data_feriado = NULL, $descricao_feriado = NULL, $esfera_feriado = NULL) {
		$this->cd_feriado = $cd_feriado;
		$this->data_feriado = $data_feriado;
		$this->descricao_feriado = $descricao_feriado;
		$this->esfera_feriado = $esfera_feriado;
	}
}