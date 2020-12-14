<?php
class RhIes {
	
	public $cd_ies;
	public $sigla;
	public $descricao;
	public $endereco;
	public $telefone1;
	public $telefone2;
	public $telefone3;
	public $email;
	public $status;
	
	function __construct($cd_ies = NULL, 
                	     $sigla = NULL, 
                	     $descricao = NULL, 
                	     $endereco = NULL, 
                	     $telefone1 = NULL, 
                	     $telefone2 = NULL, 
                	     $telefone3 = NULL, 
                	     $email = NULL, 
                	     $status = NULL){
	    
		$this->cd_ies = $cd_ies;
		$this->sigla = $sigla;
		$this->descricao = $descricao;
		$this->endereco = $endereco;
		$this->telefone1 = $telefone1;
		$this->telefone2 = $telefone2;
		$this->telefone3 = $telefone3;
		$this->email = $email;
		$this->status = $status;
	}
}