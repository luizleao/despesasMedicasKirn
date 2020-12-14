<?php
class ControllerSicasMedico extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasMedico
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasMedico($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasMedico($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasServidor = new SicasServidor($cd_servidor);
		$oSicasMedico = new SicasMedico($cd_medico,$login,$status,$crm,$oSicasServidor);
		$oSicasMedicoBD = new SicasMedicoBD();
		if(!$oSicasMedicoBD->cadastrar($oSicasMedico)){
			$this->msg = $oSicasMedicoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasMedico
	 *
	 * @access public
	 * @param SicasMedico $oSicasMedico
	 * @return bool
	 */
	public function alterar($oSicasMedico = NULL){
		if($oSicasMedico == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasMedico(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasMedico($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasServidor = new SicasServidor($cd_servidor);
			$oSicasMedico = new SicasMedico($cd_medico,$login,$status,$crm,$oSicasServidor);
		}		
		$oSicasMedicoBD = new SicasMedicoBD();
		if(!$oSicasMedicoBD->alterar($oSicasMedico)){
			$this->msg = $oSicasMedicoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasMedico
	 *
	 * @access public
	 * @param integer $idSicasMedico
	 * @return bool
	 */
	public function excluir($idSicasMedico){		
		$oSicasMedicoBD = new SicasMedicoBD();		
		if(!$oSicasMedicoBD->excluir($idSicasMedico)){
			$this->msg = $oSicasMedicoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasMedico
	 *
	 * @access public
	 * @param integer $cd_medico
	 * @return SicasMedico
	 */
	public function get($cd_medico){
		$oSicasMedicoBD = new SicasMedicoBD();
		if($oSicasMedicoBD->msg != ''){
			$this->msg = $oSicasMedicoBD->msg;
			return false;
		}
		if(!$obj = $oSicasMedicoBD->get($cd_medico)){
		    $this->msg = $oSicasMedicoBD->msg;
		    return false;
		}
		return $obj;
	}
	
	/**
	 * Selecionar registro de SicasMedico por Servidor
	 *
	 * @access public
	 * @param integer $cd_servidor
	 * @return SicasMedico
	 */
	public function getByServidor($cd_servidor){
	    $oSicasMedicoBD = new SicasMedicoBD();
	    if($oSicasMedicoBD->msg != ''){
	        $this->msg = $oSicasMedicoBD->msg;
	        return false;
	    }
	    if(!$obj = $oSicasMedicoBD->getByServidor($cd_servidor)){
	        $this->msg = $oSicasMedicoBD->msg;
	        return false;
	    }
	    return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasMedico
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasMedico[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasMedicoBD = new SicasMedicoBD();
			$aux = $oSicasMedicoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasMedicoBD->msg != ''){
				$this->msg = $oSicasMedicoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasMedico
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasMedico
	 */
	public function consultar($valor){
		$oSicasMedicoBD = new SicasMedicoBD();	
		return $oSicasMedicoBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasMedico
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasMedicoBD = new SicasMedicoBD();
		return $oSicasMedicoBD->totalColecao();
	}

}