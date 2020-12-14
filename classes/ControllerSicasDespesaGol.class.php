<?php
class ControllerSicasDespesaGol extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    
    /**
     * Cadastrar SicasDespesaGol
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasDespesaGol();

        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasDespesaGol($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasPessoa = new SicasPessoa($cd_pessoa);
        $oSicasCredenciado = new SicasCredenciado($cd_credenciado);
        $oSicasTipoDespesa = new SicasTipoDespesa($cd_tipo_despesa);
        $oSicasDespesaGol = new SicasDespesaGol($cd_despesa_gol, $ano_mes, $matricula, $oSicasPessoa, $oSicasCredenciado, $vl_despesa, $vl_d_despesa, $porcentagem_desconto, $remuneracao, $oSicasTipoDespesa, $flg_desconta, $flg_fis_jur);
        $oSicasDespesaGolBD = new SicasDespesaGolBD();
        if(!$oSicasDespesaGolBD->inserir($oSicasDespesaGol)){
            $this->msg = $oSicasDespesaGolBD->msg;
            return false;
        }

        return true;
    }
    
    /**
     * Alterar dados de SicasDespesaGol
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasDespesaGol(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasDespesaGol($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasPessoa = new SicasPessoa($cd_pessoa);
        $oSicasCredenciado = new SicasCredenciado($cd_credenciado);
        $oSicasTipoDespesa = new SicasTipoDespesa($cd_tipo_despesa);
        $oSicasDespesaGol = new SicasDespesaGol($cd_despesa_gol, $ano_mes, $matricula, $oSicasPessoa, $oSicasCredenciado, $vl_despesa, $vl_d_despesa, $porcentagem_desconto, $remuneracao, $oSicasTipoDespesa, $flg_desconta, $flg_fis_jur);
        $oSicasDespesaGolBD = new SicasDespesaGolBD();
        if(!$oSicasDespesaGolBD->alterar($oSicasDespesaGol)){
            $this->msg = $oSicasDespesaGolBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Excluir SicasDespesaGol
     *
     * @access public
     * @param integer $idSicasDespesaGol
     * @return bool
     */
    public function excluir($idSicasDespesaGol){
        $oSicasDespesaGolBD = new SicasDespesaGolBD();
        if(!$oSicasDespesaGolBD->excluir($idSicasDespesaGol)){
            $this->msg = $oSicasDespesaGolBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * get registro de SicasDespesaGol
     *
     * @access public
     * @param integer $cd_despesa_gol
     * @return SicasDespesaGol
     */
    public function get($cd_despesa_gol){
        $oSicasDespesaGolBD = new SicasDespesaGolBD();
        if($oSicasDespesaGolBD->msg != ''){
            $this->msg = $oSicasDespesaGolBD->msg;
            return false;
        }
        return $oSicasDespesaGolBD->get($cd_despesa_gol);
    }
    
    /**
     * Carregar Colecao de dados de SicasDespesaGol
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @return SicasDespesaGol[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[]){
        $oSicasDespesaGolBD = new SicasDespesaGolBD();
        if($oSicasDespesaGolBD->msg != ''){
            $this->msg = $oSicasDespesaGolBD->msg;
            return false;
        }
        return $oSicasDespesaGolBD->getAll($aFiltro, $aOrdenacao);
    }
    
    /**
     * Consultar registros de SicasDespesaGol
     *
     * @access public
     * @param string $valor
     * @return SicasDespesaGol
     */
    public function consultar($valor){
        $oSicasDespesaGolBD = new SicasDespesaGolBD();
        return $oSicasDespesaGolBD->consultar($valor);
    }
    
    /**
     * Total de registros de SicasDespesaGol
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oSicasDespesaGolBD = new SicasDespesaGolBD();
        return $oSicasDespesaGolBD->totalColecao();
    }
}