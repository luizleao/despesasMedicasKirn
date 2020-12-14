<?php
class ControllerSicasLotacao extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }

    /**
     * Cadastrar SicasLotacao
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasLotacao();
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasLotacao($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
        $oSicasLotacao = new SicasLotacao($cd_lotacao, $sigla, $cd_siged, $nm_lotacao, $status);
        $oSicasLotacaoBD = new SicasLotacaoBD();
        if(!$oSicasLotacaoBD->inserir($oSicasLotacao)){
            $this->msg = $oSicasLotacaoBD->msg;
            return false;
        }
        
        return true;
    }

    /**
     * Alterar dados de SicasLotacao
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasLotacao(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasLotacao($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
        $oSicasLotacao = new SicasLotacao($cd_lotacao, $sigla, $cd_siged, $nm_lotacao, $status);
        $oSicasLotacaoBD = new SicasLotacaoBD();
        if(!$oSicasLotacaoBD->alterar($oSicasLotacao)){
            $this->msg = $oSicasLotacaoBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Excluir SicasLotacao
     *
     * @access public
     * @param integer $idSicasLotacao
     * @return bool
     */
    public function excluir($idSicasLotacao){
        $oSicasLotacaoBD = new SicasLotacaoBD();
        if(!$oSicasLotacaoBD->excluir($idSicasLotacao)){
            $this->msg = $oSicasLotacaoBD->msg;
            return false;
        }
        return true;
    }
    
    
    /**
     * get registro de SicasLotacao
     *
     * @access public
     * @param integer $cd_lotacao
     * @return SicasLotacao
     */
    public function get($cd_lotacao){
        $oSicasLotacaoBD = new SicasLotacaoBD();
        if($oSicasLotacaoBD->msg != ''){
            $this->msg = $oSicasLotacaoBD->msg;
            return false;
        }
        return $oSicasLotacaoBD->get($cd_lotacao);
    }
    
    /**
     * Carregar Colecao de dados de SicasLotacao
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return SicasLotacao[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oSicasLotacaoBD = new SicasLotacaoBD();
        if($oSicasLotacaoBD->msg != ''){
            $this->msg = $oSicasLotacaoBD->msg;
            return false;
        }
        
        if(!$retorno = $oSicasLotacaoBD->getAll($aFiltro, $aOrdenacao)){
            $this->msg = $oSicasLotacaoBD->msg;
            return false;
        }
        return $retorno;
    }
    
    /**
     * Consultar registros de SicasLotacao
     *
     * @access public
     * @param string $valor
     * @return SicasLotacao
     */
    public function consultar($valor){
        $oSicasLotacaoBD = new SicasLotacaoBD();
        return $oSicasLotacaoBD->consultar($valor);
    }
    
    /**
     * Total de registros de SicasLotacao
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oSicasLotacaoBD = new SicasLotacaoBD();
        return $oSicasLotacaoBD->totalColecao();
    }
}