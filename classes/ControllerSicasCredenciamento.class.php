<?php
class ControllerSicasCredenciamento extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasCredenciamento
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasCredenciamento($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasCredenciamento($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasCredenciado = new SicasCredenciado($cd_credenciado);
		$oSicasCredenciamento = new SicasCredenciamento($cd_credenciamento,$oSicasCredenciado,$dt_ini_credenciamento,$dt_fim_credenciamento,$status);
		$oSicasCredenciamentoBD = new SicasCredenciamentoBD();
		if(!$oSicasCredenciamentoBD->cadastrar($oSicasCredenciamento)){
			$this->msg = $oSicasCredenciamentoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasCredenciamento
	 *
	 * @access public
	 * @param SicasCredenciamento $oSicasCredenciamento
	 * @return bool
	 */
	public function alterar($oSicasCredenciamento = NULL){
		if($oSicasCredenciamento == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasCredenciamento(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasCredenciamento($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasCredenciado = new SicasCredenciado($cd_credenciado);
			$oSicasCredenciamento = new SicasCredenciamento($cd_credenciamento,$oSicasCredenciado,$dt_ini_credenciamento,$dt_fim_credenciamento,$status);
		}		
		$oSicasCredenciamentoBD = new SicasCredenciamentoBD();
		if(!$oSicasCredenciamentoBD->alterar($oSicasCredenciamento)){
			$this->msg = $oSicasCredenciamentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasCredenciamento
	 *
	 * @access public
	 * @param integer $idSicasCredenciamento
	 * @return bool
	 */
	public function excluir($idSicasCredenciamento){		
		$oSicasCredenciamentoBD = new SicasCredenciamentoBD();		
		if(!$oSicasCredenciamentoBD->excluir($idSicasCredenciamento)){
			$this->msg = $oSicasCredenciamentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasCredenciamento
	 *
	 * @access public
	 * @param integer $cd_credenciamento
	 * @return SicasCredenciamento
	 */
	public function get($cd_credenciamento){
		$oSicasCredenciamentoBD = new SicasCredenciamentoBD();
		if($oSicasCredenciamentoBD->msg != ''){
			$this->msg = $oSicasCredenciamentoBD->msg;
			return false;
		}
		if(!$obj = $oSicasCredenciamentoBD->get($cd_credenciamento)){
		    $this->msg = $oSicasCredenciamentoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasCredenciamento
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasCredenciamento[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasCredenciamentoBD = new SicasCredenciamentoBD();
			$aux = $oSicasCredenciamentoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasCredenciamentoBD->msg != ''){
				$this->msg = $oSicasCredenciamentoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasCredenciamento
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasCredenciamento
	 */
	public function consultar($valor){
		$oSicasCredenciamentoBD = new SicasCredenciamentoBD();	
		return $oSicasCredenciamentoBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasCredenciamento
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasCredenciamentoBD = new SicasCredenciamentoBD();
		return $oSicasCredenciamentoBD->totalColecao();
	}

}