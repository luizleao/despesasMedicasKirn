<?php
class ControllerRhRamal extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar RhRamal
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhRamal();
        //Util::trace($post);exit;
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhRamal($post)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasLotacao = new SicasLotacao($cd_lotacao);
        $oRhRamal = new RhRamal($cd_ramal,$oSicasLotacao,$ramal,$descricao);
        $oRhRamalBD = new RhRamalBD();
        
        if(!$oRhRamalBD->inserir($oRhRamal)){
            //echo $oRhRamalBD->msg;
            $this->msg = $oRhRamalBD->msg;
            return false;
        }
        
        //Util::trace($oRhServidorRamalBD); exit;
        return true;
    }
    
    /**
     * Alterar dados de RhRamal
     *
     * @access public
     * @return bool
     */
    public function alterar(){
        // recebe dados do formulario
        $post = DadosFormulario::formularioCadastroRhRamal(2);
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        if(!$oValidador->validaFormularioCadastroRhRamal($post,2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        // cria variaveis para validacao com as chaves do array
        foreach($post as $i => $v) $$i = utf8_encode($v);
        // cria objeto para grava-lo no BD
        $oSicasLotacao = new SicasLotacao($cd_lotacao);
        $oRhRamal = new RhRamal($cd_ramal,$oSicasLotacao,$ramal,$descricao);
        $oRhRamalBD = new RhRamalBD();
        if(!$oRhRamalBD->alterar($oRhRamal)){
            $this->msg = $oRhRamalBD->msg;
            return false;
        }
        return true;
    }	

	/**
	 * Excluir RhRamal
	 *
	 * @access public
	 * @param integer $idRhRamal
	 * @return bool
	 */
	public function excluir($idRhRamal){		
		$oRhRamalBD = new RhRamalBD();		
		if(!$oRhRamalBD->excluir($idRhRamal)){
			$this->msg = $oRhRamalBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de RhRamal
	 *
	 * @access public
	 * @param integer $cd_cid
	 * @return RhRamal
	 */
	public function get($cd_cid){
		$oRhRamalBD = new RhRamalBD();
		if($oRhRamalBD->msg != ''){
			$this->msg = $oRhRamalBD->msg;
			return false;
		}
		if(!$obj = $oRhRamalBD->get($cd_cid)){
		    $this->msg = $oRhRamalBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de RhRamal
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return RhRamal[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oRhRamalBD = new RhRamalBD();
			$aux = $oRhRamalBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oRhRamalBD->msg != ''){
				$this->msg = $oRhRamalBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de RhRamal
	 *
	 * @access public
	 * @param string $valor
	 * @return RhRamal
	 */
	public function consultar($valor){
		$oRhRamalBD = new RhRamalBD();	
		return $oRhRamalBD->consultar($valor);
	}

	/**
	 * Total de registros de RhRamal
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oRhRamalBD = new RhRamalBD();
		return $oRhRamalBD->totalColecao();
	}

}