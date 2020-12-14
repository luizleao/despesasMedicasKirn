<?php
class ControllerSicasSalario extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasSalario
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasSalario($post);
		
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasSalario($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasServidor = new SicasServidor($cd_servidor);
		$oSicasSalario = new SicasSalario($cd_salario,$oSicasServidor,$val_salario,$dt_ini_salario,$dt_fim_salario,$serv_efetivo,$obs,$status);
		$oSicasSalarioBD = new SicasSalarioBD();
		if(!$oSicasSalarioBD->cadastrar($oSicasSalario)){
			$this->msg = $oSicasSalarioBD->msg;
			return false;
		}

		return true;
	}

	/**
	 * Alterar dados de SicasSalario
	 *
	 * @access public
	 * @param SicasSalario $oSicasSalario
	 * @return bool
	 */
	public function alterar($oSicasSalario = NULL){
		if($oSicasSalario == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasSalario(NULL, 2);
			//Util::trace($post); exit;
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasSalario($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasServidor = new SicasServidor($cd_servidor);
			$oSicasSalario = new SicasSalario($cd_salario,$oSicasServidor,$val_salario,$dt_ini_salario,$dt_fim_salario,$serv_efetivo,$obs,$status);
		}		
		//Util::trace($oSicasSalario); exit;
		$oSicasSalarioBD = new SicasSalarioBD();
		if(!$oSicasSalarioBD->alterar($oSicasSalario)){
			$this->msg = $oSicasSalarioBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasSalario
	 *
	 * @access public
	 * @param integer $idSicasSalario
	 * @return bool
	 */
	public function excluir($idSicasSalario){		
		$oSicasSalarioBD = new SicasSalarioBD();		
		if(!$oSicasSalarioBD->excluir($idSicasSalario)){
			$this->msg = $oSicasSalarioBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasSalario
	 *
	 * @access public
	 * @param integer $cd_salario
	 * @return SicasSalario
	 */
	public function get($cd_salario){
		$oSicasSalarioBD = new SicasSalarioBD();
		if($oSicasSalarioBD->msg != ''){
			$this->msg = $oSicasSalarioBD->msg;
			return false;
		}
		if(!$obj = $oSicasSalarioBD->get($cd_salario)){
		    $this->msg = $oSicasSalarioBD->msg;
		    return false;
		}
		return $obj;
	}
	
	/**
	 * Selecionar o salario atual do servidor
	 *
	 * @access public
	 * @param integer $cd_servidor
	 * @return SicasSalario
	 */
	public function getAtualByServidor($cd_servidor){
	    $oSicasSalarioBD = new SicasSalarioBD();
	    if($oSicasSalarioBD->msg != ''){
	        $this->msg = $oSicasSalarioBD->msg;
	        return false;
	    }
	    if(!$obj = $oSicasSalarioBD->getAtualByServidor($cd_servidor)){
	        $this->msg = $oSicasSalarioBD->msg;
	        return false;
	    }
	    return $obj;
	}
	
	
	/**
	 * Selecionar o salario atual do servidor
	 *
	 * @access public
	 * @param integer $cd_servidor
	 * @return SicasSalario
	 */
	public function getAtualByPessoaServidor($cd_pessoa){
	    $oSicasSalarioBD = new SicasSalarioBD();
	    if($oSicasSalarioBD->msg != ''){
	        $this->msg = $oSicasSalarioBD->msg;
	        return false;
	    }
	    if(!$obj = $oSicasSalarioBD->getAtualByPessoaServidor($cd_pessoa)){
	        $this->msg = $oSicasSalarioBD->msg;
	        return false;
	    }
	    return $obj;
	}
	
	/**
	 * Selecionar o salario atual do servidor
	 *
	 * @access public
	 * @param integer $cd_servidor
	 * @return SicasSalario
	 */
	public function getAtualByPessoaDependente($cd_pessoa){
	    $oSicasSalarioBD = new SicasSalarioBD();
	    if($oSicasSalarioBD->msg != ''){
	        $this->msg = $oSicasSalarioBD->msg;
	        return false;
	    }
	    if(!$obj = $oSicasSalarioBD->getAtualByPessoaDependente($cd_pessoa)){
	        $this->msg = $oSicasSalarioBD->msg;
	        return false;
	    }
	    return $obj;
	}
	

	/**
	 * Carregar Colecao de dados de SicasSalario
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasSalario[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasSalarioBD = new SicasSalarioBD();
			$aux = $oSicasSalarioBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasSalarioBD->msg != ''){
				$this->msg = $oSicasSalarioBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasSalario
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasSalario
	 */
	public function consultar($valor){
		$oSicasSalarioBD = new SicasSalarioBD();	
		return $oSicasSalarioBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasSalario
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasSalarioBD = new SicasSalarioBD();
		return $oSicasSalarioBD->totalColecao();
	}

}