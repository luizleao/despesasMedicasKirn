<?php
class ControllerSicasConsultaMedicaCid extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasConsultaMedicaCid
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasConsultaMedicaCid($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasConsultaMedicaCid($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasCid = new SicasCid($cd_cid);
		$oSicasConsultaMedicaCid = new SicasConsultaMedicaCid($oSicasCid,$cd_consulta_medica);
		$oSicasConsultaMedicaCidBD = new SicasConsultaMedicaCidBD();
		if(!$oSicasConsultaMedicaCidBD->cadastrar($oSicasConsultaMedicaCid)){
			$this->msg = $oSicasConsultaMedicaCidBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasConsultaMedicaCid
	 *
	 * @access public
	 * @param SicasConsultaMedicaCid $oSicasConsultaMedicaCid
	 * @return bool
	 */
	public function alterar($oSicasConsultaMedicaCid = NULL){
		if($oSicasConsultaMedicaCid == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasConsultaMedicaCid(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasConsultaMedicaCid($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasCid = new SicasCid($cd_cid);
			$oSicasConsultaMedicaCid = new SicasConsultaMedicaCid($oSicasCid,$cd_consulta_medica);
		}		
		$oSicasConsultaMedicaCidBD = new SicasConsultaMedicaCidBD();
		if(!$oSicasConsultaMedicaCidBD->alterar($oSicasConsultaMedicaCid)){
			$this->msg = $oSicasConsultaMedicaCidBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasConsultaMedicaCid
	 *
	 * @access public
	 * @param integer $idSicasConsultaMedicaCid
	 * @return bool
	 */
	public function excluir($idSicasConsultaMedicaCid){		
		$oSicasConsultaMedicaCidBD = new SicasConsultaMedicaCidBD();		
		if(!$oSicasConsultaMedicaCidBD->excluir($idSicasConsultaMedicaCid)){
			$this->msg = $oSicasConsultaMedicaCidBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasConsultaMedicaCid
	 *
	 * @access public

	 * @return SicasConsultaMedicaCid
	 */
	public function get(){
		$oSicasConsultaMedicaCidBD = new SicasConsultaMedicaCidBD();
		if($oSicasConsultaMedicaCidBD->msg != ''){
			$this->msg = $oSicasConsultaMedicaCidBD->msg;
			return false;
		}
		if(!$obj = $oSicasConsultaMedicaCidBD->get()){
		    $this->msg = $oSicasConsultaMedicaCidBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasConsultaMedicaCid
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasConsultaMedicaCid[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasConsultaMedicaCidBD = new SicasConsultaMedicaCidBD();
			$aux = $oSicasConsultaMedicaCidBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasConsultaMedicaCidBD->msg != ''){
				$this->msg = $oSicasConsultaMedicaCidBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasConsultaMedicaCid
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasConsultaMedicaCid
	 */
	public function consultar($valor){
		$oSicasConsultaMedicaCidBD = new SicasConsultaMedicaCidBD();	
		return $oSicasConsultaMedicaCidBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasConsultaMedicaCid
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasConsultaMedicaCidBD = new SicasConsultaMedicaCidBD();
		return $oSicasConsultaMedicaCidBD->totalColecao();
	}

}