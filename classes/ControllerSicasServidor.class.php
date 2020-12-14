<?php
class ControllerSicasServidor extends Controller{
	
	public $msg;
	
	function __construct($rest=false){
	    parent::__construct($rest);
    }
    
	/**
	 * Cadastrar SicasServidor
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasServidor($post);
		//Util::trace($post);exit;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasServidor($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		
		if($this->getByPessoa($cd_pessoa)){
		    $this->msg = 'Servidor já cadastrado';
		    return false;
		}
		
		$oSicasPessoa = new SicasPessoa($cd_pessoa);
		$oRhCargo = new RhCargo($cd_cargo);
		$oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria);
		$oSicasLotacao = new SicasLotacao($cd_lotacao);
		$oSicasServidor = new SicasServidor($cd_servidor,$oSicasPessoa,$cd_matricula,$oSicasLotacao,$status,$serv_efetivo,$oRhCargo,$ramal1,$ramal2,$ramal3,$oSicasPessoaCategoria,$foto,$descricao_perfil,$usuario_proas,$vl_saldo_odonto);
		$oSicasServidorBD = new SicasServidorBD();
		if(!$oSicasServidorBD->cadastrar($oSicasServidor)){
			$this->msg = $oSicasServidorBD->msg;
			return false;
		}

		return true;
	}

	/**
	 * Alterar dados de SicasServidor
	 *
	 * @access public
	 * @param SicasServidor $oSicasServidor
	 * @return bool
	 */
	public function alterar($oSicasServidor=NULL){
		if($oSicasServidor == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasServidor(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasServidor($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasPessoa = new SicasPessoa($cd_pessoa);
			$oSicasLotacao = new SicasLotacao($cd_lotacao);
			$oRhCargo = new RhCargo($cd_cargo);
			$oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria);
			$oSicasServidor = new SicasServidor($cd_servidor, $oSicasPessoa, $cd_matricula, $oSicasLotacao, $status, $serv_efetivo, $oRhCargo, $ramal1, $ramal2, $ramal3, $oSicasPessoaCategoria, $foto, $descricao_perfil, $usuario_proas, $vl_saldo_odonto);
			                                   
		}		
		$oSicasServidorBD = new SicasServidorBD();
		if(!$oSicasServidorBD->alterar($oSicasServidor)){
			$this->msg = $oSicasServidorBD->msg;
			return false;	
		}		
		return true;		
	}
	
	
	
	/**
	 * Alterar dados de SicasServidor e SicasPessoa
	 *
	 * @access public
	 * @return bool
	 */
	public function transacaoAlterar(){
        // recebe dados do formulario
	    $postPessoa   = DadosFormulario::formSicasPessoa(NULL, 2);
        $postServidor = DadosFormulario::formSicasServidor(NULL, 2);
        
        //Util::trace($postPessoa);
        
        // valida dados do formulario
        $oValidador = new ValidadorFormulario();
        
        if(!$oValidador->validaFormSicasPessoa($postPessoa,2)){
            $this->msg = $oValidador->msg;
            return false;
        }
        
        if(!$oValidador->validaFormSicasServidor($postServidor,2)){
            $this->msg = $oValidador->msg;
            return false;
        }

        // cria variaveis para validacao com as chaves do array
        foreach($postPessoa as $i => $v) $$i = utf8_encode($v);
        
        $oSicasEstadoCivil = new SicasEstadoCivil($cd_estado_civil);
        $oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria);
        $oSicasPessoa = new SicasPessoa($cd_pessoa, $nm_pessoa, $email, $dt_nascimento, $genero, $oSicasEstadoCivil, $identidade, $nm_orgao_emissor, $dt_emissao, $cpf, $endereco, $complemento, $bairro, $cidade, $uf, $cep, $telefone, $grupo_sanguineo, $tipo_beneficiario, $status, $foto, $oSicasPessoaCategoria, $uf_identidade, $tipo_identidade, $descricao_perfil);
	        
        $oSicasPessoaBD = new SicasPessoaBD();
        $oConexao = $oSicasPessoaBD->oConexao;
        $oConexao->beginTrans();
        
        $oSicasPessoaBD = new SicasPessoaBD();
        if(!$oSicasPessoaBD->alterar($oSicasPessoa)){
            $this->msg = $oSicasPessoaBD->msg;
            $oConexao->rollBackTrans();
            return false;
        }
        
        // cria variaveis para validacao com as chaves do array
        foreach($postServidor as $i => $v) $$i = utf8_encode($v);
        
        // cria objeto para grava-lo no BD
        $oSicasLotacao         = new SicasLotacao($cd_lotacao);
        $oRhCargo              = new RhCargo($cd_cargo);
        $oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria_servidor);
        $oSicasServidor        = new SicasServidor($cd_servidor, $oSicasPessoa, $cd_matricula, $oSicasLotacao, $status_servidor, $serv_efetivo, $oRhCargo, $ramal1, $ramal2, $ramal3, $oSicasPessoaCategoria, $foto_servidor, $descricao_perfil, $usuario_proas, $vl_saldo_odonto);
        
