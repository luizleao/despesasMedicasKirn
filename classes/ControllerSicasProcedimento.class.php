<?php
class ControllerSicasProcedimento extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasProcedimento
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasProcedimento($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasProcedimento($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasProcedimento = new SicasProcedimento($cd_procedimento,$num_procedimento,$nm_procedimento,$num_custo_operacional,$num_honorario,$num_med_filme,$num_auxiliares,$num_port_anest,$sigla,$red_registro,$status);
		$oSicasProcedimentoBD = new SicasProcedimentoBD();
		if(!$oSicasProcedimentoBD->cadastrar($oSicasProcedimento)){
			$this->msg = $oSicasProcedimentoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasProcedimento
	 *
	 * @access public
	 * @param SicasProcedimento $oSicasProcedimento
	 * @return bool
	 */
	public function alterar($oSicasProcedimento = NULL){
		if($oSicasProcedimento == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasProcedimento(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasProcedimento($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasProcedimento = new SicasProcedimento($cd_procedimento,$num_procedimento,$nm_procedimento,$num_custo_operacional,$num_honorario,$num_med_filme,$num_auxiliares,$num_port_anest,$sigla,$red_registro,$status);
		}		
		$oSicasProcedimentoBD = new SicasProcedimentoBD();
		if(!$oSicasProcedimentoBD->alterar($oSicasProcedimento)){
			$this->msg = $oSicasProcedimentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasProcedimento
	 *
	 * @access public
	 * @param integer $idSicasProcedimento
	 * @return bool
	 */
	public function excluir($idSicasProcedimento){		
		$oSicasProcedimentoBD = new SicasProcedimentoBD();		
		if(!$oSicasProcedimentoBD->excluir($idSicasProcedimento)){
			$this->msg = $oSicasProcedimentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasProcedimento
	 *
	 * @access public
	 * @param integer $cd_procedimento
	 * @return SicasProcedimento
	 */
	public function get($cd_procedimento){
		$oSicasProcedimentoBD = new SicasProcedimentoBD();
		if($oSicasProcedimentoBD->msg != ''){
			$this->msg = $oSicasProcedimentoBD->msg;
			return false;
		}
		if(!$obj = $oSicasProcedimentoBD->get($cd_procedimento)){
		    $this->msg = $oSicasProcedimentoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasProcedimento
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasProcedimento[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasProcedimentoBD = new SicasProcedimentoBD();
			$aux = $oSicasProcedimentoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasProcedimentoBD->msg != ''){
				$this->msg = $oSicasProcedimentoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasProcedimento
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasProcedimento
	 */
	public function consultar($valor){
		$oSicasProcedimentoBD = new SicasProcedimentoBD();	
		return $oSicasProcedimentoBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasProcedimento
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasProcedimentoBD = new SicasProcedimentoBD();
		return $oSicasProcedimentoBD->totalColecao();
	}

}