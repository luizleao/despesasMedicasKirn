<?php
class SicasPessoa {
	public $cd_pessoa;
	public $nm_pessoa;
	public $email;
	public $dt_nascimento;
	public $genero;
	public $oSicasEstadoCivil;
	public $identidade;
	public $nm_orgao_emissor;
	public $dt_emissao;
	public $cpf;
	public $endereco;
	public $complemento;
	public $bairro;
	public $cidade;
	public $uf;
	public $cep;
	public $telefone;
	public $grupo_sanguineo;
	public $tipo_beneficiario;
	public $status;
	public $foto;
	public $oSicasPessoaCategoria;
	public $uf_identidade;
	public $tipo_identidade;
	public $descricao_perfil;
	public $usuario_proas;
	
	function __construct($cd_pessoa = NULL, $nm_pessoa = NULL, $email = NULL, $dt_nascimento = NULL, $genero = NULL, SicasEstadoCivil $oSicasEstadoCivil = NULL, $identidade = NULL, $nm_orgao_emissor = NULL, $dt_emissao = NULL, $cpf = NULL, $endereco = NULL, $complemento = NULL, $bairro = NULL, $cidade = NULL, $uf = NULL, $cep = NULL, $telefone = NULL, $grupo_sanguineo = NULL, $tipo_beneficiario = NULL, $status = NULL, $foto = NULL, SicasPessoaCategoria $oSicasPessoaCategoria = NULL, $uf_identidade = NULL, $tipo_identidade = NULL, $descricao_perfil = NULL, $usuario_proas = NULL) {
		$this->cd_pessoa = $cd_pessoa;
		$this->nm_pessoa = $nm_pessoa;
		$this->email = $email;
		$this->dt_nascimento = $dt_nascimento;
		$this->genero = $genero;
		$this->oSicasEstadoCivil = $oSicasEstadoCivil;
		$this->identidade = $identidade;
		$this->nm_orgao_emissor = $nm_orgao_emissor;
		$this->dt_emissao = $dt_emissao;
		$this->cpf = $cpf;
		$this->endereco = $endereco;
		$this->complemento = $complemento;
		$this->bairro = $bairro;
		$this->cidade = $cidade;
		$this->uf = $uf;
		$this->cep = $cep;
		$this->telefone = $telefone;
		$this->grupo_sanguineo = $grupo_sanguineo;
		$this->tipo_beneficiario = $tipo_beneficiario;
		$this->status = $status;
		$this->foto = $foto;
		$this->oSicasPessoaCategoria = $oSicasPessoaCategoria;
		$this->uf_identidade = $uf_identidade;
		$this->tipo_identidade = $tipo_identidade;
		$this->descricao_perfil = $descricao_perfil;
		$this->usuario_proas = $usuario_proas;
	}
}