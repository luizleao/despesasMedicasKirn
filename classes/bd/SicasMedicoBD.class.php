<?php
class SicasMedicoBD extends SicasMedicoBDBase {
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
                    ".SicasMedicoMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    sicas_servidor.cd_servidor = $cd_servidor";
        try {
            //Util::trace($sql);
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $aReg = $this->oConexao->fetchReg();
                return SicasMedicoMAP::rsToObj($aReg);
            } else {
                $this->msg = "Nenhum registro encontrado!";
                return false;
            }
        } catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
	}
}