<?php
class ControllerSicasAtendimento extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasAtendimento
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasAtendimento($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasAtendimento($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasMedico = new SicasMedico($cd_medico);
		$oSicasPessoa = new SicasPessoa($cd_pessoa);
		$oSicasAtendimento = new SicasAtendimento($cd_atendimento, $oSicasPessoa, $dt_ini_atendimento, $dt_fim_atendimento, $oSicasMedico, $status);
		$oSicasAtendimentoBD = new SicasAtendimentoBD();
		if(!$oSicasAtendimentoBD->cadastrar($oSicasAtendimento)){
			$this->msg = $oSicasAtendimentoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasAtendimento
	 *
	 * @access public
	 * @param SicasAtendimento $oSicasAtendimento
	 * @return bool
	 */
	public function alterar($oSicasAtendimento = NULL){
		if($oSicasAtendimento == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasAtendimento(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasAtendimento($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasMedico = new SicasMedico($cd_medico);
			$oSicasPessoa = new SicasPessoa($cd_pessoa);
			$oSicasAtendimento = new SicasAtendimento($cd_atendimento, $oSicasPessoa, $dt_ini_atendimento, $dt_fim_atendimento, $oSicasMedico, $status);
		}		
		$oSicasAtendimentoBD = new SicasAtendimentoBD();
		if(!$oSicasAtendimentoBD->alterar($oSicasAtendimento)){
			$this->msg = $oSicasAtendimentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasAtendimento
	 *
	 * @access public
	 * @param integer $idSicasAtendimento
	 * @return bool
	 */
	public function excluir($idSicasAtendimento){		
		$oSicasAtendimentoBD = new SicasAtendimentoBD();		
		if(!$oSicasAtendimentoBD->excluir($idSicasAtendimento)){
			$this->msg = $oSicasAtendimentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasAtendimento
	 *
	 * @access public
	 * @param integer $cd_cid
	 * @return SicasAtendimento
	 */
	public function get($cd_cid){
		$oSicasAtendimentoBD = new SicasAtendimentoBD();
		if($oSicasAtendimentoBD->msg != ''){
			$this->msg = $oSicasAtendimentoBD->msg;
			return false;
		}
		if(!$obj = $oSicasAtendimentoBD->get($cd_cid)){
		    $this->msg = $oSicasAtendimentoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasAtendimento
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasAtendimento[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasAtendimentoBD = new SicasAtendimentoBD();
			$aux = $oSicasAtendimentoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasAtendimentoBD->msg != ''){
				$this->msg = $oSicasAtendimentoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasAtendimento
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasAtendimento
	 */
	public function consultar($valor){
		$oSicasAtendimentoBD = new SicasAtendimentoBD();	
		return $oSicasAtendimentoBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasAtendimento
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasAtendimentoBD = new SicasAtendimentoBD();
		return $oSicasAtendimentoBD->totalColecao();
	}
	
	/**
	 * Transação SicasAtendimento
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function transacaoSicasAtendimento($post){
	    $oSicasPessoa = new SicasPessoa($post['oSicasPessoa']['cd_pessoa']);
	    $oSicasMedico = new SicasMedico($post['oSicasMedico']['cd_medico']);

	    $oSicasCredenciado = new SicasCredenciado($post['oSicasEncaminhamento']['oSicasCredenciado']['cd_credenciado']);
	    $oSicasTipoDespesa = new SicasTipoDespesa($post['oSicasEncaminhamento']['oSicasTipoDespesa']['cd_tipo_despesa']);
	    $oSicasTipoAtendimento = new SicasTipoAtendimento($post['oSicasConsultaMedica']['oSicasTipoAtendimento']['cd_tipo_atendimento']);
	    
	    // ======= Cadastrar Atendimento =========
	    $oSicasAtendimento = new SicasAtendimento(NULL,
                                    	          $oSicasPessoa,
                                    	          (new DateTime($post['dt_ini_atendimento']))->format('Y-d-m'),
	                                              (new DateTime($post['dt_fim_atendimento']))->format('Y-d-m'),
                                    	          $oSicasMedico,
                                    	          1);
	    
	    $oSicasAtendimentoBD = new SicasAtendimentoBD();
	    $oConexao = $oSicasAtendimentoBD->oConexao;
	    $oConexao->beginTrans();
	    
	    $cd_atendimento = $oSicasAtendimentoBD->inserir($oSicasAtendimento);
	    //Util::trace("cd_atendimento: ".$cd_atendimento);
	    if(!$cd_atendimento){
	        //Util::trace("Aki01");
	        $this->msg = $oSicasAtendimentoBD->msg;
	        $oConexao->rollBackTrans();
	        return false;
	    }
	    //Util::trace("Aki02");
	    $oSicasAtendimento->cd_atendimento = $cd_atendimento;
	    
	    //Util::trace($oSicasAtendimento);
	    
	    // ========== Cadastrar Consulta =========
	    $oSicasConsultaMedica = new SicasConsultaMedica(NULL,
                                            	        $oSicasAtendimento,
	                                                    (new DateTime())->format('Y-d-m'),
                                            	        $oSicasMedico,
                                            	        '',
                                            	        '',
                                            	        '',
                                            	        '',
                                            	        $oSicasTipoAtendimento,
                                            	        '',
                                            	        '',
                                            	        1);
	    
	    $oSicasConsultaMedicaBD = new SicasConsultaMedicaBD($oConexao);
	    $cd_consulta_medica = $oSicasConsultaMedicaBD->inserir($oSicasConsultaMedica);
	    
	    if(!$cd_consulta_medica){
	        $this->msg = $oSicasConsultaMedicaBD->msg;
	        $oConexao->rollBackTrans();
	        return false;
	    }
	    
	    $oSicasConsultaMedica->cd_consulta_medica = $cd_consulta_medica;
	    
	    //Util::trace($oSicasConsultaMedica);
	    
	    // Cadastrar Consulta medica CID
	    $oSicasConsultaMedicaCidBD = new SicasConsultaMedicaCidBD($oConexao);
	    
	    foreach($post['aSicasCid'] as $sicasCid){
	        $oSicasCid = new SicasCid($sicasCid['cd_cid']);
	        $oSicasConsultaMedicaCid = new SicasConsultaMedicaCid($oSicasCid, $cd_consulta_medica);
	        
	        if(!$oSicasConsultaMedicaCidBD->inserir($oSicasConsultaMedicaCid)){
	            $this->msg = $oSicasConsultaMedicaCidBD->msg;
	            $oConexao->rollBackTrans();
	            return false;
	        }
	        
	        //Util::trace($oSicasConsultaMedicaCid);
	    }
	    
	    // Cadastrar encaminhamento
	    $oControllerSicasEncaminhamento = new ControllerSicasEncaminhamento();
	    
	    $cd_encaminhamento = $oControllerSicasEncaminhamento->gerarCodigoEncaminhamento($post['oSicasPessoa']['cd_pessoa']);
	    $oSicasEncaminhamento = new SicasEncaminhamento($cd_encaminhamento,
	                                                     (new DateTime())->format('Y-d-m'),
                                            	         $oSicasMedico,
                                            	         $oSicasPessoa,
                                            	         $oSicasConsultaMedica,
                                            	         $oSicasCredenciado,
                                            	         $post['oSicasEncaminhamento']['tipo_guia'],
                                            	         'ENABLED',
                                            	         $oSicasTipoDespesa,
	                                                     $post['oSicasEncaminhamento']['observacao']);
	    
	    $oSicasEncaminhamentoBD = new SicasEncaminhamentoBD($oConexao);
	    
	    if(!$oSicasEncaminhamentoBD->inserir($oSicasEncaminhamento)){
	        //print "@@".$cd_encaminhamento;
	        $this->msg = $oSicasEncaminhamentoBD->msg;
	        $oConexao->rollBackTrans();
	        return false;
	    }
	    //Util::trace($oSicasEncaminhamento);
	    
	    // Cadastrar Procedimentos autorizados
	    $oSicasProcedimentoAutorizadoBD = new SicasProcedimentoAutorizadoBD($oConexao);
	    foreach($post['aSicasProcedimentoAutorizado'] as $procedimento){
	        $oSicasProcedimento = new SicasProcedimento($procedimento['cd_procedimento']);
	        $oSicasProcedimentoAutorizado = new SicasProcedimentoAutorizado(NULL,
                                                            	            $oSicasEncaminhamento,
                                                            	            $oSicasProcedimento,
                                                            	            $procedimento['quantidade'],
                                                            	            1);
	        if(!$oSicasProcedimentoAutorizadoBD->inserir($oSicasProcedimentoAutorizado)){
	            $this->msg = $oSicasProcedimentoAutorizadoBD->msg;
	            $oConexao->rollBackTrans();
	            return false;
	        }
	        
	        //Util::trace($oSicasProcedimentoAutorizado);
	    }
	    
	    //$oConexao->rollBackTrans();
	    $oConexao->commitTrans();
	    return $cd_encaminhamento;
	}
}