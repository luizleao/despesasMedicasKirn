<?php
class ControllerSicasEstadoCivil extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar SicasEstadoCivil
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasEstadoCivil();
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasEstadoCivil($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasEstadoCivil = new SicasEstadoCivil($cd_estado_civil, $nm_estado_civil, $status);
        $oSicasEstadoCivilBD = new SicasEstadoCivilBD();
        if(!$oSicasEstadoCivilBD->inserir($oSicasEstadoCivil)){
            $this->msg = $oSicasEstadoCivilBD->msg;
            return false;
        }
        
        return true;
    }
    
    /**
     * Alterar dados de SicasEstadoCivil
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasEstadoCivil(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasEstadoCivil($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);

        // cria objeto para grava-lo no BD
        $oSicasEstadoCivil = new SicasEstadoCivil($cd_estado_civil, $nm_estado_civil, $status);
        $oSicasEstadoCivilBD = new SicasEstadoCivilBD();
        if(!$oSicasEstadoCivilBD->alterar($oSicasEstadoCivil)){
            $this->msg = $oSicasEstadoCivilBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Excluir SicasEstadoCivil
     *
     * @access public
     * @param integer $idSicasEstadoCivil
     * @return bool
     */
    public function excluir($idSicasEstadoCivil){
        $oSicasEstadoCivilBD = new SicasEstadoCivilBD();
        if(!$oSicasEstadoCivilBD->excluir($idSicasEstadoCivil)){
            $this->msg = $oSicasEstadoCivilBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * get registro de SicasEstadoCivil
     *
     * @access public
     * @param integer $cd_estado_civil
     * @return SicasEstadoCivil
     */
    public function get($cd_estado_civil){
        $oSicasEstadoCivilBD = new SicasEstadoCivilBD();
        if($oSicasEstadoCivilBD->msg != ''){
            $this->msg = $oSicasEstadoCivilBD->msg;
            return false;
        }
        return $oSicasEstadoCivilBD->get($cd_estado_civil);
    }
    
    /**
     * Carregar Colecao de dados de SicasEstadoCivil
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return SicasEstadoCivil[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oSicasEstadoCivilBD = new SicasEstadoCivilBD();
        if($oSicasEstadoCivilBD->msg != ''){
            $this->msg = $oSicasEstadoCivilBD->msg;
            return false;
        }
        return $oSicasEstadoCivilBD->getAll($aFiltro, $aOrdenacao);
    }
       
    /**
     * Consultar registros de SicasEstadoCivil
     *
     * @access public
     * @param string $valor
     * @return SicasEstadoCivil
     */
    public function consultar($valor){
        $oSicasEstadoCivilBD = new SicasEstadoCivilBD();
        return $oSicasEstadoCivilBD->consultar($valor);
    }
    
    /**
     * Total de registros de SicasEstadoCivil
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oSicasEstadoCivilBD = new SicasEstadoCivilBD();
        return $oSicasEstadoCivilBD->totalColecao();
    }
}