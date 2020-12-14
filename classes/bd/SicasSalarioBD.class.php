<?php
class SicasSalarioBD extends SicasSalarioBDBase {
	function __construct($conexao = NULL) {
		if (! $conexao)
			$conexao = new Conexao ();
		if ($conexao->msg != "") {
			$this->msg = $conexao->msg;
		} else {
			parent::__construct ( $conexao );
		}
	}
	
	function getAtualByServidor($cd_servidor){
	    $sql = "
                select
                    ".SicasSalarioMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    sicas_servidor.cd_servidor = $cd_servidor
                    and sicas_salario.status   = 1";
        //Util::trace($sql);
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $aReg = $this->oConexao->fetchReg();
                return SicasSalarioMAP::rsToObj($aReg);
            } else{
                $this->msg = "Nenhum registro encontrado!";
                return false;
            }
        } catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
	}
	
	function getAtualByPessoaServidor($cd_pessoa){
	    $sql = "
                select
                    ".SicasSalarioMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    sicas_pessoa.cd_pessoa = $cd_pessoa
                    and sicas_salario.status   = 1";
        //util::trace($sql);
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $aReg = $this->oConexao->fetchReg();
                return SicasSalarioMAP::rsToObj($aReg);
            } else{
                $this->msg = "Nenhum registro encontrado!";
                return false;
            }
        } catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
	}
	
	function getAtualByPessoaDependente($cd_pessoa){
	    $sql = "
                select
                    ".SicasSalarioMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                left join usersicas.sicas_dependente
                    on (sicas_dependente.cd_servidor = sicas_servidor.cd_servidor)
                where
                    sicas_dependente.cd_pessoa = $cd_pessoa
                    and sicas_salario.status   = 1";
        //util::trace($sql);
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $aReg = $this->oConexao->fetchReg();
                return SicasSalarioMAP::rsToObj($aReg);
            } else{
                $this->msg = "Nenhum registro encontrado!";
                return false;
            }
        } catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
	}
}