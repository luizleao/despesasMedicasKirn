<?php
class ControllerSicasProcedimentoAutorizado extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasProcedimentoAutorizado
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasProcedimentoAutorizado($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasProcedimentoAutorizado($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasEncaminhamento = new SicasEncaminhamento($cd_encaminhamento);
		$oSicasProcedimento = new SicasProcedimento($cd_procedimento);
		$oSicasProcedimentoAutorizado = new SicasProcedimentoAutorizado($cd_procedimento_autorizado,$oSicasEncaminhamento,$oSicasProcedimento,$qtd_servico_autorizado,$status);
		$oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD();
		if(!$oSicasProcedimentoAutorizadoBD->cadastrar($oSicasProcedimentoAutorizado)){
			$this->msg = $oSicasProcedimentoAutorizadoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasProcedimentoAutorizado
	 *
	 * @access public
	 * @param SicasProcedimentoAutorizado $oSicasProcedimentoAutorizado
	 * @return bool
	 */
	public function alterar($oSicasProcedimentoAutorizado = NULL){
		if($oSicasProcedimentoAutorizado == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasProcedimentoAutorizado(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasProcedimentoAutorizado($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasEncaminhamento = new SicasEncaminhamento($cd_encaminhamento);
			$oSicasProcedimento = new SicasProcedimento($cd_procedimento);
			$oSicasProcedimentoAutorizado = new SicasProcedimentoAutorizado($cd_procedimento_autorizado,$oSicasEncaminhamento,$oSicasProcedimento,$qtd_servico_autorizado,$status);
		}		
		$oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD();
		if(!$oSicasProcedimentoAutorizadoBD->alterar($oSicasProcedimentoAutorizado)){
			$this->msg = $oSicasProcedimentoAutorizadoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasProcedimentoAutorizado
	 *
	 * @access public
	 * @param integer $idSicasProcedimentoAutorizado
	 * @return bool
	 */
	public function excluir($idSicasProcedimentoAutorizado){		
		$oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD();		
		if(!$oSicasProcedimentoAutorizadoBD->excluir($idSicasProcedimentoAutorizado)){
			$this->msg = $oSicasProcedimentoAutorizadoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasProcedimentoAutorizado
	 *
	 * @access public
	 * @param integer $cd_procedimento_autorizado
	 * @return SicasProcedimentoAutorizado
	 */
	public function get($cd_procedimento_autorizado){
		$oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD();
		if($oSicasProcedimentoAutorizadoBD->msg != ''){
			$this->msg = $oSicasProcedimentoAutorizadoBD->msg;
			return false;
		}
		if(!$obj = $oSicasProcedimentoAutorizadoBD->get($cd_procedimento_autorizado)){
		    $this->msg = $oSicasProcedimentoAutorizadoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasProcedimentoAutorizado
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasProcedimentoAutorizado[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD();
			$aux = $oSicasProcedimentoAutorizadoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasProcedimentoAutorizadoBD->msg != ''){
				$this->msg = $oSicasProcedimentoAutorizadoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasProcedimentoAutorizado
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasProcedimentoAutorizado
	 */
	public function consultar($valor){
		$oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD();	
		return $oSicasProcedimentoAutorizadoBD->consultar($valor);
	}
	

	/**
	 * Total de registros de SicasProcedimentoAutorizado
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD();
		return $oSicasProcedimentoAutorizadoBD->totalColecao();
	}
	
	/**
	 * Retorna a lista de procedimentos autorizados do servidor
	 * 
	 * @param integer $cd_servidor
	 * @return boolean|SicasProcedimentoAutorizado[]
	 */
	public function getAllProcedimentoServidor($cd_servidor){
	    $oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD();
	    return $oSicasProcedimentoAutorizadoBD->getAllProcedimentoServidor($cd_servidor);
	}

	/**
	 * Carregar Colecao de dados dos Procedimento que ainda não foram lançados como despesa 
	 *
	 * @access public
	 * @param int $cd_credenciado
	 * @param string $data_inicio
	 * @param string $data_fim
	 * @return SicasProcedimentoAutorizado[]
	 */
	public function getAllProcedimentoPendenteCredenciado($cd_credenciado, $data_inicio, $data_fim){
	    try{
	        $oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD();
	        $aux = $oSicasProcedimentoAutorizadoBD->getAllProcedimentoPendenteCredenciado($cd_credenciado, $data_inicio, $data_fim);
	        
	        if($oSicasProcedimentoAutorizadoBD->msg != ''){
	            $this->msg = $oSicasProcedimentoAutorizadoBD->msg;
	            return false;
	        }
	        return $aux;
	    } catch(Exception $e){
	        $this->msg = $e->getMessage();
	        return false;
	    }
	}
}