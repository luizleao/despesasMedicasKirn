<?php
class SicasServidor{
	public $cd_servidor;
	public $oSicasPessoa;
	public $cd_matricula;
	public $oSicasLotacao;
	public $status;
	public $serv_efetivo;
	public $oRhCargo;
	public $ramal1;
	public $ramal2;
	public $ramal3;
	public $oSicasPessoaCategoria;
	public $foto;
	public $descricao_perfil;
	public $usuario_proas;
	public $oSicasSalario;
	public $vl_saldo_odonto;
	
	function __construct($cd_servidor=NULL, SicasPessoa $oSicasPessoa=NULL, $cd_matricula=NULL, SicasLotacao $oSicasLotacao=NULL, $status=NULL, $serv_efetivo=NULL, RhCargo $oRhCargo=NULL, $ramal1=NULL, $ramal2=NULL, $ramal3=NULL, SicasPessoaCategoria $oSicasPessoaCategoria=NULL, $foto=NULL, $descricao_perfil=NULL, $usuario_proas=NULL, $vl_saldo_odonto=NULL){
		$this->cd_servidor 	 	     = $cd_servidor;
		$this->oSicasPessoa  	     = $oSicasPessoa;
		$this->cd_matricula  	     = $cd_matricula;
		$this->oSicasLotacao 	     = $oSicasLotacao;
		$this->status 		 	     = $status;
		$this->serv_efetivo  	     = $serv_efetivo;
		$this->oRhCargo 	 	     = $oRhCargo;
		$this->ramal1 		 	     = $ramal1; 
		$this->ramal2 		 	     = $ramal2;
		$this->ramal3 		  	     = $ramal3;
		$this->oSicasPessoaCategoria = $oSicasPessoaCategoria;
		$this->foto 			     = $foto;
		$this->descricao_perfil      = $descricao_perfil;
		$this->usuario_proas         = $usuario_proas;
		$this->vl_saldo_odonto       = $vl_saldo_odonto;
		//$this->_getSicasSalario();
	}
	
	function __set($name, $value){
	    if($name == 'cd_servidor'){ 
	        if(isset($this->$name)){
	            $this->oSicasSalario = _getSicasSalario($value);
	        }
	        
	        echo "cd_servidor alterado"; 
	    }
	}	
	
	/**
	 * Retorna salario atua do servidor
	 * 
	 * @return SicasSalario
	 */
	function getSicasSalarioAtual(){
	    $this->oSicasSalario = (new ControllerSicasSalario())->getAtualByServidor($this->cd_servidor);
	}

}