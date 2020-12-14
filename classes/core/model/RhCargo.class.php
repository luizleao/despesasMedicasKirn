<?php
class RhCargo {
	public $cd_cargo;
	public $descricao_cargo;
	public $descricao_cargo_abrev;
	public $num_siape_cargo;
	public $status;
	function __construct($cd_cargo = NULL, $descricao_cargo = NULL, $descricao_cargo_abrev = NULL, $num_siape_cargo = NULL, $status = NULL) {
		$this->cd_cargo = $cd_cargo;
		$this->descricao_cargo = $descricao_cargo;
		$this->descricao_cargo_abrev = $descricao_cargo_abrev;
		$this->num_siape_cargo = $num_siape_cargo;
		$this->status = $status;
	}
}