        $oSicasServidorBD = new SicasServidorBD($oConexao);
	    if(!$oSicasServidorBD->alterar($oSicasServidor)){
	        $this->msg = $oSicasServidorBD->msg;
	        $oConexao->rollBackTrans();
	        return false;
	    }
	    
	    $oConexao->commitTrans();
	    return true;
	}
	
	/**
	 * Excluir SicasServidor
	 *
	 * @access public
	 * @param integer $idSicasServidor
	 * @return bool
	 */
	public function excluir($idSicasServidor){		
		$oSicasServidorBD = new SicasServidorBD();		
		if(!$oSicasServidorBD->excluir($idSicasServidor)){
			$this->msg = $oSicasServidorBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasServidor
	 *
	 * @access public
	 * @param integer $cd_servidor
	 * @return SicasServidor
	 */
	public function get($cd_servidor){
		$oSicasServidorBD = new SicasServidorBD();
		if($oSicasServidorBD->msg != ''){
			$this->msg = $oSicasServidorBD->msg;
			return false;
		}
		if(!$obj = $oSicasServidorBD->get($cd_servidor)){
		    $this->msg = $oSicasServidorBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * get registro de SicasServidor por Email
	 *
	 * @access public
	 * @param string $email
	 * @return SicasServidor
	 */
	public function getByEmail($email){
	    $oSicasServidorBD = new SicasServidorBD();
	    if($oSicasServidorBD->msg != ''){
	        $this->msg = $oSicasServidorBD->msg;
	        return false;
	    }
	    return $oSicasServidorBD->getByEmail($email);
	}
	
	/**
	 * get registro de SicasServidor por Matrícula
	 *
	 * @access public
	 * @param integer $cd_matricula
	 * @return SicasServidor
	 */
	public function getByMatricula($cd_matricula){
	    $oSicasServidorBD = new SicasServidorBD();
	    if($oSicasServidorBD->msg != ''){
	        $this->msg = $oSicasServidorBD->msg;
	        return false;
	    }
	    return $oSicasServidorBD->getByMatricula($cd_matricula);
	}
	
	/**
	 * get registro de SicasServidor por Pessoa
	 *
	 * @access public
	 * @param integer $cd_pessoa
	 * @return SicasServidor
	 */
	public function getByPessoa($cd_pessoa){
	    $oSicasServidorBD = new SicasServidorBD();
	    if($oSicasServidorBD->msg != ''){
	        $this->msg = $oSicasServidorBD->msg;
	        return false;
	    }
	    return $oSicasServidorBD->getByPessoa($cd_pessoa);
	}
	
	/**
	 * get registro de SicasServidor por Dependente
	 *
	 * @access public
	 * @param integer $cd_pessoa
	 * @return SicasServidor
	 */
	public function getByDependente($cd_pessoa){
	    $oSicasServidorBD = new SicasServidorBD();
	    if($oSicasServidorBD->msg != ''){
	        $this->msg = $oSicasServidorBD->msg;
	        return false;
	    }
	    return $oSicasServidorBD->getByDependente($cd_pessoa);
	}
	
	
	/**
	 * Carregar Colecao de dados de SicasServidor
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasServidor[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasServidorBD = new SicasServidorBD();
			$aux = $oSicasServidorBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasServidorBD->msg != ''){
				$this->msg = $oSicasServidorBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasServidor
	 *
	 * @access public
	 * @param string $valor
	 * @param string $servidor_ativo indicativo do servidor ativo
	 * @return SicasServidor
	 */
	public function consultar($valor, $servidor_ativo=NULL){
		$oSicasServidorBD = new SicasServidorBD();	
		return $oSicasServidorBD->consultar($valor, $servidor_ativo);
	}

	/**
	 * Total de registros de SicasServidor
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasServidorBD = new SicasServidorBD();
		return $oSicasServidorBD->totalColecao();
	}
}