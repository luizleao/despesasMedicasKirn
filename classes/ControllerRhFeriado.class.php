<?php
class ControllerRhFeriado extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar RhFeriado
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhFeriado();
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhFeriado($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oRhFeriado = new RhFeriado($cd_feriado, $data_feriado, $descricao_feriado, $esfera_feriado);
        $oRhFeriadoBD = new RhFeriadoBD();
        if(!$oRhFeriadoBD->inserir($oRhFeriado)){
            $this->msg = $oRhFeriadoBD->msg;
            return false;
        }
        
        return true;
    }
    
    /**
     * Alterar dados de RhFeriado
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhFeriado(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhFeriado($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oRhFeriado = new RhFeriado($cd_feriado, $data_feriado, $descricao_feriado, $esfera_feriado);
        $oRhFeriadoBD = new RhFeriadoBD();
        if(!$oRhFeriadoBD->alterar($oRhFeriado)){
            $this->msg = $oRhFeriadoBD->msg;
            return false;
        }
        return true;
    }

    /**
     * Excluir RhFeriado
     *
     * @access public
     * @param integer $cd_ies
     * @return bool
     */
    public function excluir($cd_ies){
        $oRhFeriadoBD = new RhFeriadoBD();
        if(!$oRhFeriadoBD->excluir($cd_ies)){
            $this->msg = $oRhFeriadoBD->msg;
            return false;
        }
        return true;
    }
    
    
    /**
     * get registro de RhFeriado
     *
     * @access public
     * @param integer $cd_cargo
     * @return RhFeriado
     */
    public function get($cd_ies){
        $oRhFeriadoBD = new RhFeriadoBD();
        if($oRhFeriadoBD->msg != ''){
            $this->msg = $oRhFeriadoBD->msg;
            return false;
        }
        return $oRhFeriadoBD->get($cd_ies);
    }
    
    
    /**
     * Carregar Colecao de dados de RhFeriado
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return RhFeriado[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oRhFeriadoBD = new RhFeriadoBD();
        if($oRhFeriadoBD->msg != ''){
            $this->msg = $oRhFeriadoBD->msg;
            return false;
        }
        return $oRhFeriadoBD->getAll($aFiltro, $aOrdenacao);
    }
    
    
    /**
     * Consultar registros de RhFeriado
     *
     * @access public
     * @param string $valor
     * @return RhFeriado
     */
    public function consultar($valor){
        $oRhFeriadoBD = new RhFeriadoBD();
        return $oRhFeriadoBD->consultar($valor);
    }
    
    /**
     * Total de registros de RhFeriado
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oRhFeriadoBD = new RhFeriadoBD();
        return $oRhFeriadoBD->totalColecao();
    }
}