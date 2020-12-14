<?php
class ControllerSicasParamDesconto extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasParamDesconto
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasParamDesconto($post);
		
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasParamDesconto($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasParamDesconto = new SicasParamDesconto($cd_param_desc,$descricao_param,$percentagem_desconto,$status);
		$oSicasParamDescontoBD = new SicasParamDescontoBD();
		if(!$oSicasParamDescontoBD->cadastrar($oSicasParamDesconto)){
			$this->msg = $oSicasParamDescontoBD->msg;
			return false;
		}
		return true;
	}

	/**
	 * Alterar dados de SicasParamDesconto
	 *
	 * @access public
	 * @param SicasParamDesconto $oSicasParamDesconto
	 * @return bool
	 */
	public function alterar($oSicasParamDesconto = NULL){
		if($oSicasParamDesconto == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasParamDesconto(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasParamDesconto($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasParamDesconto = new SicasParamDesconto($cd_param_desc,$descricao_param,$percentagem_desconto,$status);
		}		
		$oSicasParamDescontoBD = new SicasParamDescontoBD();
		if(!$oSicasParamDescontoBD->alterar($oSicasParamDesconto)){
			$this->msg = $oSicasParamDescontoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasParamDesconto
	 *
	 * @access public
	 * @param integer $idSicasParamDesconto
	 * @return bool
	 */
	public function excluir($idSicasParamDesconto){		
		$oSicasParamDescontoBD = new SicasParamDescontoBD();		
		if(!$oSicasParamDescontoBD->excluir($idSicasParamDesconto)){
			$this->msg = $oSicasParamDescontoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasParamDesconto
	 *
	 * @access public
	 * @param integer $cd_param_desc
	 * @return SicasParamDesconto
	 */
	public function get($cd_param_desc){
		$oSicasParamDescontoBD = new SicasParamDescontoBD();
		if($oSicasParamDescontoBD->msg != ''){
			$this->msg = $oSicasParamDescontoBD->msg;
			return false;
		}
		if(!$obj = $oSicasParamDescontoBD->get($cd_param_desc)){
		    $this->msg = $oSicasParamDescontoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasParamDesconto
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasParamDesconto[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasParamDescontoBD = new SicasParamDescontoBD();
			$aux = $oSicasParamDescontoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasParamDescontoBD->msg != ''){
				$this->msg = $oSicasParamDescontoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasParamDesconto
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
	 * @param string $valor
	 * @return SicasParamDesconto
	 */
	public function consultar($valor, $aFiltro=[], $aOrdenacao=[]){
		$oSicasParamDescontoBD = new SicasParamDescontoBD();	
		return $oSicasParamDescontoBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasParamDesconto
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasParamDescontoBD = new SicasParamDescontoBD();
		return $oSicasParamDescontoBD->totalColecao();
	}

}