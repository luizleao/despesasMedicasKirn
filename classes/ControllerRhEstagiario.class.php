<?php
class ControllerRhEstagiario extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }

    /**
     * Cadastrar RhEstagiario
     *
     * @access public
     * @param $post
     * @return bool
     */
    public function cadastrar($post = NULL){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhEstagiario($post);
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhEstagiario($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasPessoa = new SicasPessoa($cd_pessoa);
        $oSicasLotacao = new SicasLotacao($cd_lotacao);
        $oRhIes = new RhIes($cd_ies);
        $oRhEstagiario = new RhEstagiario($cd_estagiario,$oSicasPessoa,$oSicasLotacao,$oRhIes,$num_processo,$dt_inicio,$dt_renovacao,$status);
        $oRhEstagiarioBD = new RhEstagiarioBD();
        if(!$oRhEstagiarioBD->cadastrar($oRhEstagiario)){
            $this->msg = $oRhEstagiarioBD->msg;
            return false;
        }

        return true;
    }
    
    /**
     * Alterar dados de RhEstagiario
     *
     * @access public
     * @param RhEstagiario $oRhEstagiario
     * @return bool
     */
    public function alterar($oRhEstagiario = NULL){
        if($oRhEstagiario == NULL){
            // recebe dados do formulario
            $post = DadosFormulario::formularioCadastroRhEstagiario(NULL, 2);
            // valida dados do formulario
            $oValidador = new ValidadorFormulario();
            if(!$oValidador->validaFormularioCadastroRhEstagiario($post,2)){
                $this->msg = $oValidador->msg;
                return false;
            }
            // cria variaveis para validacao com as chaves do array
            foreach($post as $i => $v) $$i = utf8_encode($v);
            // cria objeto para grava-lo no BD
            $oSicasPessoa  = new SicasPessoa($cd_pessoa);
            $oSicasLotacao = new SicasLotacao($cd_lotacao);
            $oRhIes        = new RhIes($cd_ies);
            $oRhEstagiario = new RhEstagiario($cd_estagiario,$oSicasPessoa,$oSicasLotacao,$oRhIes,$num_processo,$dt_inicio,$dt_renovacao,$status);
        }
        $oRhEstagiarioBD = new RhEstagiarioBD();
        if(!$oRhEstagiarioBD->alterar($oRhEstagiario)){
            $this->msg = $oRhEstagiarioBD->msg;
            return false;
        }
        return true;
    }
    
    
    /**
     * Excluir RhEstagiario
     *
     * @access public
     * @param integer $cd_estagiario
     * @return bool
     */
    public function excluir($cd_estagiario){
        $oRhEstagiarioBD = new RhEstagiarioBD();
        if(!$oRhEstagiarioBD->excluir($cd_estagiario)){
            $this->msg = $oRhEstagiarioBD->msg;
            return false;
        }
        return true;
    }
    
    
    /**
     * get registro de RhEstagiario
     *
     * @access public
     * @param integer $cd_estagiario
     * @return RhEstagiario
     */
    public function get($cd_estagiario){
        $oRhEstagiarioBD = new RhEstagiarioBD();
        if($oRhEstagiarioBD->msg != ''){
            $this->msg = $oRhEstagiarioBD->msg;
            return false;
        }
        return $oRhEstagiarioBD->get($cd_estagiario);
    }
    
    
    /**
     * Carregar Colecao de dados de RhEstagiario
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return RhEstagiario[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oRhEstagiarioBD = new RhEstagiarioBD();
        if($oRhEstagiarioBD->msg != ''){
            $this->msg = $oRhEstagiarioBD->msg;
            return false;
        }
        return $oRhEstagiarioBD->getAll($aFiltro, $aOrdenacao);
    }
    
    
    /**
     * Consultar registros de RhEstagiario
     *
     * @access public
     * @param string $valor
     * @return RhEstagiario
     */
    public function consultar($valor){
        $oRhEstagiarioBD = new RhEstagiarioBD();
        return $oRhEstagiarioBD->consultar($valor);
    }
    
    /**
     * Total de registros de RhEstagiario
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oRhEstagiarioBD = new RhEstagiarioBD();
        return $oRhEstagiarioBD->totalColecao();
    }
}