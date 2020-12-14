<?php
class ControllerRhIes extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar RhIes
     *
     * @access public
     * @param $post
     * @return bool
     */
    public function cadastrar($post = NULL){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhIes($post);
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhIes($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oRhIes = new RhIes($cd_ies,$sigla,$descricao,$endereco,$telefone1,$telefone2,$telefone3,$email,$status);
        $oRhIesBD = new RhIesBD();
        if(!$oRhIesBD->cadastrar($oRhIes)){
            $this->msg = $oRhIesBD->msg;
            return false;
        }

        return true;
    }
    
    /**
     * Alterar dados de RhIes
     *
     * @access public
     * @param RhIes $oRhIes
     * @return bool
     */
    public function alterar($oRhIes = NULL){
        if($oRhIes == NULL){
            // recebe dados do formulario
            $post = DadosFormulario::formularioCadastroRhIes(NULL, 2);
            // valida dados do formulario
            $oValidador = new ValidadorFormulario();
            if(!$oValidador->validaFormularioCadastroRhIes($post,2)){
                $this->msg = $oValidador->msg;
                return false;
            }
            // cria variaveis para validacao com as chaves do array
            foreach($post as $i => $v) $$i = utf8_encode($v);
            // cria objeto para grava-lo no BD
            $oRhIes = new RhIes($cd_ies,$sigla,$descricao,$endereco,$telefone1,$telefone2,$telefone3,$email,$status);
        }
        $oRhIesBD = new RhIesBD();
        if(!$oRhIesBD->alterar($oRhIes)){
            $this->msg = $oRhIesBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Excluir RhIes
     *
     * @access public
     * @param integer $cd_ies
     * @return bool
     */
    public function excluir($cd_ies){
        $oRhIesBD = new RhIesBD();
        if(!$oRhIesBD->excluir($cd_ies)){
            $this->msg = $oRhIesBD->msg;
            return false;
        }
        return true;
    }
    
    
    /**
     * get registro de RhIes
     *
     * @access public
     * @param integer $cd_cargo
     * @return RhIes
     */
    public function get($cd_ies){
        $oRhIesBD = new RhIesBD();
        if($oRhIesBD->msg != ''){
            $this->msg = $oRhIesBD->msg;
            return false;
        }
        return $oRhIesBD->get($cd_ies);
    }
    
    
    /**
     * Carregar Colecao de dados de RhIes
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return RhIes[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oRhIesBD = new RhIesBD();
        if($oRhIesBD->msg != ''){
            $this->msg = $oRhIesBD->msg;
            return false;
        }
        return $oRhIesBD->getAll($aFiltro, $aOrdenacao);
    }
    
    
    /**
     * Consultar registros de RhIes
     *
     * @access public
     * @param string $valor
     * @return RhIes
     */
    public function consultar($valor){
        $oRhIesBD = new RhIesBD();
        return $oRhIesBD->consultar($valor);
    }
    
    /**
     * Total de registros de RhIes
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oRhIesBD = new RhIesBD();
        return $oRhIesBD->totalColecao();
    }
}