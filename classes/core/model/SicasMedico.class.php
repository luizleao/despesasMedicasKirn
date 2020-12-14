<?php
class SicasMedico {
	public $cd_medico;
	public $login;
	public $status;
	public $crm;
	public $oSicasServidor;
	function __construct($cd_medico = NULL, $login = NULL, $status = NULL, $crm = NULL, SicasServidor $oSicasServidor=NULL) {
		$this->cd_medico = $cd_medico;
		$this->login = $login;
		$this->status = $status;
		$this->crm = $crm;
		$this->oSicasServidor = $oSicasServidor;
	}
}