<?php
class ControleWS {
	public $msg;
	function __construct(){
		session_start();
	}
	
	// ============ Funcoes de Selecao =================
	/**
	 * get registro de SicasCredenciado
	 *
	 * @access public
	 * @param integer $cd_credenciado
	 * @return SicasCredenciado
	 */
	public function getSicasCredenciado($cd_credenciado){
		$oSicasCredenciadoBD = new SicasCredenciadoBD();
		if($oSicasCredenciadoBD->msg != ''){
			$this->msg = $oSicasCredenciadoBD->msg;
			return false;
		}
		return $oSicasCredenciadoBD->get($cd_credenciado);
	}
	
	/**
	 * get registro de SicasDependente
	 *
	 * @access public
	 * @param integer $cd_dependente        	
	 * @return SicasDependente
	 */
	public function getSicasDependente($cd_dependente){
		$oSicasDependenteBD = new SicasDependenteBD();
		if ($oSicasDependenteBD->msg != ''){
			$this->msg = $oSicasDependenteBD->msg;
			return false;
		}
		return $oSicasDependenteBD->get($cd_dependente );
	}
	
	/**
	 * get registro de SicasEscolaridade
	 *
	 * @access public
	 * @param integer $cd_escolaridade        	
	 * @return SicasEscolaridade
	 */
	public function getSicasEscolaridade($cd_escolaridade){
		$oSicasEscolaridadeBD = new SicasEscolaridadeBD();
		if ($oSicasEscolaridadeBD->msg != ''){
			$this->msg = $oSicasEscolaridadeBD->msg;
			return false;
		}
		return $oSicasEscolaridadeBD->get($cd_escolaridade );
	}
	
	/**
	 * get registro de SicasEspecialidadeMedica
	 *
	 * @access public
	 * @param integer $cd_especialidade_medica
	 * @return SicasEspecialidadeMedica
	 */
	public function getSicasEspecialidadeMedica($cd_especialidade_medica){
		$oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
		if($oSicasEspecialidadeMedicaBD->msg != ''){
			$this->msg = $oSicasEspecialidadeMedicaBD->msg;
			return false;
		}
		return $oSicasEspecialidadeMedicaBD->get($cd_especialidade_medica);
	}
	
	/**
	 * get registro de SicasEspecialidadeMedicaCredenciado
	 *
	 * @access public
	 * @param integer $cd_especialidade_medica_credenciado
	 * @return SicasEspecialidadeMedicaCredenciado
	 */
	public function getSicasEspecialidadeMedicaCredenciado($cd_especialidade_medica_credenciado){
		$oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
		if($oSicasEspecialidadeMedicaCredenciadoBD->msg != ''){
			$this->msg = $oSicasEspecialidadeMedicaCredenciadoBD->msg;
			return false;
		}
		return $oSicasEspecialidadeMedicaCredenciadoBD->get($cd_especialidade_medica_credenciado);
	}
		
	/**
	 * get registro de SicasEstadoCivil
	 *
	 * @access public
	 * @param integer $cd_estado_civil        	
	 * @return SicasEstadoCivil
	 */
	public function getSicasEstadoCivil($cd_estado_civil){
		$oSicasEstadoCivilBD = new SicasEstadoCivilBD();
		if ($oSicasEstadoCivilBD->msg != ''){
			$this->msg = $oSicasEstadoCivilBD->msg;
			return false;
		}
		return $oSicasEstadoCivilBD->get($cd_estado_civil );
	}
	
	/**
	 * get registro de SicasGrauParentesco
	 *
	 * @access public
	 * @param integer $cd_grau_parentesco        	
	 * @return SicasGrauParentesco
	 */
	public function getSicasGrauParentesco($cd_grau_parentesco){
		$oSicasGrauParentescoBD = new SicasGrauParentescoBD();
		if ($oSicasGrauParentescoBD->msg != ''){
			$this->msg = $oSicasGrauParentescoBD->msg;
			return false;
		}
		return $oSicasGrauParentescoBD->get($cd_grau_parentesco );
	}
	
	/**
	 * get registro de SicasLotacao
	 *
	 * @access public
	 * @param integer $cd_lotacao        	
	 * @return SicasLotacao
	 */
	public function getSicasLotacao($cd_lotacao){
		$oSicasLotacaoBD = new SicasLotacaoBD();
		if ($oSicasLotacaoBD->msg != ''){
			$this->msg = $oSicasLotacaoBD->msg;
			return false;
		}
		return $oSicasLotacaoBD->get($cd_lotacao );
	}
	
