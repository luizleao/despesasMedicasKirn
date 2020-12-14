<?php
class ControllerSicasEspecialidadeMedica extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }

    /**
     * Cadastrar SicasEspecialidadeMedica
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasEspecialidadeMedica();

        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasEspecialidadeMedica($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
        $oSicasEspecialidadeMedica = new SicasEspecialidadeMedica($cd_especialidade_medica, $nm_especialidade, $status);
        $oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
        if(!$oSicasEspecialidadeMedicaBD->inserir($oSicasEspecialidadeMedica)){
            $this->msg = $oSicasEspecialidadeMedicaBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Alterar dados de SicasEspecialidadeMedica
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasEspecialidadeMedica(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasEspecialidadeMedica($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
        $oSicasEspecialidadeMedica = new SicasEspecialidadeMedica($cd_especialidade_medica, $nm_especialidade, $status);
        $oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
        if(!$oSicasEspecialidadeMedicaBD->alterar($oSicasEspecialidadeMedica)){
            $this->msg = $oSicasEspecialidadeMedicaBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Excluir SicasEspecialidadeMedica
     *
     * @access public
     * @param integer $idSicasEspecialidadeMedica
     * @return bool
     */
    public function excluir($idSicasEspecialidadeMedica){
        $oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
        if(!$oSicasEspecialidadeMedicaBD->excluir($idSicasEspecialidadeMedica)){
            $this->msg = $oSicasEspecialidadeMedicaBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * get registro de SicasEspecialidadeMedica
     *
     * @access public
     * @param integer $cd_especialidade_medica
     * @return SicasEspecialidadeMedica
     */
    public function get($cd_especialidade_medica){
        $oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
        if($oSicasEspecialidadeMedicaBD->msg != ''){
            $this->msg = $oSicasEspecialidadeMedicaBD->msg;
            return false;
        }
        return $oSicasEspecialidadeMedicaBD->get($cd_especialidade_medica);
    }
    
    /**
     * Carregar Colecao de dados de SicasEspecialidadeMedica
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return SicasEspecialidadeMedica[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
        if($oSicasEspecialidadeMedicaBD->msg != ''){
            $this->msg = $oSicasEspecialidadeMedicaBD->msg;
            return false;
        }
        return $oSicasEspecialidadeMedicaBD->getAll($aFiltro, $aOrdenacao);
    }
    
    /**
     * Consultar registros de SicasEspecialidadeMedica
     *
     * @access public
     * @param string $valor
     * @return SicasEspecialidadeMedica
     */
    public function consultar($valor){
        $oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
        return $oSicasEspecialidadeMedicaBD->consultar($valor);
    }
    
    /**
     * Total de registros de SicasEspecialidadeMedica
     *
     * @access public
     * @return integer
     */
    public function totalColecao(){
        $oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
        return $oSicasEspecialidadeMedicaBD->totalColecao();
    }
}