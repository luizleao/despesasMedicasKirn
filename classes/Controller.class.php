<?php
class Controller{
	public $msg;
	public $config;
	
	function __construct($rest=false){
		session_start();
		$this->config = parse_ini_file("core/config.ini", true);
		
		if(!$rest){
    		if(!preg_match("#index#is", $_SERVER['REQUEST_URI'])){
    			if(!isset($_SESSION['usuarioAtual'])){
    				echo "
                        <script>
                            alert('Sessão expirou');
                            window.location='index.php';
                        </script>";
    				exit();
    			}
    		}
		}
	}
	
	/**
	 * Retorna o numero total de páginas de uma consulta
	 *
	 * @param number $total
	 * @return integer
	 */
	public function numeroPaginasConsulta($total){
	    return ($total % $this->config['producao']['qtdRegPag'] == 0) ? $total/$this->config['producao']['qtdRegPag'] : ceil($total/$this->config['producao']['qtdRegPag']);
	}
	
	function fecharConexao(){
		$conexao = new Conexao();
		return $conexao->close();
	}
	
	/**
	 * Recupera as configurações de produção
	 *
	 * @return string[]
	 */
	function getConfigProducao(){
		$aConfig = parse_ini_file(dirname(__FILE__). "/core/config.ini", true);
		return $aConfig['producao'];
	}
	
	/**
	 * Recupera as configurações de conexão LDAP
	 *
	 * @return string[]
	 */
	function getConfigLDAP(){
		$aConfig = parse_ini_file(dirname(__FILE__). "/core/config.ini", true);
		return $aConfig['LDAP'];
	}
	
