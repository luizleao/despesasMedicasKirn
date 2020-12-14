<?php
class SicasCredenciado {
	public $cd_credenciado;
	public $nm_credenciado;
	public $dt_nascimento;
	public $hora_atendimento;
	public $nm_servicos;
	public $profissional_liberal;
	public $endereco;
	public $complemento;
	public $bairro;
	public $cidade;
	public $uf;
	public $cep;
	public $telefone1;
	public $telefone2;
	public $fax1;
	public $ramal1;
	public $tipo;
	public $cd_pis_pasep;
	public $cpf;
	public $cgc;
	public $guia_prev_social;
	public $status;
	
	function __construct($cd_credenciado = NULL, $nm_credenciado = NULL, $dt_nascimento = NULL, $hora_atendimento = NULL, $nm_servicos = NULL, $profissional_liberal = NULL, $endereco = NULL, $complemento = NULL, $bairro = NULL, $cidade = NULL, $uf = NULL, $cep = NULL, $telefone1 = NULL, $telefone2 = NULL, $fax1 = NULL, $ramal1 = NULL, $tipo = NULL, $cd_pis_pasep = NULL, $cpf = NULL, $cgc = NULL, $guia_prev_social = NULL, $status = NULL) {
		$this->cd_credenciado = $cd_credenciado;
		$this->nm_credenciado = $nm_credenciado;
		$this->dt_nascimento = $dt_nascimento;
		$this->hora_atendimento = $hora_atendimento;
		$this->nm_servicos = $nm_servicos;
		$this->profissional_liberal = $profissional_liberal;
		$this->endereco = $endereco;
		$this->complemento = $complemento;
		$this->bairro = $bairro;
		$this->cidade = $cidade;
		$this->uf = $uf;
		$this->cep = $cep;
		$this->telefone1 = $telefone1;
		$this->telefone2 = $telefone2;
		$this->fax1 = $fax1;
		$this->ramal1 = $ramal1;
		$this->tipo = $tipo;
		$this->cd_pis_pasep = $cd_pis_pasep;
		$this->cpf = $cpf;
		$this->cgc = $cgc;
		$this->guia_prev_social = $guia_prev_social;
		$this->status = $status;
	}
	
	function __toString(){
	    return $this->nm_credenciado;
	}
}