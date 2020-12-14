<?php
class ControllerSicasFatura extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasFatura
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasFatura($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasFatura($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasCredenciado = new SicasCredenciado($cd_credenciado);
		$oSicasFatura = new SicasFatura($cd_fatura,$oSicasCredenciado,$num_fatura,$dt_cadastro,$vl_fatura,$status,$mes_ano_lancamento);
		$oSicasFaturaBD = new SicasFaturaBD();
		if(!$oSicasFaturaBD->cadastrar($oSicasFatura)){
			$this->msg = $oSicasFaturaBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasFatura
	 *
	 * @access public
	 * @param SicasFatura $oSicasFatura
	 * @return bool
	 */
	public function alterar($oSicasFatura = NULL){
		if($oSicasFatura == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasFatura(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasFatura($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasCredenciado = new SicasCredenciado($cd_credenciado);
			$oSicasFatura = new SicasFatura($cd_fatura,$oSicasCredenciado,$num_fatura,$dt_cadastro,$vl_fatura,$status,$mes_ano_lancamento);
		}		
		$oSicasFaturaBD = new SicasFaturaBD();
		if(!$oSicasFaturaBD->alterar($oSicasFatura)){
			$this->msg = $oSicasFaturaBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasFatura
	 *
	 * @access public
	 * @param integer $idSicasFatura
	 * @return bool
	 */
	public function excluir($idSicasFatura){		
		$oSicasFaturaBD = new SicasFaturaBD();		
		if(!$oSicasFaturaBD->excluir($idSicasFatura)){
			$this->msg = $oSicasFaturaBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasFatura
	 *
	 * @access public
	 * @param integer $cd_fatura
	 * @return SicasFatura
	 */
	public function get($cd_fatura){
		$oSicasFaturaBD = new SicasFaturaBD();
		if($oSicasFaturaBD->msg != ''){
			$this->msg = $oSicasFaturaBD->msg;
			return false;
		}
		if(!$obj = $oSicasFaturaBD->get($cd_fatura)){
		    $this->msg = $oSicasFaturaBD->msg;
		    return false;
		}
		return $obj;
	}
	
	/**
	 * Selecionar Fatura pelo numero da fatura de um credenciado
	 *
	 * @access public
	 * @param string $num_fatura
	 * @param integer $cd_credenciado
	 * @return SicasFatura
	 */
	public function getByFaturaCredenciado($num_fatura, $cd_credenciado){
	    $oSicasFaturaBD = new SicasFaturaBD();
	    if($oSicasFaturaBD->msg != ''){
	        $this->msg = $oSicasFaturaBD->msg;
	        return false;
	    }
	    if(!$obj = $oSicasFaturaBD->getByFaturaCredenciado($num_fatura, $cd_credenciado)){
	        $this->msg = $oSicasFaturaBD->msg;
	        return false;
	    }
	    return $obj;
	}
	/**
	 * Carregar Colecao de dados de SicasFatura
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasFatura[]
	 */
	public function getAll($aFiltro = NULL, $aOrdenacao = NULL, $pagina=NULL){
		try{		
			$oSicasFaturaBD = new SicasFaturaBD();
			$aux = $oSicasFaturaBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasFaturaBD->msg != ''){
				$this->msg = $oSicasFaturaBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasFatura
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasFatura
	 */
	public function consultar($valor){
		$oSicasFaturaBD = new SicasFaturaBD();	
		return $oSicasFaturaBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasFatura
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasFaturaBD = new SicasFaturaBD();
		return $oSicasFaturaBD->totalColecao();
	}
	
	/**
	 * Retorna as faturas do 
	 * 
	 * @param unknown $cd_credenciado
	 * @return SicasFatura[]|boolean
	 */
	public function getAllFaturaCredenciado($cd_credenciado){
	    $oSicasFaturaBD = new SicasFaturaBD();
	    return $oSicasFaturaBD->getAll(["sicas_fatura.cd_credenciado = $cd_credenciado"]);
	}

}