<?php
class SicasCredenciadoBD extends SicasCredenciadoBDBase {
	function __construct($conexao = NULL) {
		if (! $conexao)
			$conexao = new Conexao ();
		if ($conexao->msg != "") {
			$this->msg = $conexao->msg;
		} else {
			parent::__construct($conexao);
		}
	}
	
	function consultarCredenciadoAtivo($valor) {
	    $valor = Util::formataConsultaLike($valor);
	    
	    $sql = "
                select
                    ".SicasCredenciadoMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    (".SicasCredenciadoMAP::filterLike($valor).")
                and sicas_credenciado.cd_credenciado in (select 
                                    						cd_credenciado 
                                    					from 
                                    						usersicas.sicas_credenciamento 
                                    					where 
                                    						GETDATE() between dt_ini_credenciamento and dt_fim_credenciamento)
                order by
                    sicas_credenciado.nm_credenciado";

        //Util::trace($sql);";
                    
        try {
            $this->oConexao->execute($sql);
            $aObj = [];
            if ($this->oConexao->numRows () != 0) {
                while ( $aReg = $this->oConexao->fetchReg()){
                    $aObj[] = SicasCredenciadoMAP::rsToObj($aReg);
                }
                return $aObj;
            } else {
                return false;
            }
        } catch(PDOException $e){
            $this->msg = $e->getMessage ();
            return false;
        }
	}
}