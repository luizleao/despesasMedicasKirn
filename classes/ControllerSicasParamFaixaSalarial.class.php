<?php
class ControllerSicasParamFaixaSalarial extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasParamFaixaSalarial
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasParamFaixaSalarial($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasParamFaixaSalarial($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasParamFaixaSalarial = new SicasParamFaixaSalarial($cd_param_faixa_sal,$val_faixa_inicial,$flg_faixa_ini_inclusive,$val_faixa_final,$flg_faixa_fin_inclusive,$percentagem_desconto,$status,$servidor_efetivo);
		$oSicasParamFaixaSalarialBD = new SicasParamFaixaSalarialBD();
		if(!$oSicasParamFaixaSalarialBD->cadastrar($oSicasParamFaixaSalarial)){
			$this->msg = $oSicasParamFaixaSalarialBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasParamFaixaSalarial
	 *
	 * @access public
	 * @param SicasParamFaixaSalarial $oSicasParamFaixaSalarial
	 * @return bool
	 */
	public function alterar($oSicasParamFaixaSalarial = NULL){
		if($oSicasParamFaixaSalarial == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasParamFaixaSalarial(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasParamFaixaSalarial($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasParamFaixaSalarial = new SicasParamFaixaSalarial($cd_param_faixa_sal,$val_faixa_inicial,$flg_faixa_ini_inclusive,$val_faixa_final,$flg_faixa_fin_inclusive,$percentagem_desconto,$status,$servidor_efetivo);
		}		
		$oSicasParamFaixaSalarialBD = new SicasParamFaixaSalarialBD();
		if(!$oSicasParamFaixaSalarialBD->alterar($oSicasParamFaixaSalarial)){
			$this->msg = $oSicasParamFaixaSalarialBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasParamFaixaSalarial
	 *
	 * @access public
	 * @param integer $idSicasParamFaixaSalarial
	 * @return bool
	 */
	public function excluir($idSicasParamFaixaSalarial){		
		$oSicasParamFaixaSalarialBD = new SicasParamFaixaSalarialBD();		
		if(!$oSicasParamFaixaSalarialBD->excluir($idSicasParamFaixaSalarial)){
			$this->msg = $oSicasParamFaixaSalarialBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasParamFaixaSalarial
	 *
	 * @access public
	 * @param integer $cd_param_faixa_sal
	 * @return SicasParamFaixaSalarial
	 */
	public function get($cd_param_faixa_sal){
		$oSicasParamFaixaSalarialBD = new SicasParamFaixaSalarialBD();
		if($oSicasParamFaixaSalarialBD->msg != ''){
			$this->msg = $oSicasParamFaixaSalarialBD->msg;
			return false;
		}
		if(!$obj = $oSicasParamFaixaSalarialBD->get($cd_param_faixa_sal)){
		    $this->msg = $oSicasParamFaixaSalarialBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasParamFaixaSalarial
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasParamFaixaSalarial[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasParamFaixaSalarialBD = new SicasParamFaixaSalarialBD();
			$aux = $oSicasParamFaixaSalarialBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasParamFaixaSalarialBD->msg != ''){
				$this->msg = $oSicasParamFaixaSalarialBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasParamFaixaSalarial
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasParamFaixaSalarial
	 */
	public function consultar($valor){
		$oSicasParamFaixaSalarialBD = new SicasParamFaixaSalarialBD();	
		return $oSicasParamFaixaSalarialBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasParamFaixaSalarial
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasParamFaixaSalarialBD = new SicasParamFaixaSalarialBD();
		return $oSicasParamFaixaSalarialBD->totalColecao();
	}

}