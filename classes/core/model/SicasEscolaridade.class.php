<?php
class SicasEscolaridade {
	public $cd_escolaridade;
	public $nm_escolaridade;
	public $status;
	function __construct($cd_escolaridade = NULL, $nm_escolaridade = NULL, $status = NULL) {
		$this->cd_escolaridade = $cd_escolaridade;
		$this->nm_escolaridade = $nm_escolaridade;
		$this->status = $status;
	}
}