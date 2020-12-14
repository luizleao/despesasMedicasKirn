<?php
class SicasDependenteBD extends SicasDependenteBDBase {
	function __construct($conexao = NULL) {
		if (! $conexao)
			$conexao = new Conexao ();
		if ($conexao->msg != "") {
			$this->msg = $conexao->msg;
		} else {
			parent::__construct ( $conexao );
		}
	}
	
	function getByPessoa($cd_pessoa){
	    $sql = "
				select
					".SicasDependenteMAP::dataToSelect()."
                from
                    ".$this->joinTabelas."
                where
                    sicas_pessoa.cd_pessoa = $cd_pessoa";

	    //Util::trace($sql);
	    try {
	        $this->oConexao->execute($sql);
	        if($this->oConexao->numRows() != 0){
	            $aReg = $this->oConexao->fetchReg();
	            return SicasDependenteMAP::rsToObj($aReg);
	        } else {
	            $this->msg = "Nenhum registro encontrado!";
	            return false;
	        }
	    } catch(PDOException $e){
	        $this->msg = $e->getMessage();
	        return false;
	    }
	}
	
	
	function getNextSeq($cd_servidor){
	    $sql = "select count(*) from usersicas.sicas_dependente where cd_servidor=$cd_servidor";
	    try {
	        $this->oConexao->execute($sql);
	        $aReg = $this->oConexao->fetchReg();
	        return (int)$aReg['']+1;
	    } catch(PDOException $e){
	        $this->msg = $e->getMessage();
	        return false;
	    }
	}
}