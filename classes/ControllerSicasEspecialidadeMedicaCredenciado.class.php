<?php
class ControllerSicasEspecialidadeMedicaCredenciado extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }

    /**
     * Cadastrar SicasEspecialidadeMedicaCredenciado
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasEspecialidadeMedicaCredenciado();
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasEspecialidadeMedicaCredenciado($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasCredenciado = new SicasCredenciado($cd_credenciado);
        $oSicasEspecialidadeMedica = new SicasEspecialidadeMedica($cd_especialidade_medica);
        $oSicasEspecialidadeMedicaCredenciado = new SicasEspecialidadeMedicaCredenciado($cd_especialidade_medica_credenciado, $oSicasCredenciado, $oSicasEspecialidadeMedica, $status);
        $oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
        if(!$oSicasEspecialidadeMedicaCredenciadoBD->inserir($oSicasEspecialidadeMedicaCredenciado)){
            $this->msg = $oSicasEspecialidadeMedicaCredenciadoBD->msg;
            return false;
        }
        
        return true;
    }
    
    /**
     * Alterar dados de SicasEspecialidadeMedicaCredenciado
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasEspecialidadeMedicaCredenciado(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasEspecialidadeMedicaCredenciado($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasCredenciado = new SicasCredenciado($cd_credenciado);
        $oSicasEspecialidadeMedica = new SicasEspecialidadeMedica($cd_especialidade_medica);
        $oSicasEspecialidadeMedicaCredenciado = new SicasEspecialidadeMedicaCredenciado($cd_especialidade_medica_credenciado, $oSicasCredenciado, $oSicasEspecialidadeMedica, $status);
        $oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
        if(!$oSicasEspecialidadeMedicaCredenciadoBD->alterar($oSicasEspecialidadeMedicaCredenciado)){
            $this->msg = $oSicasEspecialidadeMedicaCredenciadoBD->msg;
            return false;
        }
        return true;
    }
    
    
    /**
     * Excluir SicasEspecialidadeMedicaCredenciado
     *
     * @access public
     * @param integer $cd_especialidade_medica_credenciado
     * @return bool
     */
    public function excluir($cd_especialidade_medica_credenciado){
        $oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
        if(!$oSicasEspecialidadeMedicaCredenciadoBD->excluir($cd_especialidade_medica_credenciado)){
            $this->msg = $oSicasEspecialidadeMedicaCredenciadoBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * get registro de SicasEspecialidadeMedicaCredenciado
     *
     * @access public
     * @param integer $cd_especialidade_medica_credenciado
     * @return SicasEspecialidadeMedicaCredenciado
     */
    public function get($cd_especialidade_medica_credenciado){
        $oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
        if($oSicasEspecialidadeMedicaCredenciadoBD->msg != ''){
            $this->msg = $oSicasEspecialidadeMedicaCredenciadoBD->msg;
            return false;
        }
        return $oSicasEspecialidadeMedicaCredenciadoBD->get($cd_especialidade_medica_credenciado);
    }
    
    /**
     * Carregar Colecao de dados de SicasEspecialidadeMedicaCredenciado
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return SicasEspecialidadeMedicaCredenciado[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
        if($oSicasEspecialidadeMedicaCredenciadoBD->msg != ''){
            $this->msg = $oSicasEspecialidadeMedicaCredenciadoBD->msg;
            return false;
        }
        return $oSicasEspecialidadeMedicaCredenciadoBD->getAll($aFiltro, $aOrdenacao);
    }
    
    /**
     * Consultar registros de SicasEspecialidadeMedicaCredenciado
     *
     * @access public
     * @param string $valor
     * @return SicasEspecialidadeMedicaCredenciado
     */
    public function consultar($valor){
        $oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
        return $oSicasEspecialidadeMedicaCredenciadoBD->consultar($valor);
    }
    
    /**
     * Total de registros de SicasEspecialidadeMedicaCredenciado
     *
     * @access public
     * @return integer
     */
    public function totalColecao(){
        $oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
        return $oSicasEspecialidadeMedicaCredenciadoBD->totalColecao();
    }
}