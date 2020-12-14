<?php
class ControllerSicasPessoaCategoria extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar SicasPessoaCategoria
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasPessoaCategoria();

        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasPessoaCategoria($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
            // cria objeto para grava-lo no BD
        $oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria, $desc_categoria, $desc_categoria_abrev);
        $oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
        if(!$oSicasPessoaCategoriaBD->inserir($oSicasPessoaCategoria)){
            $this->msg = $oSicasPessoaCategoriaBD->msg;
            return false;
        }

        return true;
    }
    
    /**
     * Alterar dados de SicasPessoaCategoria
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasPessoaCategoria(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasPessoaCategoria($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
        $oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria, $desc_categoria, $desc_categoria_abrev);
        $oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
        if(!$oSicasPessoaCategoriaBD->alterar($oSicasPessoaCategoria)){
            $this->msg = $oSicasPessoaCategoriaBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * Excluir SicasPessoaCategoria
     *
     * @access public
     * @param integer $idSicasPessoaCategoria
     * @return bool
     */
    public function excluir($idSicasPessoaCategoria){
        $oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
        if(!$oSicasPessoaCategoriaBD->excluir($idSicasPessoaCategoria)){
            $this->msg = $oSicasPessoaCategoriaBD->msg;
            return false;
        }
        return true;
    }
    
    /**
     * get registro de SicasPessoaCategoria
     *
     * @access public
     * @param integer $cd_categoria
     * @return SicasPessoaCategoria
     */
    public function get($cd_categoria){
        $oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
        if($oSicasPessoaCategoriaBD->msg != ''){
            $this->msg = $oSicasPessoaCategoriaBD->msg;
            return false;
        }
        return $oSicasPessoaCategoriaBD->get($cd_categoria);
    }
    
    /**
     * Carregar Colecao de dados de SicasPessoaCategoria
     *
     * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
     * @return SicasPessoaCategoria[]
     */
    public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
        try{
            $oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
            $aux = $oSicasPessoaCategoriaBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
            
            if($oSicasPessoaCategoriaBD->msg != ''){
                $this->msg = $oSicasPessoaCategoriaBD->msg;
                return false;
            }
            return $aux;
        } catch(Exception $e){
            $this->msg = $e->getMessage();
            return false;
        }
    }

    /**
     * Consultar registros de SicasPessoaCategoria
     *
     * @access public
     * @param string $valor
     * @return SicasPessoaCategoria
     */
    public function consultar($valor){
        $oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
        return $oSicasPessoaCategoriaBD->consultar($valor);
    }
    
    /**
     * Total de registros de SicasPessoaCategoria
     *
     * @access public
     * @return number
     */
    public function totalColecao(){
        $oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
        return $oSicasPessoaCategoriaBD->totalColecao();
    }
}