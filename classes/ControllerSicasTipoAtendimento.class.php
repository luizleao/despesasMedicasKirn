<?php
class ControllerSicasTipoAtendimento extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasTipoAtendimento
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasTipoAtendimento($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasTipoAtendimento($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasTipoAtendimento = new SicasTipoAtendimento($cd_tipo_atendimento,$nm_tipo_atendimento,$fl_atendimento,$pericia,$status);
		$oSicasTipoAtendimentoBD = new SicasTipoAtendimentoBD();
		if(!$oSicasTipoAtendimentoBD->cadastrar($oSicasTipoAtendimento)){
			$this->msg = $oSicasTipoAtendimentoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasTipoAtendimento
	 *
	 * @access public
	 * @param SicasTipoAtendimento $oSicasTipoAtendimento
	 * @return bool
	 */
	public function alterar($oSicasTipoAtendimento = NULL){
		if($oSicasTipoAtendimento == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasTipoAtendimento(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasTipoAtendimento($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasTipoAtendimento = new SicasTipoAtendimento($cd_tipo_atendimento,$nm_tipo_atendimento,$fl_atendimento,$pericia,$status);
		}		
		$oSicasTipoAtendimentoBD = new SicasTipoAtendimentoBD();
		if(!$oSicasTipoAtendimentoBD->alterar($oSicasTipoAtendimento)){
			$this->msg = $oSicasTipoAtendimentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasTipoAtendimento
	 *
	 * @access public
	 * @param integer $idSicasTipoAtendimento
	 * @return bool
	 */
	public function excluir($idSicasTipoAtendimento){		
		$oSicasTipoAtendimentoBD = new SicasTipoAtendimentoBD();		
		if(!$oSicasTipoAtendimentoBD->excluir($idSicasTipoAtendimento)){
			$this->msg = $oSicasTipoAtendimentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasTipoAtendimento
	 *
	 * @access public
	 * @param integer $cd_tipo_atendimento
	 * @return SicasTipoAtendimento
	 */
	public function get($cd_tipo_atendimento){
		$oSicasTipoAtendimentoBD = new SicasTipoAtendimentoBD();
		if($oSicasTipoAtendimentoBD->msg != ''){
			$this->msg = $oSicasTipoAtendimentoBD->msg;
			return false;
		}
		if(!$obj = $oSicasTipoAtendimentoBD->get($cd_tipo_atendimento)){
		    $this->msg = $oSicasTipoAtendimentoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasTipoAtendimento
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasTipoAtendimento[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasTipoAtendimentoBD = new SicasTipoAtendimentoBD();
			$aux = $oSicasTipoAtendimentoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasTipoAtendimentoBD->msg != ''){
				$this->msg = $oSicasTipoAtendimentoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasTipoAtendimento
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasTipoAtendimento
	 */
	public function consultar($valor){
		$oSicasTipoAtendimentoBD = new SicasTipoAtendimentoBD();	
		return $oSicasTipoAtendimentoBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasTipoAtendimento
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasTipoAtendimentoBD = new SicasTipoAtendimentoBD();
		return $oSicasTipoAtendimentoBD->totalColecao();
	}

}