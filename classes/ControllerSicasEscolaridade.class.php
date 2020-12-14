<?php
class ControllerSicasEscolaridade extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar SicasEscolaridade
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasEscolaridade();
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasEscolaridade($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
        $oSicasEscolaridade = new SicasEscolaridade($cd_escolaridade, $nm_escolaridade, $status);
        $oSicasEscolaridadeBD = new SicasEscolaridadeBD();
        if(!$oSicasEscolaridadeBD->inserir($oSicasEscolaridade)){
            $this->msg = $oSicasEscolaridadeBD->msg;
            return false;
        }
        
        return true;
    }
    
    /**
     * Alterar dados de SicasEscolaridade
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasEscolaridade(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasEscolaridade($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
        $oSicasEscolaridade = new SicasEscolaridade($cd_escolaridade, $nm_escolaridade, $status);
        $oSicasEscolaridadeBD = new SicasEscolaridadeBD();
        if(!$oSicasEscolaridadeBD->alterar($oSicasEscolaridade)){
            $this->msg = $oSicasEscolaridadeBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Excluir SicasEscolaridade
     *
     * @access public
     * @param integer $idSicasEscolaridade
     * @return bool
     */
    public function excluir($idSicasEscolaridade){
        $oSicasEscolaridadeBD = new SicasEscolaridadeBD();
        if(!$oSicasEscolaridadeBD->excluir($idSicasEscolaridade)){
            $this->msg = $oSicasEscolaridadeBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * get registro de SicasEscolaridade
     *
     * @access public
     * @param integer $cd_escolaridade
     * @return SicasEscolaridade
     */
    public function get($cd_escolaridade){
        $oSicasEscolaridadeBD = new SicasEscolaridadeBD();
        if($oSicasEscolaridadeBD->msg != ''){
            $this->msg = $oSicasEscolaridadeBD->msg;
            return false;
        }
        return $oSicasEscolaridadeBD->get($cd_escolaridade);
    }
    
    /**
     * Carregar Colecao de dados de SicasEscolaridade
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return SicasEscolaridade[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oSicasEscolaridadeBD = new SicasEscolaridadeBD();
        if($oSicasEscolaridadeBD->msg != ''){
            $this->msg = $oSicasEscolaridadeBD->msg;
            return false;
        }
        return $oSicasEscolaridadeBD->getAll($aFiltro, $aOrdenacao);
    }
    
    /**
     * Consultar registros de SicasEscolaridade
     *
     * @access public
     * @param string $valor
     * @return SicasEscolaridade
     */
    public function consultar($valor){
        $oSicasEscolaridadeBD = new SicasEscolaridadeBD();
        return $oSicasEscolaridadeBD->consultar($valor);
    }
    
    /**
     * Total de registros de SicasEscolaridade
     *
     * @access public
     * @return number
     */
    public function total(){
        $oSicasEscolaridadeBD = new SicasEscolaridadeBD();
        return $oSicasEscolaridadeBD->totalColecao();
    }
}