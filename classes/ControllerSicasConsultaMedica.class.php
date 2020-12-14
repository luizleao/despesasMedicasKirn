<?php
class ControllerSicasConsultaMedica extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasConsultaMedica
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasConsultaMedica($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasConsultaMedica($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasAtendimento = new SicasAtendimento($cd_atendimento);
		$oSicasMedico = new SicasMedico($cd_medico);
		$oSicasTipoAtendimento = new SicasTipoAtendimento($cd_tipo_atendimento);
		$oSicasConsultaMedica = new SicasConsultaMedica($cd_consulta_medica,$oSicasAtendimento,$dt_consulta,$oSicasMedico,$qp_paciente,$exame_fisico,$exame_solicitado,$diag_paciente,$oSicasTipoAtendimento,$resultado,$tratamento,$status);
		$oSicasConsultaMedicaBD = new SicasConsultaMedicaBD();
		if(!$oSicasConsultaMedicaBD->cadastrar($oSicasConsultaMedica)){
			$this->msg = $oSicasConsultaMedicaBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasConsultaMedica
	 *
	 * @access public
	 * @param SicasConsultaMedica $oSicasConsultaMedica
	 * @return bool
	 */
	public function alterar($oSicasConsultaMedica = NULL){
		if($oSicasConsultaMedica == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasConsultaMedica(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasConsultaMedica($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasAtendimento = new SicasAtendimento($cd_atendimento);
			$oSicasMedico = new SicasMedico($cd_medico);
			$oSicasTipoAtendimento = new SicasTipoAtendimento($cd_tipo_atendimento);
			$oSicasConsultaMedica = new SicasConsultaMedica($cd_consulta_medica,$oSicasAtendimento,$dt_consulta,$oSicasMedico,$qp_paciente,$exame_fisico,$exame_solicitado,$diag_paciente,$oSicasTipoAtendimento,$resultado,$tratamento,$status);
		}		
		$oSicasConsultaMedicaBD = new SicasConsultaMedicaBD();
		if(!$oSicasConsultaMedicaBD->alterar($oSicasConsultaMedica)){
			$this->msg = $oSicasConsultaMedicaBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasConsultaMedica
	 *
	 * @access public
	 * @param integer $idSicasConsultaMedica
	 * @return bool
	 */
	public function excluir($idSicasConsultaMedica){		
		$oSicasConsultaMedicaBD = new SicasConsultaMedicaBD();		
		if(!$oSicasConsultaMedicaBD->excluir($idSicasConsultaMedica)){
			$this->msg = $oSicasConsultaMedicaBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasConsultaMedica
	 *
	 * @access public
	 * @param integer $cd_consulta_medica
	 * @return SicasConsultaMedica
	 */
	public function get($cd_consulta_medica){
		$oSicasConsultaMedicaBD = new SicasConsultaMedicaBD();
		if($oSicasConsultaMedicaBD->msg != ''){
			$this->msg = $oSicasConsultaMedicaBD->msg;
			return false;
		}
		if(!$obj = $oSicasConsultaMedicaBD->get($cd_consulta_medica)){
		    $this->msg = $oSicasConsultaMedicaBD->msg;
		    return false;
		}
		return $obj;
	}

	/**
	 * Carregar Colecao de dados de SicasConsultaMedica
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasConsultaMedica[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasConsultaMedicaBD = new SicasConsultaMedicaBD();
			$aux = $oSicasConsultaMedicaBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasConsultaMedicaBD->msg != ''){
				$this->msg = $oSicasConsultaMedicaBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasConsultaMedica
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasConsultaMedica
	 */
	public function consultar($valor){
		$oSicasConsultaMedicaBD = new SicasConsultaMedicaBD();	
		return $oSicasConsultaMedicaBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasConsultaMedica
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasConsultaMedicaBD = new SicasConsultaMedicaBD();
		return $oSicasConsultaMedicaBD->totalColecao();
	}

}