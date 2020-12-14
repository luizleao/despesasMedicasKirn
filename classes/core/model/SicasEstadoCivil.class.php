<?php
class SicasEstadoCivil {
	public $cd_estado_civil;
	public $nm_estado_civil;
	public $status;
	function __construct($cd_estado_civil = NULL, $nm_estado_civil = NULL, $status = NULL) {
		$this->cd_estado_civil = $cd_estado_civil;
		$this->nm_estado_civil = $nm_estado_civil;
		$this->status = $status;
	}
}