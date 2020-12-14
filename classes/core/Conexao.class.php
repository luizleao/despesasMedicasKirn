<?php

/**
 * Classe de conexao com o banco de dados baseado na biblioteca PDO
 * 
 * @author Luiz Leão
 */
class Conexao {
	/**
	 * Armazena a consulta
	 *
	 * @var resource
	 */
	public $consulta;
	/**
	 * Mensagem do sistema
	 *
	 * @var string
	 */
	public $msg;
	/**
	 * Informação sobre o servidor utilizado: Produção, Desenvolvimento ou Homologacao
	 *
	 * @var string
	 */
	public $local = "producao";
	/**
	 * Armazena dados da conexao
	 *
	 * @var resource
	 */
	public $conexao;
	/**
	 * Data de Cadastro Padrão
	 *
	 * @var string
	 */
	public $data_cadastro_padrao = "now()";
	function __construct(){
		try {
			$config = parse_ini_file("config.ini", true);
			// print "<pre>"; print_r($config); print "</pre>";
			$this->conexao = new PDO("{$config[$this->local]['tipo_sgbd']}={$config[$this->local]['server']};{$config[$this->local]['label_db']}={$config[$this->local]['db']}", $config [$this->local] ['username'], $config [$this->local] ['pw']);
			
			$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e){
			// print "<pre>"; print_r($e); print "</pre>";
			$this->msg = $e->getMessage();
		}
	}
	
	function execute($sql){
		// print "<pre>$sql</pre>";
		$this->consulta = $this->conexao->query($sql);
		if(! $this->consulta){
			$aErro = $this->consulta->errorInfo();
			$this->msg = $aErro [2];
			throw new PDOException($aErro [2], $aErro [1]);
		}
		return true;
	}
	
	function executePrepare($sql, $aDados=[]){
		try {
			$this->consulta = $this->conexao->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
			if(!$this->consulta->execute($aDados)){
			    //Util::trace($sql);
			    //Util::trace($aDados);
				$aErro = $this->consulta->errorInfo();
				$this->msg = $aErro [2];
				throw new PDOException($aErro[2], $aErro[1]);
			}
			return true;
		} catch(PDOException $e){
			// Util::trace($e);
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function numRows($consulta = NULL){
		if(!$consulta){
			$consulta = $this->consulta;
		}
		return(int)$consulta->rowCount();
	}
	
	function fetchReg($consulta = NULL){
		if(!$consulta){
			$consulta = $this->consulta;
		}
		return $this->consulta->fetch(PDO::FETCH_ASSOC);
	}
	
	function fetchRow($consulta = NULL){
		if(!$consulta){
			$consulta = $this->consulta;
		}
		return $this->consulta->fetch();
	}
	
	function lastID(){
		return $this->conexao->lastInsertId();
	}
	
	function close(){
		try {
			if($this->consulta){
				$this->consulta->closeCursor();
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	
	function beginTrans(){
		$this->conexao->beginTransaction();
	}
	
	function commitTrans(){
		$this->conexao->commit();
	}
	
	function rollBackTrans(){
		$this->conexao->rollBack();
	}
}