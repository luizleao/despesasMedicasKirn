<?php
class ControllerSicasDespesa extends Controller{
	
	public $msg;
	
	function __construct(){
		parent::__construct();
    }
    
	/**
	 * Cadastrar SicasDespesa
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function transacaoSicasDespesa($post){
	    $aProcedimento = $post["aProcedimento"];
	    $cd_credenciado = $post["oSicasCredenciado"][0]["cd_credenciado"];
	    //Util::trace($aProcedimento);
	    //Util::trace($post); exit;
		// cria objeto para grava-lo no BD
	    $oSicasDespesaBD = new SicasDespesaBD();
		$oConexao = $oSicasDespesaBD->oConexao;
		$oConexao->beginTrans();
		
		// Cadastrar Fatura
		$oSicasFaturaBD = new SicasFaturaBD($oConexao);
		$oSicasCredenciado = new SicasCredenciado($cd_credenciado);
		
		$oSicasFatura = $oSicasFaturaBD->getByFaturaCredenciado($post["numeroFatura"], $cd_credenciado);
		
		if(!$oSicasFatura){
    		$oSicasFatura = new SicasFatura(NULL, 
                                            $oSicasCredenciado, 
                                            $post["numeroFatura"],
    		                                date('Y-m-d'),
    		                                $post["valorFatura"],
    		                                1,
    		                                $post['mesAnoDescFolha']."-01");
    		
    		
    		$cd_fatura = $oSicasFaturaBD->cadastrar($oSicasFatura);
    		
    		if(!$cd_fatura){
    		    $this->msg = "Falha no cadastro da Fatura: ".$oSicasFaturaBD->msg;
    		    $oConexao->rollBackTrans();
    		    return false;
    		}
    		
    		$oSicasFatura->cd_fatura = $cd_fatura;
		}
		
		// Item Fatura BD
		$oControllerSicasSalario =  new ControllerSicasSalario();
		foreach($aProcedimento as $oProcedimento){
		    $oSicasProcedimentoAutorizado = new SicasProcedimentoAutorizado($oProcedimento['cd_procedimento_autorizado']);
    		
		    $cd_pessoa     = $oProcedimento['oSicasEncaminhamento']['oSicasPessoa']['cd_pessoa'];
		    $cd_categoria  = $oProcedimento['oSicasEncaminhamento']['oSicasPessoa']['oSicasPessoaCategoria']['cd_categoria'];
		    $oSicasSalario = ($cd_categoria == SicasPessoaCategoriaEnum::DEPENDENTE) ? 
		      $oControllerSicasSalario->getAtualByPessoaDependente($cd_pessoa) : 
		    $oControllerSicasSalario->getAtualByPessoaServidor($cd_pessoa);
		    
    		$oSicasDespesa = new SicasDespesa(NULL,
                                    		    $oSicasProcedimentoAutorizado,
                                    		    $oSicasSalario,
    		                                    $oSicasFatura,
                                    		    $oProcedimento['qtd_servico_autorizado'],
                                    		    $oProcedimento['oSicasProcedimento']['num_custo_operacional'],
    		                                    $oProcedimento['oSicasEncaminhamento']['dt_encaminhamento'],
                                    		    date('Y-m-d'),
                                    		    $oProcedimento['percentualDesconto'],
                                    		    1,
    		                                    $post['mesAnoDescFolha']."-01");
    		
    		$cd_despesa = $oSicasDespesaBD->cadastrar($oSicasDespesa);
    		if(!$cd_despesa){
    		    $this->msg = "Falha no cadastro da Despesa: ".$oSicasDespesaBD->msg;
    			$oConexao->rollBackTrans();
    			return false;
    		}
    		
    		$oSicasDespesa->cd_despesa = $cd_despesa;
		}
		
		$oConexao->commitTrans();
		return true;
	}

	/**
	 * Cadastrar SicasDespesa
	 *
	 * @access public
	 * @param $post
	 * @return bool
	 */
	public function cadastrar($post = NULL){
		// recebe dados do formulario
		$post = DadosFormulario::formSicasDespesa($post);
		
		$_SESSION["post"] = $post;
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormSicasDespesa($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oSicasProcedimentoAutorizado = new SicasProcedimentoAutorizado($cd_procedimento_autorizado);
		$oSicasSalario = new SicasSalario($cd_salario);
		$oSicasDespesa = new SicasDespesa($cd_despesa,$oSicasProcedimentoAutorizado,$oSicasSalario,$qtd_servico_realizado,$val_servico_realizado,$dt_atendimento,$dt_cadastro,$desconto_servidor,$status);
		$oSicasDespesaBD = new SicasDespesaBD();
		if(!$oSicasDespesaBD->cadastrar($oSicasDespesa)){
			$this->msg = $oSicasDespesaBD->msg;
			return false;
		}
		unset($_SESSION["post"]);
		return true;
	}

	/**
	 * Alterar dados de SicasDespesa
	 *
	 * @access public
	 * @param SicasDespesa $oSicasDespesa
	 * @return bool
	 */
	public function alterar($oSicasDespesa = NULL){
		if($oSicasDespesa == NULL){
			// recebe dados do formulario
			$post = DadosFormulario::formSicasDespesa(NULL, 2);		
			// valida dados do formulario
			$oValidador = new ValidadorFormulario();
			if(!$oValidador->validaFormSicasDespesa($post,2)){
				$this->msg = $oValidador->msg;
				return false;
			}
			// cria variaveis para validacao com as chaves do array
			foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
			$oSicasProcedimentoAutorizado = new SicasProcedimentoAutorizado($cd_procedimento_autorizado);
			$oSicasSalario = new SicasSalario($cd_salario);
			$oSicasDespesa = new SicasDespesa($cd_despesa,$oSicasProcedimentoAutorizado,$oSicasSalario,$qtd_servico_realizado,$val_servico_realizado,$dt_atendimento,$dt_cadastro,$desconto_servidor,$status);
		}		
		$oSicasDespesaBD = new SicasDespesaBD();
		if(!$oSicasDespesaBD->alterar($oSicasDespesa)){
			$this->msg = $oSicasDespesaBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Excluir SicasDespesa
	 *
	 * @access public
	 * @param integer $idSicasDespesa
	 * @return bool
	 */
	public function excluir($idSicasDespesa){		
		$oSicasDespesaBD = new SicasDespesaBD();		
		if(!$oSicasDespesaBD->excluir($idSicasDespesa)){
			$this->msg = $oSicasDespesaBD->msg;
			return false;	
		}		
		return true;		
	}

	/**
	 * Selecionar registro de SicasDespesa
	 *
	 * @access public
	 * @param integer $cd_despesa
	 * @return SicasDespesa
	 */
	public function get($cd_despesa){
		$oSicasDespesaBD = new SicasDespesaBD();
		if($oSicasDespesaBD->msg != ''){
			$this->msg = $oSicasDespesaBD->msg;
			return false;
		}
		if(!$obj = $oSicasDespesaBD->get($cd_despesa)){
		    $this->msg = $oSicasDespesaBD->msg;
		    return false;
		}
		return $obj;
	}
	

	/**
	 * Carregar Colecao de dados de SicasDespesa
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasDespesa[]
	 */
	public function getAll($aFiltro=[], $aOrdenacao=[], $pagina=NULL){
		try{		
			$oSicasDespesaBD = new SicasDespesaBD();
			$aux = $oSicasDespesaBD->getAll($aFiltro, $aOrdenacao, $this->config['producao']['qtdRegPag'], $pagina);
			
			if($oSicasDespesaBD->msg != ''){
				$this->msg = $oSicasDespesaBD->msg;
				return false;
			}
			return $aux; 
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}

	/**
	 * Consultar registros de SicasDespesa
	 *
	 * @access public
	 * @param string $valor
	 * @return SicasDespesa
	 */
	public function consultar($valor){
		$oSicasDespesaBD = new SicasDespesaBD();	
		return $oSicasDespesaBD->consultar($valor);
	}

	/**
	 * Total de registros de SicasDespesa
	 *
	 * @access public
	 * @return number
	 */
	public function totalColecao(){
		$oSicasDespesaBD = new SicasDespesaBD();
		return $oSicasDespesaBD->totalColecao();
	}

}