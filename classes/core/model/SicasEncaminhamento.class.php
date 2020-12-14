<?php
class SicasEncaminhamento{
	public $cd_encaminhamento;
	public $dt_encaminhamento;
	public $oSicasMedico;
	public $oSicasPessoa;
	public $oSicasConsultaMedica;
	public $oSicasCredenciado;
	public $tipo_guia;
	public $status;
	public $oSicasTipoDespesa;
	public $observacao;
	
	function __construct($cd_encaminhamento=NULL, $dt_encaminhamento=NULL, SicasMedico $oSicasMedico=NULL, SicasPessoa $oSicasPessoa=NULL, SicasConsultaMedica $oSicasConsultaMedica=NULL, SicasCredenciado $oSicasCredenciado=NULL, $tipo_guia=NULL, $status=NULL, SicasTipoDespesa $oSicasTipoDespesa=NULL, $observacao=NULL) {
		$this->cd_encaminhamento = $cd_encaminhamento;
		$this->dt_encaminhamento = $dt_encaminhamento;
		$this->oSicasMedico = $oSicasMedico;
		$this->oSicasPessoa = $oSicasPessoa;
		$this->oSicasConsultaMedica = $oSicasConsultaMedica;
		$this->oSicasCredenciado = $oSicasCredenciado;
		$this->tipo_guia = $tipo_guia;
		$this->status = $status;
		$this->oSicasTipoDespesa = $oSicasTipoDespesa;
		$this->observacao = $observacao;
	}
}