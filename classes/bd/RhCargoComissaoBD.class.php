<?php
class RhCargoComissaoBD extends RhCargoComissaoBDBase {
	function __construct($conexao = NULL) {
		if (! $conexao)
			$conexao = new Conexao ();
		if ($conexao->msg != "") {
			$this->msg = $conexao->msg;
		} else {
			parent::__construct ( $conexao );
		}
	}
	
	function getByServidor($cd_servidor){
	    $sql = "
                select
                    ".RhCargoComissaoMAP::dataToSelect()."
                from
					".$this->joinTabelas."
                where
                    rh_cargo_comissao.cd_servidor = $cd_servidor";
	    try{
	        $this->oConexao->execute($sql);
	        if($this->oConexao->numRows() != 0){
	            $aReg = $this->oConexao->fetchReg();
	            return RhCargoComissaoMAP::rsToObj($aReg);
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