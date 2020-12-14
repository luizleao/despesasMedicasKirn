<?php
class ControllerRhCargoComissao extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar RhCargoComissao
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formRhCargoComissao();

        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormRhCargoComissao($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
        $oSicasLotacao      = new SicasLotacao($cd_lotacao);
        $oSicasServidor     = new SicasServidor($cd_servidor);
        $oRhCargoComissao   = new RhCargoComissao(NULL,$oSicasLotacao, $oSicasServidor, $descricao, $das, $status);
        $oRhCargoComissaoBD = new RhCargoComissaoBD();
        if(!$oRhCargoComissaoBD->inserir($oRhCargoComissao)){
            $this->msg = $oRhCargoComissaoBD->msg;
            return false;
        }

        return true;
    }
    
    /**
     * Alterar dados de RhCargoComissao
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formRhCargoComissao(NULL, 2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormRhCargoComissao($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasServidor = new SicasServidor($cd_servidor);
        $oSicasLotacao = new SicasLotacao($cd_lotacao);
        $oRhCargoComissao = new RhCargoComissao($cd_cargo_comissao,$oSicasLotacao, $oSicasServidor, $descricao, $das, $status);
        $oRhCargoComissaoBD = new RhCargoComissaoBD();
        if(!$oRhCargoComissaoBD->alterar($oRhCargoComissao)){
            $this->msg = $oRhCargoComissaoBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Excluir RhCargoComissao
     *
     * @access public
     * @param integer $cd_cargo_comissao
     * @return bool
     */
    public function excluir($cd_cargo_comissao){
        $oRhCargoComissaoBD = new RhCargoComissaoBD();
        if(!$oRhCargoComissaoBD->excluir($cd_cargo_comissao)){
            $this->msg = $oRhCargoComissaoBD->msg;
            return false;
        }
        return true;
    }
        
    /**
     * get registro de RhCargoComissao
     *
     * @access public
     * @param integer $cd_cargo_comissao
     * @return RhCargoComissao
     */
    public function get($cd_cargo_comissao){
        $oRhCargoComissaoBD = new RhCargoComissaoBD();
        if($oRhCargoComissaoBD->msg != ''){
            $this->msg = $oRhCargoComissaoBD->msg;
            return false;
        }
        return $oRhCargoComissaoBD->get($cd_cargo_comissao);
    }
    
    /**
     * get registro de RhCargoComissao por servidor
     *
     * @access public
     * @param integer $cd_servidor
     * @return RhCargoComissao
     */
    public function getByServidor($cd_servidor){
        $oRhCargoComissaoBD = new RhCargoComissaoBD();
        if($oRhCargoComissaoBD->msg != ''){
            $this->msg = $oRhCargoComissaoBD->msg;
            return false;
        }
        return $oRhCargoComissaoBD->getByServidor($cd_servidor);
    }
    
    /**
     * Carregar Colecao de dados de RhCargoComissao
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return RhCargoComissao[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oRhCargoComissaoBD = new RhCargoComissaoBD();
        if($oRhCargoComissaoBD->msg != ''){
            $this->msg = $oRhCargoComissaoBD->msg;
            return false;
        }
        return $oRhCargoComissaoBD->getAll($aFiltro, $aOrdenacao);
    }
    
    
    /**
     * Consultar registros de RhCargoComissao
     *
     * @access public
     * @param string $valor
     * @return RhCargoComissao
     */
    public function consultar($valor){
        $oRhCargoComissaoBD = new RhCargoComissaoBD();
        return $oRhCargoComissaoBD->consultar($valor);
    }
    
    /**
     * Total de registros de RhCargoComissao
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oRhCargoComissaoBD = new RhCargoComissaoBD();
        return $oRhCargoComissaoBD->totalColecao();
    }
}