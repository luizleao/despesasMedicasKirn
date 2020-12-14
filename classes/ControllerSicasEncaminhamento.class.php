<?php
class ControllerSicasEncaminhamento extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
   
    public function gerarCodigoEncaminhamento($cd_pessoa){
        //0002173169-000/052019.002
        $codigoEncaminhamento = '';
        $oControllerServidor = new ControllerSicasServidor();
        $oSicasServidor = $oControllerServidor->getByPessoa($cd_pessoa); 
        $oControllerDependente = new ControllerSicasDependente();
        
        if($oSicasServidor){
            $codigoEncaminhamento .= str_pad($oSicasServidor->cd_matricula, 10, "0", STR_PAD_LEFT).'000';
        } else {
            $oSicasDependente = $oControllerDependente->getByPessoa($cd_pessoa);
            
            $codigoEncaminhamento .= str_pad($oSicasDependente->oSicasServidor->cd_matricula, 10, "0", STR_PAD_LEFT).str_pad($oSicasDependente->cd_seq_dependente, 3, "0", STR_PAD_LEFT);
        }
        // Recuperar a quantidade de encaminhamentos do paciente no mes/ano
        $aSicasEncaminhamento = $this->getAll(["sicas_encaminhamento.cd_pessoa=$cd_pessoa", 
                                               "YEAR(dt_encaminhamento) = '".date('Y')."'",  
                                               "MONTH(dt_encaminhamento) = '".date('m')."'"]);
        
        
        //util::trace($aSicasEncaminhamento);
        $seq = (is_array($aSicasEncaminhamento)) ? count($aSicasEncaminhamento) : 0;
        //print "--".$seq;
        
        $codigoEncaminhamento .= date('mY');
        $codigoEncaminhamento .= ($seq > 0) ? str_pad($seq+1, 3, "0", STR_PAD_LEFT) : '001';
        
        return $codigoEncaminhamento;
    }
    
	/**
	 * Cadastrar SicasEncaminhamento
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasEncaminhamento($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasEncaminhamento($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasMedico = new SicasMedico($cd_medico);
		$oSicasPessoa = new SicasPessoa($cd_pessoa);
		$oSicasConsultaMedica = new SicasConsultaMedica($cd_consulta_medica);
		$oSicasCredenciado = new SicasCredenciado($cd_credenciado);
		$oSicasTipoDespesa = new SicasTipoDespesa($cd_tipo_despesa);
		$oSicasEncaminhamento = new SicasEncaminhamento($cd_encaminhamento,$dt_encaminhamento,$oSicasMedico,$oSicasPessoa,$oSicasConsultaMedica,$oSicasCredenciado,$tipo_guia,$status,$oSicasTipoDespesa,$observacao);
		$oSicasEncaminhamentoBD = new SicasEncaminhamentoBD();
		if(!$oSicasEncaminhamentoBD->cadastrar($oSicasEncaminhamento)){
			$this->msg = $oSicasEncaminhamentoBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasEncaminhamento
	 *
	 * @access public
	 * @param SicasEncaminhamento $oSicasEncaminhamento
	 * @return bool
	 */
	public function alterar($oSicasEncaminhamento = NULL){
		if($oSicasEncaminhamento == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasEncaminhamento(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasEncaminhamento($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasMedico = new SicasMedico($cd_medico);
			$oSicasPessoa = new SicasPessoa($cd_pessoa);
			$oSicasConsultaMedica = new SicasConsultaMedica($cd_consulta_medica);
			$oSicasCredenciado = new SicasCredenciado($cd_credenciado);
			$oSicasTipoDespesa = new SicasTipoDespesa($cd_tipo_despesa);
			$oSicasEncaminhamento = new SicasEncaminhamento($cd_encaminhamento,$dt_encaminhamento,$oSicasMedico,$oSicasPessoa,$oSicasConsultaMedica,$oSicasCredenciado,$tipo_guia,$status,$oSicasTipoDespesa);
		}		
		$oSicasEncaminhamentoBD = new SicasEncaminhamentoBD();
		if(!$oSicasEncaminhamentoBD->alterar($oSicasEncaminhamento)){
			$this->msg = $oSicasEncaminhamentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasEncaminhamento
	 *
	 * @access public
	 * @param integer $idSicasEncaminhamento
	 * @return bool
	 */
	public function excluir($idSicasEncaminhamento){		
		$oSicasEncaminhamentoBD = new SicasEncaminhamentoBD();		
		if(!$oSicasEncaminhamentoBD->excluir($idSicasEncaminhamento)){
			$this->msg = $oSicasEncaminhamentoBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasEncaminhamento
	 *
	 * @access public
	 * @param integer $cd_encaminhamento
	 * @return SicasEncaminhamento
	 */
	public function get($cd_encaminhamento){
		$oSicasEncaminhamentoBD = new SicasEncaminhamentoBD();
		if($oSicasEncaminhamentoBD->msg != ''){
			$this->msg = $oSicasEncaminhamentoBD->msg;
			return false;
		}
		if(!$obj = $oSicasEncaminhamentoBD->get($cd_encaminhamento)){
		    $this->msg = $oSicasEncaminhamentoBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasEncaminhamento
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasEncaminhamento[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasEncaminhamentoBD = new SicasEncaminhamentoBD();
			$aux = $oSicasEncaminhamentoBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasEncaminhamentoBD->msg != ''){
				$this->msg = $oSicasEncaminhamentoBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasEncaminhamento
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasEncaminhamento
	 */
	public function consultar($valor){
		$oSicasEncaminhamentoBD = new SicasEncaminhamentoBD();	
		return $oSicasEncaminhamentoBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasEncaminhamento
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasEncaminhamentoBD = new SicasEncaminhamentoBD();
		return $oSicasEncaminhamentoBD->totalColecao();
	}

	/**
	 * Selecionar registro de SicasEncaminhamento por Codigo de Validacao
	 *
	 * @access public
	 * @param integer $cd_validacao
	 * @return SicasEncaminhamento
	 */
	public function getByValidacao($cd_validacao){
	    $oSicasEncaminhamentoBD = new SicasEncaminhamentoBD();
	    if($oSicasEncaminhamentoBD->msg != ''){
	        $this->msg = $oSicasEncaminhamentoBD->msg;
	        return false;
	    }
	    if(!$obj = $oSicasEncaminhamentoBD->getByValidacao($cd_validacao)){
	        $this->msg = $oSicasEncaminhamentoBD->msg;
	        return false;
	    }
	    return $obj;
	}
	
	public function getProxy(){
	    return new SicasEncaminhamentoProxy();
	}
}