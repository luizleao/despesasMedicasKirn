<?php
class ControllerSicasCredenciado extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasCredenciado
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasCredenciado($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasCredenciado($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasCredenciado = new SicasCredenciado($cd_credenciado,$nm_credenciado,$dt_nascimento,$hora_atendimento,$nm_servicos,$profissional_liberal,$endereco,$complemento,$bairro,$cidade,$uf,$cep,$telefone1,$telefone2,$fax1,$ramal1,$tipo,$cd_pis_pasep,$cpf,$cgc,$guia_prev_social,$status);
		$oSicasCredenciadoBD = new SicasCredenciadoBD();
		if(!$oSicasCredenciadoBD->cadastrar($oSicasCredenciado)){
			$this->msg = $oSicasCredenciadoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasCredenciado
	 *
	 * @access public
	 * @param SicasCredenciado $oSicasCredenciado
	 * @return bool
	 */
	public function alterar($oSicasCredenciado = NULL){
		if($oSicasCredenciado == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasCredenciado(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasCredenciado($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = $v;
			// cria objeto para grava-lo no BD
			$oSicasCredenciado = new SicasCredenciado($cd_credenciado,$nm_credenciado,$dt_nascimento,$hora_atendimento,$nm_servicos,$profissional_liberal,$endereco,$complemento,$bairro,$cidade,$uf,$cep,$telefone1,$telefone2,$fax1,$ramal1,$tipo,$cd_pis_pasep,$cpf,$cgc,$guia_prev_social,$status);
			//Util::trace($oSicasCredenciado); exit;
		}		
		$oSicasCredenciadoBD = new SicasCredenciadoBD();
		if(!$oSicasCredenciadoBD->alterar($oSicasCredenciado)){
			$this->msg = $oSicasCredenciadoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasCredenciado
	 *
	 * @access public
	 * @param integer $idSicasCredenciado
	 * @return bool
	 */
	public function excluir($idSicasCredenciado){		
		$oSicasCredenciadoBD = new SicasCredenciadoBD();		
		if(!$oSicasCredenciadoBD->excluir($idSicasCredenciado)){
			$this->msg = $oSicasCredenciadoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasCredenciado
	 *
	 * @access public
	 * @param integer $cd_credenciado
	 * @return SicasCredenciado
	 */
	public function get($cd_credenciado){
		$oSicasCredenciadoBD = new SicasCredenciadoBD();
		if($oSicasCredenciadoBD->msg != ''){
			$this->msg = $oSicasCredenciadoBD->msg;
			return false;
		}
		if(!$obj = $oSicasCredenciadoBD->get($cd_credenciado)){
		    $this->msg = $oSicasCredenciadoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasCredenciado
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasCredenciado[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasCredenciadoBD = new SicasCredenciadoBD();
			$aux = $oSicasCredenciadoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasCredenciadoBD->msg != ''){
				$this->msg = $oSicasCredenciadoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasCredenciado
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasCredenciado[]
	 */
	public function consultar($valor, $aOrdenacao=[]){
		$oSicasCredenciadoBD = new SicasCredenciadoBD();	
		return $oSicasCredenciadoBD->consultar($valor, $aOrdenacao);
	}
	
	/**
	 * Consultar registros de SicasCredenciado ativo com o seu credenciamento
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasCredenciado[]
	 */
	public function consultarCredenciadoAtivo($valor){
	    $oSicasCredenciadoBD = new SicasCredenciadoBD();
	    return $oSicasCredenciadoBD->consultarCredenciadoAtivo($valor, $aOrdenacao);
	}
	
	

	/**
	 * Total de registros de SicasCredenciado
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasCredenciadoBD = new SicasCredenciadoBD();
		return $oSicasCredenciadoBD->totalColecao();
	}

}