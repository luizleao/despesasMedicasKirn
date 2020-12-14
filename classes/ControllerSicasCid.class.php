<?php
class ControllerSicasCid extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasCid
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasCid($post);

		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasCid($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasCid = new SicasCid($cd_cid_pai);
		$oSicasCid = new SicasCid($cd_cid,$desc_cid,$desc_cid_abrev,$oSicasCid);
		$oSicasCidBD = new SicasCidBD();
		if(!$oSicasCidBD->cadastrar($oSicasCid)){
			$this->msg = $oSicasCidBD->msg;
			return false;
		}

		return true;
	}

	/**
	 * Alterar dados de SicasCid
	 *
	 * @access public
	 * @param SicasCid $oSicasCid
	 * @return bool
	 */
	public function alterar($oSicasCid = NULL){
		if($oSicasCid == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasCid(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasCid($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasCid = new SicasCid($cd_cid_pai);
			$oSicasCid = new SicasCid($cd_cid,$desc_cid,$desc_cid_abrev,$oSicasCid);
		}		
		$oSicasCidBD = new SicasCidBD();
		if(!$oSicasCidBD->alterar($oSicasCid)){
			$this->msg = $oSicasCidBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasCid
	 *
	 * @access public
	 * @param integer $idSicasCid
	 * @return bool
	 */
	public function excluir($idSicasCid){		
		$oSicasCidBD = new SicasCidBD();		
		if(!$oSicasCidBD->excluir($idSicasCid)){
			$this->msg = $oSicasCidBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasCid
	 *
	 * @access public
	 * @param integer $cd_cid
	 * @return SicasCid
	 */
	public function get($cd_cid){
		$oSicasCidBD = new SicasCidBD();
		if($oSicasCidBD->msg != ''){
			$this->msg = $oSicasCidBD->msg;
			return false;
		}
		if(!$obj = $oSicasCidBD->get($cd_cid)){
		    $this->msg = $oSicasCidBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasCid
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasCid[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasCidBD = new SicasCidBD();
			$aux = $oSicasCidBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasCidBD->msg != ''){
				$this->msg = $oSicasCidBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasCid
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasCid
	 */
	public function consultar($valor){
		$oSicasCidBD = new SicasCidBD();	
		return $oSicasCidBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasCid
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasCidBD = new SicasCidBD();
		return $oSicasCidBD->totalColecao();
	}

}