<?php
class ControllerSicasPessoa extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
    /**
     * Cadastrar SicasPessoa
     *
     * @access public
     * @return bool
     */
    public function cadastrar(){
    	// recebe dados do formulario
    	$post = DadosFormulario::formSicasPessoa();
    	
    	// valida dados do formulario
    	$oValidador = new ValidadorFormulario();
    	if(!$oValidador->validaFormSicasPessoa($post)){
    		$this->msg = $oValidador->msg;
    		return false;
    	}
    	
    	// cria variaveis para validacao com as chaves do array
    	foreach($post as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
    	$oSicasEstadoCivil = new SicasEstadoCivil($cd_estado_civil);
    	$oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria);
    	$oSicasPessoa = new SicasPessoa($cd_pessoa, $nm_pessoa, $email, $dt_nascimento, $genero, $oSicasEstadoCivil, $identidade, $nm_orgao_emissor, $dt_emissao, $cpf, $endereco, $complemento, $bairro, $cidade, $uf, $cep, $telefone, $grupo_sanguineo, $tipo_beneficiario, $status, $foto, $oSicasPessoaCategoria, $uf_identidade, $tipo_identidade, $descricao_perfil);
    	$oSicasPessoaBD = new SicasPessoaBD();
    	if(!$oSicasPessoaBD->inserir($oSicasPessoa)){
    		$this->msg = $oSicasPessoaBD->msg;
    		return false;
    	}
    
    	return true;
    }

	/**
	 * Alterar dados de SicasPessoa
	 *
	 * @access public
	 * @return bool
	 */
	public function alterar(){
	    // recebe dados do formulario
	    $post = DadosFormulario::formSicasPessoa($_REQUEST, 2);
	    //Util::trace($post);
	    // valida dados do formulario
	    $oValidador = new ValidadorFormulario();
	    if(!$oValidador->validaFormSicasPessoa($post, 2)){
	        $this->msg = $oValidador->msg;
	        return false;
	    }
	    // cria variaveis para validacao com as chaves do array
	    foreach($post as $i => $v) $$i = utf8_encode($v);

        // cria objeto para grava-lo no BD
        $oSicasEstadoCivil = new SicasEstadoCivil($cd_estado_civil);
        $oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria);
        $oSicasPessoa = new SicasPessoa($cd_pessoa, $nm_pessoa, $email, $dt_nascimento, $genero, $oSicasEstadoCivil, $identidade, $nm_orgao_emissor, $dt_emissao, $cpf, $endereco, $complemento, $bairro, $cidade, $uf, $cep, $telefone, $grupo_sanguineo, $tipo_beneficiario, $status, $foto, $oSicasPessoaCategoria, $uf_identidade, $tipo_identidade, $descricao_perfil);
        $oSicasPessoaBD = new SicasPessoaBD();
        if(!$oSicasPessoaBD->alterar($oSicasPessoa)){
            $this->msg = $oSicasPessoaBD->msg;
            return false;
        }
        return true;
	}

	/**
	 * Excluir SicasPessoa
	 *
	 * @access public
	 * @param integer $idSicasPessoa
	 * @return bool
	 */
	public function excluir($idSicasPessoa){
	    $oSicasPessoaBD = new SicasPessoaBD();
	    if(!$oSicasPessoaBD->excluir($idSicasPessoa)){
	        $this->msg = $oSicasPessoaBD->msg;
	        return false;
	    }
	    return true;
	}

	/**
	 * get registro de SicasPessoa
	 *
	 * @access public
	 * @param integer $cd_pessoa
	 * @return SicasPessoa
	 */
	public function get($cd_pessoa){
	    $oSicasPessoaBD = new SicasPessoaBD();
	    if($oSicasPessoaBD->msg != ''){
	        $this->msg = $oSicasPessoaBD->msg;
	        return false;
	    }
	    return $oSicasPessoaBD->get($cd_pessoa);
	}

	/**
	 * Carregar Colecao de dados de SicasPessoa
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasParamFaixaSalarial[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){	    
		try{		
		    $oSicasPessoaBD = new SicasPessoaBD();
		    $aux = $oSicasPessoaBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
		    if($oSicasPessoaBD->msg != ''){
		        $this->msg = $oSicasPessoaBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	/**
	 * Carrega a lista das pessoas que não são servidoras
	 *
	 * @access public
	 * @return SicasPessoa[]
	 */
	public function getAllNotServidor() {
	    $oSicasPessoaBD = new SicasPessoaBD ();
	    if ($oSicasPessoaBD->msg != '') {
	        $this->msg = $oSicasPessoaBD->msg;
	        return false;
	    }
	    return $oSicasPessoaBD->getAllNotServidor();
	}
	
	/**
	 * Carrega a lista das pessoas habilitadas para serem dependentes
	 *
	 * @access public
	 * @return SicasPessoa[]
	 */
	public function getAllDependenteEnabled() {
	    $oSicasPessoaBD = new SicasPessoaBD ();
	    if ($oSicasPessoaBD->msg != '') {
	        $this->msg = $oSicasPessoaBD->msg;
	        return false;
	    }
	    return $oSicasPessoaBD->getAllDependenteEnabled();
	}
	
	/**
	 * get registro de SicasPessoa por Email
	 *
	 * @access public
	 * @param string $email
	 * @return SicasPessoa
	 */
	public function getByEmail($email) {
	    $oSicasPessoaBD = new SicasPessoaBD();
	    if ($oSicasPessoaBD->msg != '') {
	        $this->msg = $oSicasPessoaBD->msg;
	        return false;
	    }
	    return $oSicasPessoaBD->getByEmail($email);
	}
	
	/**
	 * get registro de SicasPessoa por Nome
	 *
	 * @access public
	 * @param string $nome
	 * @return SicasPessoa
	 */
	public function getByNome($nome) {
	    $oSicasPessoaBD = new SicasPessoaBD();
	    if ($oSicasPessoaBD->msg != '') {
	        $this->msg = $oSicasPessoaBD->msg;
	        return false;
	    }
	    return $oSicasPessoaBD->getByNome($nome);
	}
	
	/**
	 * Consultar registros de SicasPessoa
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasPessoa
	 */
	public function consultar($valor){
	    $oSicasPessoaBD = new SicasPessoaBD();
	    return $oSicasPessoaBD->consultar($valor);
	}
	
	/**
	 * Consultar registros de SicasPessoa de beneficiarios
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasPessoa
	 */
	public function consultarBeneficiario($valor){
	    $oSicasPessoaBD = new SicasPessoaBD();
	    return $oSicasPessoaBD->consultarBeneficiario($valor);
	}

	/**
	 * Total de registros de SicasPesso
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
	    $oSicasPessoaBD = new SicasPesso();
	    return $oSicasPessoaBD->totalColecao();
	}

}