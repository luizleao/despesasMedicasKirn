<?php
class ControllerRhCargo extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }

    /**
     * Cadastrar RhCargo
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhCargo();
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhCargo($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v)
            $$i = $v;
            // cria objeto para grava-lo no BD
            $oRhCargo = new RhCargo($cd_cargo, $descricao_cargo, $descricao_cargo_abrev, $num_siape_cargo, $status);
            $oRhCargoBD = new RhCargoBD();
            if(!$oRhCargoBD->inserir($oRhCargo)){
                $this->msg = $oRhCargoBD->msg;
                return false;
            }
        return true;
    }
    
    /**
     * Alterar dados de RhCargo
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhCargo(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhCargo($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v)
            $$i = $v;
        // cria objeto para grava-lo no BD
        $oRhCargo = new RhCargo($cd_cargo, $descricao_cargo, $descricao_cargo_abrev, $num_siape_cargo, $status);
        $oRhCargoBD = new RhCargoBD();
        if(!$oRhCargoBD->alterar($oRhCargo)){
            $this->msg = $oRhCargoBD->msg;
            return false;
        }
        return true;
    }
    
    
    /**
     * Excluir RhCargo
     *
     * @access public
     * @param integer $idRhCargo
     * @return bool
     */
    public function excluir($idRhCargo){
        $oRhCargoBD = new RhCargoBD();
        if(!$oRhCargoBD->excluir($idRhCargo)){
            $this->msg = $oRhCargoBD->msg;
            return false;
        }
        return true;
    }
    
    
    /**
     * get registro de RhCargo
     *
     * @access public
     * @param integer $cd_cargo
     * @return RhCargo
     */
    public function get($cd_cargo){
        $oRhCargoBD = new RhCargoBD();
        if($oRhCargoBD->msg != ''){
            $this->msg = $oRhCargoBD->msg;
            return false;
        }
        return $oRhCargoBD->get($cd_cargo);
    }
    
    
    /**
     * Carregar Colecao de dados de RhCargo
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return RhCargo[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oRhCargoBD = new RhCargoBD();
        if($oRhCargoBD->msg != ''){
            $this->msg = $oRhCargoBD->msg;
            return false;
        }
        return $oRhCargoBD->getAll($aFiltro, $aOrdenacao);
    }
    
    
    /**
     * Consultar registros de RhCargo
     *
     * @access public
     * @param string $valor
     * @return RhCargo
     */
    public function consultar($valor){
        $oRhCargoBD = new RhCargoBD();
        return $oRhCargoBD->consultar($valor);
    }
    
    /**
     * Total de registros de RhCargo
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oRhCargoBD = new RhCargoBD();
        return $oRhCargoBD->totalColecao();
    }
}