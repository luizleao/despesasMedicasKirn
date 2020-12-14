<?php
class SicasProcedimentoAutorizadoBD extends SicasProcedimentoAutorizadoBDBase {
	function __construct($conexao = NULL) {
		if (! $conexao)
			$conexao = new Conexao ();
		if ($conexao->msg != "") {
			$this->msg = $conexao->msg;
		} else {
			parent::__construct ( $conexao );
		}
	}
	
	function getAllProcedimentoServidor($cd_servidor){
        $sql = "select 
	               * 
                from 
                	usersicas.vw_encaminhamento_servidor_dependente 
                where
                	cd_servidor = $cd_servidor
                	and cd_consulta_medica=14755";
	    
	    //Util::trace($sql);
	    
	    try {
	        $this->oConexao->execute($sql);
	        $aObj = [];
	        if($this->oConexao->numRows()!= 0){
	            while($aReg = $this->oConexao->fetchReg()){
	                $aObj[] = $aReg;
	                //$aObj[] = SicasProcedimentoAutorizadoMAP::rsToObj($aReg);
	            }
	            return $aObj;
	        } else {
	            return false;
	        }
	    } catch(PDOException $e){
	        $this->msg = $e->getMessage();
	        return false;
	    }
	}
	
	function getAllProcedimentoPendenteCredenciado($cd_credenciado, $dataInicio, $dataFim){
	    $sql = "
                select
                    ".SicasProcedimentoAutorizadoMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    sicas_credenciado.cd_credenciado=$cd_credenciado
                    and sicas_encaminhamento.dt_encaminhamento >='".Util::limpaCampo($dataInicio)."' 
                    and sicas_encaminhamento.dt_encaminhamento <= '".Util::limpaCampo($dataFim)."'
                    and sicas_procedimento_autorizado.cd_procedimento_autorizado not in (select 
                                                                                            cd_procedimento_autorizado 
                                                                                         from 
                                                                                            usersicas.sicas_despesa 
                                                                                         where 
                                                                                            status=1)
                order by
                    sicas_encaminhamento.dt_encaminhamento";
        //Util::trace($sql);
                    
        try {
            $this->oConexao->execute ( $sql );
            $aObj = array ();
            if ($this->oConexao->numRows () != 0) {
                while ( $aReg = $this->oConexao->fetchReg () ) {
                    $aObj [] = SicasProcedimentoAutorizadoMAP::rsToObj ( $aReg );
                }
                return $aObj;
            } else {
                return false;
            }
        } catch ( PDOException $e ) {
            $this->msg = $e->getMessage ();
            return false;
        }
	}
	
}