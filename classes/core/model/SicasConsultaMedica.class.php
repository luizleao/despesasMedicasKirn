<?php
class SicasConsultaMedica {
	public $cd_consulta_medica;
	public $oSicasAtendimento;
	public $dt_consulta;
	public $oSicasMedico;
	public $qp_paciente;
	public $exame_fisico;
	public $exame_solicitado;
	public $diag_paciente;
	public $oSicasTipoAtendimento;
	public $resultado;
	public $tratamento;
	public $status;
	function __construct($cd_consulta_medica = NULL, SicasAtendimento $oSicasAtendimento = NULL, $dt_consulta = NULL, SicasMedico $oSicasMedico = NULL, $qp_paciente = NULL, $exame_fisico = NULL, $exame_solicitado = NULL, $diag_paciente = NULL, SicasTipoAtendimento $oSicasTipoAtendimento = NULL, $resultado = NULL, $tratamento = NULL, $status = NULL) {
		$this->cd_consulta_medica = $cd_consulta_medica;
		$this->oSicasAtendimento = $oSicasAtendimento;
		$this->dt_consulta = $dt_consulta;
		$this->oSicasMedico = $oSicasMedico;
		$this->qp_paciente = $qp_paciente;
		$this->exame_fisico = $exame_fisico;
		$this->exame_solicitado = $exame_solicitado;
		$this->diag_paciente = $diag_paciente;
		$this->oSicasTipoAtendimento = $oSicasTipoAtendimento;
		$this->resultado = $resultado;
		$this->tratamento = $tratamento;
		$this->status = $status;
	}
}