<?php
class ControllerHistorico extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar Historico
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formHistorico($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormHistorico($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oHistorico = new Historico($codigo,$data_historico,$entidade,$ip,$tipo_persistencia,$usuario,$xml);
		$oHistoricoBD = new HistoricoBD();
		if(!$oHistoricoBD->cadastrar($oHistorico)){
			$this->msg = $oHistoricoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de Historico
	 *
	 * @access public
	 * @param Historico $oHistorico
	 * @return bool
	 */
	public function alterar($oHistorico = NULL){
		if($oHistorico == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formHistorico(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormHistorico($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oHistorico = new Historico($codigo,$data_historico,$entidade,$ip,$tipo_persistencia,$usuario,$xml);
		}		
		$oHistoricoBD = new HistoricoBD();
		if(!$oHistoricoBD->alterar($oHistorico)){
			$this->msg = $oHistoricoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir Historico
	 *
	 * @access public
	 * @param integer $idHistorico
	 * @return bool
	 */
	public function excluir($idHistorico){		
		$oHistoricoBD = new HistoricoBD();		
		if(!$oHistoricoBD->excluir($idHistorico)){
			$this->msg = $oHistoricoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de Historico
	 *
	 * @access public
	 * @param integer $codigo
	 * @return Historico
	 */
	public function get($codigo){
		$oHistoricoBD = new HistoricoBD();
		if($oHistoricoBD->msg != ''){
			$this->msg = $oHistoricoBD->msg;
			return false;
		}
		if(!$obj = $oHistoricoBD->get($codigo)){
		    $this->msg = $oHistoricoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de Historico
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return Historico[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oHistoricoBD = new HistoricoBD();
			$aux = $oHistoricoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oHistoricoBD->msg != ''){
				$this->msg = $oHistoricoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de Historico
	 *
	 * @access public
	 * @param string $valor
	 * @return Historico
	 */
	public function consultar($valor){
		$oHistoricoBD = new HistoricoBD();	
		return $oHistoricoBD->consultar($valor);
	}

	/**
	 * Total de registros de Historico
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oHistoricoBD = new HistoricoBD();
		return $oHistoricoBD->totalColecao();
	}

}