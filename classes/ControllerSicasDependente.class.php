<?php
class ControllerSicasDependente extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasDependente
	 *
	 * @access public
	 * @return bool
	 */
	public function cadastrar(){
		// recebe dados do formulario
		$post = DadosFormulario::formularioCadastroSicasDependente();
		
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormularioCadastroSicasDependente($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
		$oSicasServidor = new SicasServidor($cd_servidor);
		
		//Recupera o proximo cd de sequencia
		$cd_seq_dependente = $this->getNextSeq($cd_servidor);
		
		$oSicasPessoa = new SicasPessoa($cd_pessoa);
		$oSicasGrauParentesco = new SicasGrauParentesco($cd_grau_parentesco);
		$oSicasEscolaridade = new SicasEscolaridade($cd_escolaridade);
		$oSicasDependente = new SicasDependente($cd_dependente, $oSicasServidor, $oSicasPessoa, $cd_seq_dependente, $oSicasGrauParentesco, $oSicasEscolaridade, $dt_inclusao, $dt_manutencao, $dependente_financ, $dependente_proas, $status);
		$oSicasDependenteBD = new SicasDependenteBD();
		if(!$oSicasDependenteBD->inserir($oSicasDependente)){
			$this->msg = $oSicasDependenteBD->msg;
			return false;
		}
		return true;
	}
	
	/**
	 * Alterar dados de SicasDependente
	 *
	 * @access public
	 * @return bool
	 */
	public function alterar(){
	    // recebe dados do formulario
	    $post = DadosFormulario::formularioCadastroSicasDependente(2);
	    //Util::trace($post); exit;
	    // valida dados do formulario
	    $oValidador = new ValidadorFormulario();
	    if(!$oValidador->validaFormularioCadastroSicasDependente($post, 2)){
	        $this->msg = $oValidador->msg;
	        return false;
	    }
	    // cria variaveis para validacao com as chaves do array
	    foreach($post as $i => $v)
	        $$i = $v;
        // cria objeto para grava-lo no BD
        $oSicasServidor = new SicasServidor($cd_servidor);
        $oSicasPessoa = new SicasPessoa($cd_pessoa);
        $oSicasGrauParentesco = new SicasGrauParentesco($cd_grau_parentesco);
        $oSicasEscolaridade = new SicasEscolaridade($cd_escolaridade);
        $oSicasDependente = new SicasDependente($cd_dependente, $oSicasServidor, $oSicasPessoa, $cd_seq_dependente, $oSicasGrauParentesco, $oSicasEscolaridade, $dt_inclusao, $dt_manutencao, $dependente_financ, $dependente_proas, $status);
        $oSicasDependenteBD = new SicasDependenteBD();
        if(!$oSicasDependenteBD->alterar($oSicasDependente)){
            $this->msg = $oSicasDependenteBD->msg;
            return false;
        }
        return true;
	}
	
	/**
	 * Excluir SicasDependente
	 *
	 * @access public
	 * @param integer $idSicasDependente
	 * @return bool
	 */
	public function excluir($idSicasDependente){
	    $oSicasDependenteBD = new SicasDependenteBD();
	    if(!$oSicasDependenteBD->excluir($idSicasDependente)){
	        $this->msg = $oSicasDependenteBD->msg;
	        return false;
	    }
	    return true;
	}
	
	/**
	 * get registro de SicasDependente
	 *
	 * @access public
	 * @param integer $cd_dependente
	 * @return SicasDependente
	 */
	public function get($cd_dependente){
	    $oSicasDependenteBD = new SicasDependenteBD();
	    if($oSicasDependenteBD->msg != ''){
	        $this->msg = $oSicasDependenteBD->msg;
	        return false;
	    }
	    return $oSicasDependenteBD->get($cd_dependente);
	}
	
	/**
	 * get proximo sequencial do Dependente para o servidor
	 *
	 * @access public
	 * @param integer $cd_servidor
	 * @return integer
	 */
	public function getNextSeq($cd_servidor){
	    $oSicasDependenteBD = new SicasDependenteBD();
	    if($oSicasDependenteBD->msg != ''){
	        $this->msg = $oSicasDependenteBD->msg;
	        return false;
	    }
	    return $oSicasDependenteBD->getNextSeq($cd_servidor);
	}
	
	/**
	 * Carregar Colecao de dados de SicasDependente
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasDependente[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[]){
	    try{
	        $oSicasDependenteBD = new SicasDependenteBD();
	        $aux = $oSicasDependenteBD->getAll($aFiltro, $aOrdenacao);
	        
	        if($oSicasDependenteBD->msg != ''){
	            $this->msg = $oSicasDependenteBD->msg;
	            return false;
	        }
	        return $aux;
	    } catch(Exception $e){
	        $this->msg = $e->getMessage();
	        return false;
	    }
	}
	
	/**
	 * Consultar registros de SicasDependente
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasDependente
	 */
	public function consultar($valor){
	    $oSicasDependenteBD = new SicasDependenteBD();
	    return $oSicasDependenteBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasDependente
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecaoSicasDependente(){
	    $oSicasDependenteBD = new SicasDependenteBD();
	    return $oSicasDependenteBD->totalColecao();
	}
	
	/**
	 * get registro de SicasDependente POR PESSOA
	 *
	 * @access public
	 * @param integer $cd_pessoa
	 * @return SicasDependente
	 */
	public function getByPessoa($cd_pessoa){ //getSicasDependentePessoa
	    $oSicasDependenteBD = new SicasDependenteBD();
	    if($oSicasDependenteBD->msg != ''){
	        $this->msg = $oSicasDependenteBD->msg;
	        return false;
	    }
	    return $oSicasDependenteBD->getByPessoa($cd_pessoa);
	}
}