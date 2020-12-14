<?php
class ControllerSicasGrauParentesco extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar SicasGrauParentesco
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasGrauParentesco();

        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasGrauParentesco($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasGrauParentesco = new SicasGrauParentesco($cd_grau_parentesco, $desc_grauparentesco, $nm_grau_parentesco, $status);
        $oSicasGrauParentescoBD = new SicasGrauParentescoBD();
        if(!$oSicasGrauParentescoBD->inserir($oSicasGrauParentesco)){
            $this->msg = $oSicasGrauParentescoBD->msg;
            return false;
        }

        return true;
    }
    
    /**
     * Alterar dados de SicasGrauParentesco
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroSicasGrauParentesco(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroSicasGrauParentesco($post, 2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasGrauParentesco = new SicasGrauParentesco($cd_grau_parentesco, $desc_grauparentesco, $nm_grau_parentesco, $status);
        $oSicasGrauParentescoBD = new SicasGrauParentescoBD();
        if(!$oSicasGrauParentescoBD->alterar($oSicasGrauParentesco)){
            $this->msg = $oSicasGrauParentescoBD->msg;
            return false;
        }
        return true;
    }

	/**
	 * Excluir SicasGrauParentesco
	 *
	 * @access public
	 * @param integer $idSicasGrauParentesco
	 * @return bool
	 */
	public function excluir($idSicasGrauParentesco){		
		$oSicasGrauParentescoBD = new SicasGrauParentescoBD();		
		if(!$oSicasGrauParentescoBD->excluir($idSicasGrauParentesco)){
			$this->msg = $oSicasGrauParentescoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasGrauParentesco
	 *
	 * @access public
	 * @param integer $cd_cid
	 * @return SicasGrauParentesco
	 */
	public function get($cd_cid){
		$oSicasGrauParentescoBD = new SicasGrauParentescoBD();
		if($oSicasGrauParentescoBD->msg != ''){
			$this->msg = $oSicasGrauParentescoBD->msg;
			return false;
		}
		if(!$obj = $oSicasGrauParentescoBD->get($cd_cid)){
		    $this->msg = $oSicasGrauParentescoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasGrauParentesco
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasGrauParentesco[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasGrauParentescoBD = new SicasGrauParentescoBD();
			$aux = $oSicasGrauParentescoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasGrauParentescoBD->msg != ''){
				$this->msg = $oSicasGrauParentescoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasGrauParentesco
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasGrauParentesco
	 */
	public function consultar($valor){
		$oSicasGrauParentescoBD = new SicasGrauParentescoBD();	
		return $oSicasGrauParentescoBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasGrauParentesco
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasGrauParentescoBD = new SicasGrauParentescoBD();
		return $oSicasGrauParentescoBD->totalColecao();
	}

}