<?php
class SicasProcedimentoAutorizadoBDBase {
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao) {
	    $this->joinTabelas = "
                        usersicas.sicas_procedimento_autorizado 
    				left join usersicas.sicas_encaminhamento 
    					on (sicas_procedimento_autorizado.cd_encaminhamento = sicas_encaminhamento.cd_encaminhamento)
    				left join usersicas.sicas_procedimento 
    					on (sicas_procedimento_autorizado.cd_procedimento = sicas_procedimento.cd_procedimento) 
                    left join usersicas.sicas_pessoa
        				on (sicas_encaminhamento.cd_pessoa = sicas_pessoa.cd_pessoa)
                    left join usersicas.sicas_pessoa_categoria
        				on (sicas_pessoa_categoria.cd_categoria = sicas_pessoa.cd_categoria)
    				left join usersicas.sicas_medico
    					on (sicas_encaminhamento.cd_medico = sicas_medico.cd_medico)
                    left join usersicas.sicas_servidor
    					on (sicas_servidor.cd_servidor = sicas_medico.cd_servidor)
                    left join usersicas.sicas_lotacao
    					on (sicas_servidor.cd_lotacao = sicas_lotacao.cd_lotacao)
                    left join usersicas.sicas_lotacao lotacao_pai
    					on (sicas_lotacao.cd_lotacao_pai = lotacao_pai.cd_lotacao)
                    left join usersicas.rh_cargo
    					on (sicas_servidor.cd_cargo = rh_cargo.cd_cargo)
                    left join usersicas.sicas_pessoa pessoa_servidor
    					on (pessoa_servidor.cd_pessoa = sicas_servidor.cd_pessoa)
                    left join usersicas.sicas_pessoa_categoria categoria_servidor 
			           on (pessoa_servidor.cd_categoria = categoria_servidor.cd_categoria)
                    left join usersicas.sicas_estado_civil 
			           on (sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
    				left join usersicas.sicas_consulta_medica
    					on (sicas_encaminhamento.cd_consulta_medica = sicas_consulta_medica.cd_consulta_medica)
                    left join usersicas.sicas_atendimento
    					on (sicas_atendimento.cd_atendimento = sicas_consulta_medica.cd_atendimento)
                    left join usersicas.sicas_tipo_atendimento
    					on (sicas_consulta_medica.cd_tipo_atendimento = sicas_tipo_atendimento.cd_tipo_atendimento)
    				left join usersicas.sicas_credenciado
    					on (sicas_encaminhamento.cd_credenciado = sicas_credenciado.cd_credenciado)
    				left join usersicas.sicas_tipo_despesa
    					on (sicas_encaminhamento.cd_tipo_despesa = sicas_tipo_despesa.cd_tipo_despesa)";
	    
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage ();
		}
	}
	function inserir($oSicasProcedimentoAutorizado) {
		$reg = SicasProcedimentoAutorizadoMAP::objToRsInsert($oSicasProcedimentoAutorizado);
		$aCampo = array_keys ( $reg );
		$sql = "
                insert into usersicas.sicas_procedimento_autorizado(
                    " . implode ( ',', $aCampo ) . "
                ) 
                values(
                    :" . implode ( ", :", $aCampo ) . ")";
		
		foreach ( $reg as $cv => $vl )
			$regTemp [":$cv"] = ($vl == '') ? NULL : $vl;
		
		try {
			$this->oConexao->executePrepare ( $sql, $regTemp );
			if ($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return $this->oConexao->lastID();
			
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function alterar($oSicasProcedimentoAutorizado) {
		$reg = SicasProcedimentoAutorizadoMAP::objToRs ( $oSicasProcedimentoAutorizado );
		$sql = "
                update 
                    usersicas.sicas_procedimento_autorizado 
                set
                    ";
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_procedimento_autorizado")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode ( ",\n", $a );
		$sql .= "
                where
                    cd_procedimento_autorizado = {$reg['cd_procedimento_autorizado']}";
		
		foreach ($reg as $cv => $vl){
			if ($cv == "cd_procedimento_autorizado")
				continue;
			$regTemp [":$cv"] = ($vl == '') ? NULL : $vl;
		}
		try {
			$this->oConexao->executePrepare ( $sql, $regTemp );
			if ($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function excluir($cd_procedimento_autorizado) {
		$sql = "
                delete from
                    usersicas.sicas_procedimento_autorizado 
                where
                    cd_procedimento_autorizado = $cd_procedimento_autorizado";
		
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	
	function get($cd_procedimento_autorizado) {
		$sql = "
                    select 
                        ".SicasProcedimentoAutorizadoMAP::dataToSelect()."
                    from
                        {$this->joinTabelas}
                    where
                        sicas_procedimento_autorizado.cd_procedimento_autorizado = $cd_procedimento_autorizado";
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->numRows () != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasProcedimentoAutorizadoMAP::rsToObj ( $aReg );
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch (PDOException $e){
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	
	function getAll($aFiltro=[], $aOrdenacao=[], $qtd=NULL, $pagina=NULL){
	    if($pagina != NULL){
	        $sql = "
                   SELECT TOP($qtd) *
                      FROM(
                           SELECT
                    		row_number()OVER(ORDER BY sicas_procedimento_autorizado.cd_procedimento_autorizado ASC)AS row_number,
                            ".SicasProcedimentoAutorizadoMAP::dataToSelect()."
                        from
                            {$this->joinTabelas}
                          )tb
                     where
                        row_number > ".$qtd*($pagina-1);
	    } else {
	        $sql = "SELECT
                        ".SicasProcedimentoAutorizadoMAP::dataToSelect()."
                    from
                        {$this->joinTabelas}";
                        
            if(count($aFiltro)> 0){
                $sql .= " where ";
                $sql .= implode(" and ", $aFiltro);
            }
            
            if(count($aOrdenacao)> 0){
                $sql .= " order by ";
                $sql .= implode(",", $aOrdenacao);
            }
	    }
	    
	  //Util::trace($sql);
	    
	    try {
	        $this->oConexao->execute($sql);
	        $aObj = array();
	        if($this->oConexao->numRows()!= 0){
	            while($aReg = $this->oConexao->fetchReg()){
	                $aObj [] = SicasProcedimentoAutorizadoMAP::rsToObj($aReg);
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
	
	function totalColecao() {
		$sql = "select count(*) from usersicas.sicas_procedimento_autorizado";
		try {
			$this->oConexao->execute ( $sql );
			$aReg = $this->oConexao->fetchReg ();
			return (int)$aReg[''];
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	
	function consultar($valor) {
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    ".SicasProcedimentoAutorizadoMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    ".SicasProcedimentoAutorizadoMAP::filterLike($valor);
		// print "<pre>$sql</pre>";
		
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