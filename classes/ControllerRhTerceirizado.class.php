<?php
class ControllerRhTerceirizado extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar RhTerceirizado
     *
     * @access public
     * @return bool
     */
    public function cadastraRhTerceirizado(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhTerceirizado();
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhTerceirizado($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasPessoa = new SicasPessoa($cd_pessoa);
        $oSicasLotacao = new RhRamal($cd_lotacao);
        $oRhTerceirizado = new RhTerceirizado($cd_terceirizado, $oSicasPessoa,  $oSicasLotacao, $cargo, $status);
        $oRhTerceirizadoBD = new RhTerceirizadoBD();
        if(!$oRhTerceirizadoBD->inserir($oRhTerceirizado)){
            $this->msg = $oRhTerceirizadoBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Alterar dados de RhTerceirizado
     *
     * @access public
     * @return bool
     */
    public function alteraRhTerceirizado(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhTerceirizado(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhTerceirizado($post,2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasPessoa = new SicasPessoa($cd_pessoa);
        $oSicasLotacao = new RhRamal($cd_lotacao);
        $oRhTerceirizado = new RhTerceirizado($cd_terceirizado, $oSicasPessoa,  $oSicasLotacao, $cargo, $status);
        $oRhTerceirizadoBD = new RhTerceirizadoBD();
        if(!$oRhTerceirizadoBD->alterar($oRhTerceirizado)){
            $this->msg = $oRhTerceirizadoBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Excluir RhTerceirizado
     *
     * @access public
     * @param integer $cd_ies
     * @return bool
     */
    public function excluir($cd_ies){
        $oRhTerceirizadoBD = new RhTerceirizadoBD();
        if(!$oRhTerceirizadoBD->excluir($cd_ies)){
            $this->msg = $oRhTerceirizadoBD->msg;
            return false;
        }
        return true;
    }
    
    
    /**
     * get registro de RhTerceirizado
     *
     * @access public
     * @param integer $cd_cargo
     * @return RhTerceirizado
     */
    public function get($cd_ies){
        $oRhTerceirizadoBD = new RhTerceirizadoBD();
        if($oRhTerceirizadoBD->msg != ''){
            $this->msg = $oRhTerceirizadoBD->msg;
            return false;
        }
        return $oRhTerceirizadoBD->get($cd_ies);
    }
    
    
    /**
     * Carregar Colecao de dados de RhTerceirizado
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return RhTerceirizado[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oRhTerceirizadoBD = new RhTerceirizadoBD();
        if($oRhTerceirizadoBD->msg != ''){
            $this->msg = $oRhTerceirizadoBD->msg;
            return false;
        }
        return $oRhTerceirizadoBD->getAll($aFiltro, $aOrdenacao);
    }
    
    
    /**
     * Consultar registros de RhTerceirizado
     *
     * @access public
     * @param string $valor
     * @return RhTerceirizado
     */
    public function consultar($valor){
        $oRhTerceirizadoBD = new RhTerceirizadoBD();
        return $oRhTerceirizadoBD->consultar($valor);
    }
    
    /**
     * Total de registros de RhTerceirizado
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oRhTerceirizadoBD = new RhTerceirizadoBD();
        return $oRhTerceirizadoBD->totalColecao();
    }
}