	/**
	 * Autentica o Usuario
	 * 
	 * @param string $login        	
	 * @param string $senha        	
	 * @return string[]
	 */
	function autenticaUsuario($login, $senha){
		if($login == ''){
			$this->msg = "Digite um login válido";
			return false;
		}
		
		if($senha == ''){
			$this->msg = "Digite uma senha válida";
			return false;
		}
		
		$aConfig = $this->getConfigLDAP();
		
		try{
			// Conexão com servidor AD.
			$ad = ldap_connect($aConfig['servidor']);
			
			// Versao do protocolo
			ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
			
			// Usara as referencias do servidor AD, neste caso nao
			ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
			
			// Bind to the directory server.
			$bd = @ldap_bind($ad, $aConfig['dominio']."\\".$login, $senha) or die("Não foi possível pesquisar no AD.");
			if($bd){
				/* DEFINE O DN DO SERVIDOR LDAP */
				$dn 	= "ou={$aConfig['dominio']}, dc={$aConfig['dominio']}, dc={$aConfig['dc']}";
				$filter = "(|(member=$login)(sAMAccountName=$login))";

				// $filter = "(|(sn=$usuario*)(givenname=$usuario*)(uid=$usuario))";
				/* EXECUTA O FILTRO NO SERVIDOR LDAP */
				$sr = ldap_search($ad, $dn, $filter);
				/* PEGA AS INFORMAÇÕES QUE O FILTRO RETORNOU */
				$info = ldap_get_entries($ad, $sr);
				
				$_SESSION['usuarioAtual']['login'] 	 	= $info[0]['samaccountname'][0];
				$_SESSION['usuarioAtual']['email'] 	 	= $info[0]['mail'][0];
				$_SESSION['usuarioAtual']['nome'] 		= $info[0]['displayname'][0];
				$_SESSION['usuarioAtual']['permissoes'] = $info[0]['memberof'];
				
				// ======== Formatando data vinda via LDAP ===========
				$fileTime 	   = $info[0]['lastlogon'][0];
				$winSecs	   = (int)($fileTime / 10000000); // divide by 10 000 000 to get seconds
				$unixTimestamp = ($winSecs - 11644473600); // 1.1.1600 -> 1.1.1970 difference in seconds
				
				$_SESSION['usuarioAtual']['ultimoLogon'] = date("d/m/Y h:i:s", (int)$unixTimestamp);
			} else{
				$this->msg = "Nao Conectado no servidor";
				return false;
			}
			
			// Carregar dados do servidor
			$oControllerServidor = new ControllerSicasServidor();
			$oSicasServidor = $oControllerServidor->getByEmail($_SESSION['usuarioAtual']['email']);
			
			if($oSicasServidor){
			    $_SESSION['usuarioAtual']['oSicasServidor'] = $oSicasServidor;
			}
			
			// ===== Verificar se faz parte do grupo CGP
			//Util::trace($info[0]['memberof']);
			
			foreach($info[0]['memberof'] as $perfil){
				if(preg_match("#(?:CGP_GRP|RH_SERVIDOR_GRP)#is", $perfil)){
					$_SESSION['usuarioAtual']['perfil'][] = "CGP";
					break;
				}
				elseif(preg_match("#RH_ADMIN_GRP#is", $perfil)){
					$_SESSION['usuarioAtual']['perfil'][] = "ADMIN";
					break;
				}
				elseif(preg_match("#RH_ENCAMINHAMENTO_GRP#is", $perfil)){
				    $_SESSION['usuarioAtual']['perfil'][] = "SAMS";
				    break;
				}
			}
			
			if($_SESSION['usuarioAtual']['perfil'] == "") {
				$this->msg = "Você não tem permissão de acesso";
				return false;
			}
			
			return true;
		} catch(Exception $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	// ============ Funcoes de Cadastro ==================
	/**
	 * Cadastrar RhServidorRamal
	 *
	 * @access public
	 * @return bool
	 */
	public function cadastraRhServidorRamal(){
		// recebe dados do formulario
		$post = DadosFormulario::formularioCadastroRhServidorRamal();

		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormularioCadastroRhServidorRamal($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oRhServidorRamal = new RhServidorRamal($cd_servidor);
		$oRhRamal = new RhRamal($cd_ramal);
		$oRhServidorRamal = new RhServidorRamal($oRhServidorRamal,$oRhRamal);
		$oRhServidorRamalBD = new RhServidorRamalBD();
		if(!$oRhServidorRamalBD->inserir($oRhServidorRamal)){
			$this->msg = $oRhServidorRamalBD->msg;
			return false;
		}
		return true;
	}
	
	
	/**
	 * Cadastrar SicasHistoricoImpressao
	 *
	 * @access public
	 * @return bool
	 */
	public function cadastraSicasHistoricoImpressao(){
		// recebe dados do formulario
		$post = DadosFormulario::formularioCadastroSicasHistoricoImpressao();

		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormularioCadastroSicasHistoricoImpressao($post)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v)
			$$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
		$oSicasPessoa = new SicasPessoa($cd_pessoa);
		$oSicasHistoricoImpressao = new SicasHistoricoImpressao($cd_carteira, $oSicasPessoa, $dt_impressao);
		$oSicasHistoricoImpressaoBD = new SicasHistoricoImpressaoBD();
		if(!$oSicasHistoricoImpressaoBD->inserir($oSicasHistoricoImpressao)){
			$this->msg = $oSicasHistoricoImpressaoBD->msg;
			return false;
		}

		return true;
	}

	// ============ Funcoes de Alteracao =================	
	/**
	 * Alterar dados de SicasHistoricoImpressao
	 *
	 * @access public
	 * @return bool
	 */
	public function alteraSicasHistoricoImpressao(){
		// recebe dados do formulario
		$post = DadosFormulario::formularioCadastroSicasHistoricoImpressao(2);
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormularioCadastroSicasHistoricoImpressao($post, 2)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
			// cria objeto para grava-lo no BD
		$oSicasPessoa = new SicasPessoa($cd_pessoa);
		$oSicasHistoricoImpressao = new SicasHistoricoImpressao($cd_carteira, $oSicasPessoa, $dt_impressao);
		$oSicasHistoricoImpressaoBD = new SicasHistoricoImpressaoBD();
		if(!$oSicasHistoricoImpressaoBD->alterar($oSicasHistoricoImpressao)){
			$this->msg = $oSicasHistoricoImpressaoBD->msg;
			return false;
		}
		return true;
	}
	
	/**
	 * Alterar dados de RhServidorRamal
	 *
	 * @access public
	 * @return bool
	 */
	public function alteraRhServidorRamal(){
		// recebe dados do formulario
		$post = DadosFormulario::formularioCadastroRhServidorRamal(2);
		// valida dados do formulario
		$oValidador = new ValidadorFormulario();
		if(!$oValidador->validaFormularioCadastroRhServidorRamal($post,2)){
			$this->msg = $oValidador->msg;
			return false;
		}
		// cria variaveis para validacao com as chaves do array
		foreach($post as $i => $v) $$i = utf8_encode($v);
		// cria objeto para grava-lo no BD
		$oRhServidorRamal = new RhServidorRamal($cd_servidor);
		$oRhRamal = new RhRamal($cd_ramal);
		$oRhServidorRamal = new RhServidorRamal($oRhServidorRamal,$oRhRamal);
		$oRhServidorRamalBD = new RhServidorRamalBD();
		if(!$oRhServidorRamalBD->alterar($oRhServidorRamal)){
			$this->msg = $oRhServidorRamalBD->msg;
			return false;
		}
		return true;
	}
	
	// ============ Funcoes de Exclusao =================
	/**
	 * Excluir SicasHistoricoImpressao
	 *
	 * @access public
	 * @param integer $idSicasHistoricoImpressao        	
	 * @return bool
	 */
	public function excluiSicasHistoricoImpressao($idSicasHistoricoImpressao){
		$oSicasHistoricoImpressaoBD = new SicasHistoricoImpressaoBD();
		if(!$oSicasHistoricoImpressaoBD->excluir($idSicasHistoricoImpressao)){
			$this->msg = $oSicasHistoricoImpressaoBD->msg;
			return false;
		}
		return true;
	}

	/**
	 * Excluir RhServidorRamal
	 *
	 * @access public
	 * @param integer $cd_servidor
	 * @param integer $cd_ramal
	 * @return bool
	 */
	public function excluiRhServidorRamal($cd_servidor, $cd_ramal){
		$oRhServidorRamalBD = new RhServidorRamalBD();
		if(!$oRhServidorRamalBD->excluir($cd_servidor, $cd_ramal)){
			$this->msg = $oRhServidorRamalBD->msg;
			return false;
		}
		return true;
	}
	
	// ============ Funcoes de Selecao =================
	/**
	 * get registro de SicasHistoricoImpressao
	 *
	 * @access public
	 * @param integer $cd_carteira        	
	 * @return SicasHistoricoImpressao
	 */
	public function getSicasHistoricoImpressao($cd_carteira){
		$oSicasHistoricoImpressaoBD = new SicasHistoricoImpressaoBD();
		if($oSicasHistoricoImpressaoBD->msg != ''){
			$this->msg = $oSicasHistoricoImpressaoBD->msg;
			return false;
		}
		return $oSicasHistoricoImpressaoBD->get($cd_carteira);
	}
	
	// ============ Funcoes de Colecao =================
	/**
	 * Carregar Colecao de dados de SicasHistoricoImpressao
	 *
	 * @access public
	 * @param string[] $aFiltro Filtro de consulta
	 * @param string[] $aOrdenacao Ordenação dos campos
	 * @return SicasHistoricoImpressao[]
	 */
	public function getAllSicasHistoricoImpressao($aFiltro=[], $aOrdenacao=[]){
		$oSicasHistoricoImpressaoBD = new SicasHistoricoImpressaoBD();
		if($oSicasHistoricoImpressaoBD->msg != ''){
			$this->msg = $oSicasHistoricoImpressaoBD->msg;
			return false;
		}
		return $oSicasHistoricoImpressaoBD->getAll($aFiltro, $aOrdenacao);
	}
	
	/**
	 * Colecao de servidores de um determinado Ramal
	 *
	 * @access public
	 * @param int $cd_ramal
	 * @return RhServidorRamal[]
	 */
	public function getAllRhServidorRamalPorRamal($cd_ramal){
		$oRhServidorRamalBD = new RhServidorRamalBD();
		if($oRhServidorRamalBD->msg != ''){
			$this->msg = $oRhServidorRamalBD->msg;
			return false;
		}
		return $oRhServidorRamalBD->getAllRhServidorRamalPorRamal($cd_ramal);
	}
	
	/**
	 * Colecao de ramais de um determinado servidor
	 *
	 * @access public
	 * @param int $cd_ramal
	 * @return RhServidorRamal[]
	 */
	public function getAllRhRamalPorServidor($cd_servidor){
		$oRhServidorRamalBD = new RhServidorRamalBD();
		if($oRhServidorRamalBD->msg != ''){
			$this->msg = $oRhServidorRamalBD->msg;
			return false;
		}
		return $oRhServidorRamalBD->getAllRhRamalPorServidor($cd_servidor);
	}
	
	// ============ Funcoes de Consulta =================
	/**
	 * Consultar registros de SicasHistoricoImpressao
	 *
	 * @access public
	 * @param string $valor        	
	 * @return SicasHistoricoImpressao
	 */
	public function consultarSicasHistoricoImpressao($valor){
		$oSicasHistoricoImpressaoBD = new SicasHistoricoImpressaoBD();
		return $oSicasHistoricoImpressaoBD->consultar($valor);
	}
	
	/**
	 * Consultar registros dos Ramais dos Servidores
	 *
	 * @access public
	 * @param string $valor
	 * @return RhServidorRamal
	 */
	public function consultarRhServidorRamal($valor){
		$oRhServidorRamalBD = new RhServidorRamalBD();
		return $oRhServidorRamalBD->consultar($valor);
	}
	
	/**
	 * Total de registros de RhServidorRamal
	 *
	 * @access public
	 * @return integer
	 */
	public function totalColecaoRhServidorRamal(){
	    $oRhServidorRamalBD = new RhServidorRamalBD();
	    return $oRhServidorRamalBD->totalColecao();
	}

	/**
	 * Total de registros de SicasHistoricoImpressao
	 *
	 * @access public
	 * @return integer
	 */
	public function totalColecaoSicasHistoricoImpressao(){
	    $oSicasHistoricoImpressaoBD = new SicasHistoricoImpressaoBD();
	    return $oSicasHistoricoImpressaoBD->totalColecao();
	}
	
	// ============ Funcoes Adicionais =================
	// =============== Componentes ==================
	
	/**
	 * Componente de lista de UFs
	 *
	 * @param string $nomeCampo        	
	 * @param string $valor        	
	 * @access public
	 * @return void
	 */
	public function componenteListaUf($nomeCampo, $valor = NULL){
		include(dirname(dirname(__FILE__)) . "/componentes/componenteListaUf.php");
	}
	
	/**
	 * Componente que exibe calendário
	 *
	 * @param string $nomeCampo        	
	 * @param string $valorInicial   	
	 * @param string $adicional        	
	 * @param Bool $hora        	
	 * @return void
	 */
	function componenteCalendario($nomeCampo, $valorInicial = NULL, $complemento = NULL, $hora = false, $formato = NULL){
		include(dirname(dirname(__FILE__)) . "/componentes/componenteCalendario.php");
	}
	
	/**
	 * Componente que exibe mensagem na tela
	 *
	 * @param string $msg        	
	 * @param string $tipo        	
	 * @access public
	 * @return void
	 */
	public function componenteMsg($msg, $tipo = "erro"){
		include(dirname(dirname(__FILE__)) . "/componentes/componenteMsg.php");
	}
	
	/**
	 * Componente de Paginação
	 *
	 * @param integer $numPags
	 * @access public
	 * @return void
	 */
	public function componentePaginacao($numPags){
	    include(dirname(dirname(__FILE__))."/componentes/componentePaginacao.php");
	}
}