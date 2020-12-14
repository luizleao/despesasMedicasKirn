<?php
class Historico {
	public $codigo;
	public $data_historico;
	public $entidade;
	public $ip;
	public $tipo_persistencia;
	public $usuario;
	public $xml;
	function __construct($codigo = NULL, $data_historico = NULL, $entidade = NULL, $ip = NULL, $tipo_persistencia = NULL, $usuario = NULL, $xml = NULL) {
		$this->codigo = $codigo;
		$this->data_historico = $data_historico;
		$this->entidade = $entidade;
		$this->ip = $ip;
		$this->tipo_persistencia = $tipo_persistencia;
		$this->usuario = $usuario;
		$this->xml = $xml;
	}
}