	/**
	 * get registro de SicasParamFaixaSalarial
	 *
	 * @access public
	 * @param integer $cd_param_faixa_sal        	
	 * @return SicasParamFaixaSalarial
	 */
	public function getSicasParamFaixaSalarial($cd_param_faixa_sal){
		$oSicasParamFaixaSalarialBD = new SicasParamFaixaSalarialBD();
		if ($oSicasParamFaixaSalarialBD->msg != ''){
			$this->msg = $oSicasParamFaixaSalarialBD->msg;
			return false;
		}
		return $oSicasParamFaixaSalarialBD->get($cd_param_faixa_sal );
	}
	
	/**
	 * get registro de SicasPessoa
	 *
	 * @access public
	 * @param integer $cd_pessoa        	
	 * @return SicasPessoa
	 */
	public function getSicasPessoa($cd_pessoa){
		$oSicasPessoaBD = new SicasPessoaBD();
		if ($oSicasPessoaBD->msg != ''){
			$this->msg = $oSicasPessoaBD->msg;
			return false;
		}
		return $oSicasPessoaBD->get($cd_pessoa );
	}
	
	/**
	 * get registro de SicasPessoa por Email
	 *
	 * @access public
	 * @param integer $cd_pessoa        	
	 * @return SicasPessoa
	 */
	public function getSicasPessoaPorEmail($email){
		$oSicasPessoaBD = new SicasPessoaBD();
		if ($oSicasPessoaBD->msg != ''){
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
	public function getSicasPessoaPorNome($nome){
		$oSicasPessoaBD = new SicasPessoaBD();
		if ($oSicasPessoaBD->msg != ''){
			$this->msg = $oSicasPessoaBD->msg;
			return false;
		}
		return $oSicasPessoaBD->getByNome($nome);
	}

	/**
	 * Obter registro de SicasPessoa ativo no PROAS por CPF
	 * Data 25-01-2018
	 * Teste SAMS por Lee Ewerton.
	 *
	 * @access public
	 * @param string $cpf
	 * @return SicasPessoa
	 */
	public function getSicasPessoaAtivoPROASPorCpf($cpf){
		$oSicasPessoaBD = new SicasPessoaBD();
		if ($oSicasPessoaBD->msg != ''){
			$this->msg = $oSicasPessoaBD->msg;
			return false;
		}
		return $oSicasPessoaBD->getSicasPessoaAtivoPROASPorCpf($cpf);
	}

	/**
	 * get registro de SicasServidor por Pessoa
	 *
	 * @access public
	 * @param integer $cd_pessoa        	
	 * @return SicasServidor
	 */
	public function getSicasServidorPessoa($cd_pessoa){
		$oSicasServidorBD = new SicasServidorBD();
		if ($oSicasServidorBD->msg != ''){
			$this->msg = $oSicasServidorBD->msg;
			return false;
		}
		return $oSicasServidorBD->getByPessoa($cd_pessoa);
	}
	
	/**
	 * get registro de SicasPessoaCategoria
	 *
	 * @access public
	 * @param integer $cd_categoria        	
	 * @return SicasPessoaCategoria
	 */
	public function getSicasPessoaCategoria($cd_categoria){
		$oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
		if ($oSicasPessoaCategoriaBD->msg != ''){
			$this->msg = $oSicasPessoaCategoriaBD->msg;
			return false;
		}
		return $oSicasPessoaCategoriaBD->get($cd_categoria );
	}
	
	/**
	 * get registro de SicasSalario
	 *
	 * @access public
	 * @param integer $cd_salario        	
	 * @return SicasSalario
	 */
	public function getSicasSalario($cd_salario){
		$oSicasSalarioBD = new SicasSalarioBD();
		if ($oSicasSalarioBD->msg != ''){
			$this->msg = $oSicasSalarioBD->msg;
			return false;
		}
		return $oSicasSalarioBD->get($cd_salario );
	}
	
	/**
	 * get registro de SicasSalarioMinimo
	 *
	 * @access public
	 * @param integer $cd_salario_minimo        	
	 * @return SicasSalarioMinimo
	 */
	public function getSicasSalarioMinimo($cd_salario_minimo){
		$oSicasSalarioMinimoBD = new SicasSalarioMinimoBD();
		if ($oSicasSalarioMinimoBD->msg != ''){
			$this->msg = $oSicasSalarioMinimoBD->msg;
			return false;
		}
		return $oSicasSalarioMinimoBD->get($cd_salario_minimo );
	}
	
	/**
	 * get registro de SicasServidor
	 *
	 * @access public
	 * @param integer $cd_servidor        	
	 * @return SicasServidor
	 */
	public function getSicasServidor($cd_servidor){
		$oSicasServidorBD = new SicasServidorBD();
		if ($oSicasServidorBD->msg != ''){
			$this->msg = $oSicasServidorBD->msg;
			return false;
		}
		return $oSicasServidorBD->get($cd_servidor);
	}
	
	/**
	 * get registro de RhFeriado
	 *
	 * @access public
	 * @param integer $cd_feriado        	
	 * @return RhFeriado
	 */
	public function getRhFeriado($cd_feriado){
		$oRhFeriadoBD = new RhFeriadoBD();
		if ($oRhFeriadoBD->msg != ''){
			$this->msg = $oRhFeriadoBD->msg;
			return false;
		}
		return $oRhFeriadoBD->get($cd_feriado );
	}
	
	/**
	 * get registro de RhCargo
	 *
	 * @access public
	 * @param integer $cd_cargo        	
	 * @return RhCargo
	 */
	public function getRhCargo($cd_cargo){
		$oRhCargoBD = new RhCargoBD();
		if ($oRhCargoBD->msg != ''){
			$this->msg = $oRhCargoBD->msg;
			return false;
		}
		return $oRhCargoBD->get($cd_cargo );
	}

	/**
	 * get registro de RhCargoComissao
	 *
	 * @access public
	 * @param integer $cd_cargo_comissao        	
	 * @return RhCargoComissao
	 */
	public function getRhCargoComissao($cd_cargo_comissao){
		$oRhCargoComissaoBD = new RhCargoComissaoBD();
		if($oRhCargoComissaoBD->msg != ''){
			$this->msg = $oRhCargoComissaoBD->msg;
			return false;
		}
		return $oRhCargoComissaoBD->get($cd_cargo_comissao);
	}
	
	// ============ Funcoes de Colecao =================
	/**
	 * Carregar Colecao de dados de SicasCredenciado
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasCredenciado[]
	 */
	public function getAllSicasCredenciado($aFiltro=[], $aOrdenacao=[]){
		$oSicasCredenciadoBD = new SicasCredenciadoBD();
		if($oSicasCredenciadoBD->msg != ''){
			$this->msg = $oSicasCredenciadoBD->msg;
			return false;
		}
		return $oSicasCredenciadoBD->getAll($aFiltro, $aOrdenacao);
	}
	
	/**
	 * Carregar Colecao de dados de SicasDependente
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasDependente[]
	 */
	public function getAllSicasDependente($aFiltro=[], $aOrdenacao=[]){
		$oSicasDependenteBD = new SicasDependenteBD();
		if ($oSicasDependenteBD->msg != ''){
			$this->msg = $oSicasDependenteBD->msg;
			return false;
		}
		return $oSicasDependenteBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de SicasEscolaridade
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasEscolaridade[]
	 */
	public function getAllSicasEscolaridade($aFiltro=[], $aOrdenacao=[]){
		$oSicasEscolaridadeBD = new SicasEscolaridadeBD();
		if ($oSicasEscolaridadeBD->msg != ''){
			$this->msg = $oSicasEscolaridadeBD->msg;
			return false;
		}
		return $oSicasEscolaridadeBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de SicasEspecialidadeMedica
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasEspecialidadeMedica[]
	 */
	public function getAllSicasEspecialidadeMedica($aFiltro=[], $aOrdenacao=[]){
		$oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
		if($oSicasEspecialidadeMedicaBD->msg != ''){
			$this->msg = $oSicasEspecialidadeMedicaBD->msg;
			return false;
		}
		return $oSicasEspecialidadeMedicaBD->getAll($aFiltro, $aOrdenacao);
	}
	
	/**
	 * Carregar Colecao de dados de SicasEspecialidadeMedicaCredenciado
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasEspecialidadeMedicaCredenciado[]
	 */
	public function getAllSicasEspecialidadeMedicaCredenciado($aFiltro=[], $aOrdenacao=[]){
		$oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
		if($oSicasEspecialidadeMedicaCredenciadoBD->msg != ''){
			$this->msg = $oSicasEspecialidadeMedicaCredenciadoBD->msg;
			return false;
		}
		return $oSicasEspecialidadeMedicaCredenciadoBD->getAll($aFiltro, $aOrdenacao);
	}
		
	/**
	 * Carregar Colecao de dados de SicasEstadoCivil
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasEstadoCivil[]
	 */
	public function getAllSicasEstadoCivil($aFiltro=[], $aOrdenacao=[]){
		$oSicasEstadoCivilBD = new SicasEstadoCivilBD();
		if ($oSicasEstadoCivilBD->msg != ''){
			$this->msg = $oSicasEstadoCivilBD->msg;
			return false;
		}
		return $oSicasEstadoCivilBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de SicasGrauParentesco
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasGrauParentesco[]
	 */
	public function getAllSicasGrauParentesco($aFiltro=[], $aOrdenacao=[]){
		$oSicasGrauParentescoBD = new SicasGrauParentescoBD();
		if ($oSicasGrauParentescoBD->msg != ''){
			$this->msg = $oSicasGrauParentescoBD->msg;
			return false;
		}
		return $oSicasGrauParentescoBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de SicasLotacao
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasLotacao[]
	 */
	public function getAllSicasLotacao($aFiltro=[], $aOrdenacao=[]){
		$oSicasLotacaoBD = new SicasLotacaoBD();
		if ($oSicasLotacaoBD->msg != ''){
			$this->msg = $oSicasLotacaoBD->msg;
			return false;
		}
		return $oSicasLotacaoBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de SicasParamFaixaSalarial
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasParamFaixaSalarial[]
	 */
	public function getAllSicasParamFaixaSalarial($aFiltro=[], $aOrdenacao=[]){
		$oSicasParamFaixaSalarialBD = new SicasParamFaixaSalarialBD();
		if ($oSicasParamFaixaSalarialBD->msg != ''){
			$this->msg = $oSicasParamFaixaSalarialBD->msg;
			return false;
		}
		return $oSicasParamFaixaSalarialBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de SicasPessoa
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasPessoa[]
	 */
	public function getAllSicasPessoa($aFiltro=[], $aOrdenacao=[]){
		$oSicasPessoaBD = new SicasPessoaBD();
		if ($oSicasPessoaBD->msg != ''){
			$this->msg = $oSicasPessoaBD->msg;
			return false;
		}
		return $oSicasPessoaBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de SicasPessoaCategoria
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasPessoaCategoria[]
	 */
	public function getAllSicasPessoaCategoria($aFiltro=[], $aOrdenacao=[]){
		$oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
		if ($oSicasPessoaCategoriaBD->msg != ''){
			$this->msg = $oSicasPessoaCategoriaBD->msg;
			return false;
		}
		return $oSicasPessoaCategoriaBD->getAll($aFiltro, $aOrdenacao);
	}
	
	/**
	 * Carregar Colecao de dados de SicasSalario
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasSalario[]
	 */
	public function getAllSicasSalario($aFiltro=[], $aOrdenacao=[]){
		$oSicasSalarioBD = new SicasSalarioBD();
		if ($oSicasSalarioBD->msg != ''){
			$this->msg = $oSicasSalarioBD->msg;
			return false;
		}
		return $oSicasSalarioBD->getAll($aFiltro, $aOrdenacao);
	}
	
	/**
	 * Carregar Colecao de dados de SicasSalarioMinimo
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasSalarioMinimo[]
	 */
	public function getAllSicasSalarioMinimo($aFiltro=[], $aOrdenacao=[]){
		$oSicasSalarioMinimoBD = new SicasSalarioMinimoBD();
		if ($oSicasSalarioMinimoBD->msg != ''){
			$this->msg = $oSicasSalarioMinimoBD->msg;
			return false;
		}
		return $oSicasSalarioMinimoBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de SicasServidor
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasServidor[]
	 */
	public function getAllSicasServidor($aFiltro=[], $aOrdenacao=[]){
		$oSicasServidorBD = new SicasServidorBD();
		if ($oSicasServidorBD->msg != ''){
			$this->msg = $oSicasServidorBD->msg;
			return false;
		}
		return $oSicasServidorBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de RhFeriado
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return RhFeriado[]
	 */
	public function getAllRhFeriado($aFiltro=[], $aOrdenacao=[]){
		$oRhFeriadoBD = new RhFeriadoBD();
		if ($oRhFeriadoBD->msg != ''){
			$this->msg = $oRhFeriadoBD->msg;
			return false;
		}
		return $oRhFeriadoBD->getAll($aFiltro, $aOrdenacao );
	}
	
	/**
	 * Carregar Colecao de dados de RhCargo
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return RhCargo[]
	 */
	public function getAllRhCargo($aFiltro=[], $aOrdenacao=[]){
		$oRhCargoBD = new RhCargoBD();
		if ($oRhCargoBD->msg != ''){
			$this->msg = $oRhCargoBD->msg;
			return false;
		}
		return $oRhCargoBD->getAll($aFiltro, $aOrdenacao );
	}

	/**
	 * Carregar Colecao de dados de RhCargoComissao
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return RhCargoComissao[]
	 */
	public function getAllRhCargoComissao($aFiltro=[], $aOrdenacao=[]){
		$oRhCargoComissaoBD = new RhCargoComissaoBD();
		if($oRhCargoComissaoBD->msg != ''){
			$this->msg = $oRhCargoComissaoBD->msg;
			return false;
		}
		return $oRhCargoComissaoBD->getAll($aFiltro, $aOrdenacao);
	}
	
	/**
	 * Consultar registros de SicasEspecialidadeMedica
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasEspecialidadeMedica
	 */
	public function consultarSicasEspecialidadeMedica($valor){
		$oSicasEspecialidadeMedicaBD = new SicasEspecialidadeMedicaBD();
		return $oSicasEspecialidadeMedicaBD->consultar($valor);
	}
	
	/**
	 * Consultar registros de SicasEspecialidadeMedicaCredenciado
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasEspecialidadeMedicaCredenciado
	 */
	public function consultarSicasEspecialidadeMedicaCredenciado($valor){
		$oSicasEspecialidadeMedicaCredenciadoBD = new SicasEspecialidadeMedicaCredenciadoBD();
		return $oSicasEspecialidadeMedicaCredenciadoBD->consultar($valor);
	}
		
	/**
	 * Consultar registros de Cargo
	 *
	 * @access public
	 * @param string $valor        	
	 * @return RhCargo
	 */
	public function consultarRhCargo($valor){
		$oRhCargoBD = new RhCargoBD();
		return $oRhCargoBD->consultar($valor);
	}

		/**
	 * Consultar registros de RhCargoComissao
	 *
	 * @access public
	 * @param string $valor        	
	 * @return RhCargoComissao
	 */
	public function consultarRhCargoComissao($valor){
		$oRhCargoComissaoBD = new RhCargoComissaoBD();
		return $oRhCargoComissaoBD->consultar($valor);
	}
		
	/**
	 * Consultar registros de SicasCredenciado
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasCredenciado
	 */
	public function consultarSicasCredenciado($valor){
		$oSicasCredenciadoBD = new SicasCredenciadoBD();
		return $oSicasCredenciadoBD->consultar($valor);
	}
	
	/**
	 * Consultar registros de Estado Civil
	 *
	 * @access public
	 * @param string $valor        	
	 * @return SicasEstadoCivil
	 */
	public function consultarSicasEstadoCivil($valor){
		$oSicasEstadoCivilBD = new SicasEstadoCivilBD();
		return $oSicasEstadoCivilBD->consultar($valor);
	}
	
	/**
	 * Consultar registros de Lotação
	 *
	 * @access public
	 * @param string $valor        	
	 * @return SicasLotacao
	 */
	public function consultarSicasLotacao($valor){
		$oSicasLotacaoBD = new SicasLotacaoBD();
		return $oSicasLotacaoBD->consultar($valor);
	}
	
	/**
	 * Consultar registros de Categoria de Pessoas
	 *
	 * @access public
	 * @param string $valor        	
	 * @return SicasPessoaCategoria
	 */
	public function consultarSicasPessoaCategoria($valor){
		$oSicasPessoaCategoriaBD = new SicasPessoaCategoriaBD();
		return $oSicasPessoaCategoriaBD->consultar($valor);
	}
	
	/**
	 * Consultar registros de Pessoas
	 *
	 * @access public
	 * @param string $valor        	
	 * @return SicasPessoa
	 */
	public function consultarSicasPessoa($valor){
		$oSicasPessoaBD = new SicasPessoaBD();
		return $oSicasPessoaBD->consultar($valor);
	}
	
	/**
	 * Consultar registros de Servidores
	 *
	 * @access public
	 * @param string $valor        	
	 * @param string $servidor_ativo indicativo do servidor ativo
	 * @return SicasServidor
	 */
	public function consultarSicasServidor($valor, $servidor_ativo=NULL){
		$oSicasServidorBD = new SicasServidorBD();
		
		return $oSicasServidorBD->consultar($valor, $servidor_ativo);
	}
	
	/**
	 * Consultar registros de Servidores para Ramal intranet
	 *
	 * @access public
	 * @param string $valor
	 * @param string $servidor_ativo indicativo do servidor ativo
	 * @return SicasServidor
	 */
	public function consultarSicasServidorRamal($valor){
	    $oSicasServidorBD = new SicasServidorBD();
	    return $oSicasServidorBD->consultarSicasServidorRamal($valor);
	}
	
	// ==================== Cadastrar ===========================
	
	/**
	 * Cadastrar SicasPessoa
	 *
	 * @access public
	 * @return bool
	 */
	public function cadastraSicasPessoa($post){
		// recebe dados do formulario
	    $post = DadosFormulario::formSicasPessoa($post);
		// valida dados do formulario
		//Util::trace($post);
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasPessoa($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = $v;
		// cria objeto para grava-lo no BD
		$oSicasEstadoCivil = new SicasEstadoCivil($cd_estado_civil);
		$oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria);
		$oSicasPessoa = new SicasPessoa($cd_pessoa, $nm_pessoa, $email, $dt_nascimento, $genero, $oSicasEstadoCivil, $identidade, $nm_orgao_emissor, $dt_emissao, $cpf, $endereco, $complemento, $bairro, $cidade, $uf, $cep, $telefone, $grupo_sanguineo, $tipo_beneficiario, $status, $foto, $oSicasPessoaCategoria, $uf_identidade, $tipo_identidade, $descricao_perfil, $usuario_proas);

		$oSicasPessoaBD = new SicasPessoaBD();
		$idPessoa = $oSicasPessoaBD->inserir($oSicasPessoa);
		if(!$idPessoa){
			$this->msg = $oSicasPessoaBD->msg;
			return false;
		}
		return $idPessoa;
	}
	
	
	// ======================= Alterar ====================
	/**
	 * Alterar dados de SicasServidor
	 *
	 * @access public
	 * @return bool
	 */
	public function alterarSicasServidor($oSicasServidor = NULL){
		if($oSicasServidor == NULL){
			// recebe dados do formulario
		    $post = DadosFormulario::formSicasPessoa(NULL, 2);
			
			// print "<pre>"; print_r($post); print "</pre>";
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormularioCadastroSicasServidor($post, 2)){
				$this->msg = $oValidador->msg;
				return $oValidador->msg;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v)
				$$i = $v;
				// cria objeto para grava-lo no BD
			$oSicasPessoa = new SicasPessoa($cd_pessoa);
			$oSicasLotacao = new SicasLotacao($cd_lotacao);
			$oSicasPessoaCategoria = new SicasPessoaCategoria($cd_categoria);
			$oRhCargo = new RhCargo($cd_cargo);
			$oSicasServidor = new SicasServidor($cd_servidor, $oSicasPessoa, $cd_matricula, 
												$oSicasLotacao, $status, $serv_efetivo, 
												$oRhCargo, $ramal1, $ramal2, 
												$ramal3, $oSicasPessoaCategoria, $foto, 
			                                    $descricao_perfil, $usuario_proas, $vl_saldo_odonto);
		}		
		$oSicasServidorBD = new SicasServidorBD();
		if(!$oSicasServidorBD->alterar($oSicasServidor)){
			$this->msg = $oSicasServidorBD->msg;
			return $oSicasServidorBD->msg;
		}
		return true;
	}
	
	/**
	 * Selecionar registro de SicasEncaminhamento por Codigo de Validacao
	 *
	 * @access public
	 * @param integer $cd_validacao
	 * @return SicasEncaminhamento
	 */
	public function getSicasEncaminhamentoByValidacao($cd_validacao){
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
}