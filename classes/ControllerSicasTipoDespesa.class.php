<?php
class ControllerSicasTipoDespesa extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasTipoDespesa
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasTipoDespesa($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasTipoDespesa($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasTipoDespesa = new SicasTipoDespesa($cd_tipo_despesa,$nm_despesa,$credenciado,$status);
		$oSicasTipoDespesaBD = new SicasTipoDespesaBD();
		if(!$oSicasTipoDespesaBD->cadastrar($oSicasTipoDespesa)){
			$this->msg = $oSicasTipoDespesaBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasTipoDespesa
	 *
	 * @access public
	 * @param SicasTipoDespesa $oSicasTipoDespesa
	 * @return bool
	 */
	public function alterar($oSicasTipoDespesa = NULL){
		if($oSicasTipoDespesa == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasTipoDespesa(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasTipoDespesa($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasTipoDespesa = new SicasTipoDespesa($cd_tipo_despesa,$nm_despesa,$credenciado,$status);
		}		
		$oSicasTipoDespesaBD = new SicasTipoDespesaBD();
		if(!$oSicasTipoDespesaBD->alterar($oSicasTipoDespesa)){
			$this->msg = $oSicasTipoDespesaBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasTipoDespesa
	 *
	 * @access public
	 * @param integer $idSicasTipoDespesa
	 * @return bool
	 */
	public function excluir($idSicasTipoDespesa){		
		$oSicasTipoDespesaBD = new SicasTipoDespesaBD();		
		if(!$oSicasTipoDespesaBD->excluir($idSicasTipoDespesa)){
			$this->msg = $oSicasTipoDespesaBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasTipoDespesa
	 *
	 * @access public
	 * @param integer $cd_tipo_despesa
	 * @return SicasTipoDespesa
	 */
	public function get($cd_tipo_despesa){
		$oSicasTipoDespesaBD = new SicasTipoDespesaBD();
		if($oSicasTipoDespesaBD->msg != ''){
			$this->msg = $oSicasTipoDespesaBD->msg;
			return false;
		}
		if(!$obj = $oSicasTipoDespesaBD->get($cd_tipo_despesa)){
		    $this->msg = $oSicasTipoDespesaBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasTipoDespesa
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasTipoDespesa[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasTipoDespesaBD = new SicasTipoDespesaBD();
			$aux = $oSicasTipoDespesaBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasTipoDespesaBD->msg != ''){
				$this->msg = $oSicasTipoDespesaBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasTipoDespesa
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasTipoDespesa
	 */
	public function consultar($valor){
		$oSicasTipoDespesaBD = new SicasTipoDespesaBD();	
		return $oSicasTipoDespesaBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasTipoDespesa
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasTipoDespesaBD = new SicasTipoDespesaBD();
		return $oSicasTipoDespesaBD->totalColecao();
	}

}