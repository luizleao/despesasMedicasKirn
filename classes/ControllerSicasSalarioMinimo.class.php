<?php
class ControllerSicasSalarioMinimo extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasSalarioMinimo
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasSalarioMinimo($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasSalarioMinimo($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasSalarioMinimo = new SicasSalarioMinimo($cd_salario_minimo,$valor,$dt_cadastro,$status);
		$oSicasSalarioMinimoBD = new SicasSalarioMinimoBD();
		if(!$oSicasSalarioMinimoBD->cadastrar($oSicasSalarioMinimo)){
			$this->msg = $oSicasSalarioMinimoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasSalarioMinimo
	 *
	 * @access public
	 * @param SicasSalarioMinimo $oSicasSalarioMinimo
	 * @return bool
	 */
	public function alterar($oSicasSalarioMinimo = NULL){
		if($oSicasSalarioMinimo == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasSalarioMinimo(NULL, 2);
			
			//Util::trace($post);
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasSalarioMinimo($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasSalarioMinimo = new SicasSalarioMinimo($cd_salario_minimo,$valor,$dt_cadastro,$status);
		}		
		$oSicasSalarioMinimoBD = new SicasSalarioMinimoBD();
		if(!$oSicasSalarioMinimoBD->alterar($oSicasSalarioMinimo)){
			$this->msg = $oSicasSalarioMinimoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasSalarioMinimo
	 *
	 * @access public
	 * @param integer $idSicasSalarioMinimo
	 * @return bool
	 */
	public function excluir($idSicasSalarioMinimo){		
		$oSicasSalarioMinimoBD = new SicasSalarioMinimoBD();		
		if(!$oSicasSalarioMinimoBD->excluir($idSicasSalarioMinimo)){
			$this->msg = $oSicasSalarioMinimoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasSalarioMinimo
	 *
	 * @access public
	 * @param integer $cd_salario_minimo
	 * @return SicasSalarioMinimo
	 */
	public function get($cd_salario_minimo){
		$oSicasSalarioMinimoBD = new SicasSalarioMinimoBD();
		if($oSicasSalarioMinimoBD->msg != ''){
			$this->msg = $oSicasSalarioMinimoBD->msg;
			return false;
		}
		if(!$obj = $oSicasSalarioMinimoBD->get($cd_salario_minimo)){
		    $this->msg = $oSicasSalarioMinimoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasSalarioMinimo
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasSalarioMinimo[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasSalarioMinimoBD = new SicasSalarioMinimoBD();
			$aux = $oSicasSalarioMinimoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasSalarioMinimoBD->msg != ''){
				$this->msg = $oSicasSalarioMinimoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasSalarioMinimo
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasSalarioMinimo
	 */
	public function consultar($valor){
		$oSicasSalarioMinimoBD = new SicasSalarioMinimoBD();	
		return $oSicasSalarioMinimoBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasSalarioMinimo
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasSalarioMinimoBD = new SicasSalarioMinimoBD();
		return $oSicasSalarioMinimoBD->totalColecao();
	}
	
	/**
	 * Retorna o Salario Minimo Atual
	 *
	 * @access public
	 * @return number
	 */
	public function getSalarioMinimoAtual(){
	    $aux = $this->getAll(["status=1"]);
	    return $aux[0]->valor;
	}
}