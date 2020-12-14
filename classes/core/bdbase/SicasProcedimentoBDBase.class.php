<?php
class SicasProcedimentoBDBase {
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = "usersicas.sicas_procedimento";
	    
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function cadastrar($oSicasProcedimento){
		$reg = SicasProcedimentoMAP::objToRsInsert($oSicasProcedimento);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_procedimento(
                    " . implode(',', $aCampo). "
              )
                values(
                    :" . implode(", :", $aCampo). ")";
		
		foreach($reg as $cv => $vl)
			$regTemp [":$cv"] =($vl == '')? NULL : $vl;
		
		try {
			$this->oConexao->executePrepare($sql, $regTemp);
			if($this->oConexao->msg != ""){
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return $this->oConexao->lastID();
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function alterar($oSicasProcedimento){
		$reg = SicasProcedimentoMAP::objToRs($oSicasProcedimento);
		$sql = "
                    update 
                        usersicas.sicas_procedimento 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_procedimento")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_procedimento = {$reg['cd_procedimento']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_procedimento")
				continue;
			$regTemp [":$cv"] =($vl == '')? NULL : $vl;
		}
		try {
			$this->oConexao->executePrepare($sql, $regTemp);
			if($this->oConexao->msg != ""){
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function excluir($cd_procedimento){
		$sql = "
                    delete from
                        usersicas.sicas_procedimento 
                    where
                        cd_procedimento = $cd_procedimento";
		
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->msg != ""){
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function get($cd_procedimento){
		$sql = "
                    select 
                        ".SicasProcedimentoMAP::dataToSelect()."
                    from
                        {$this->joinTabelas}
                    where
                        sicas_procedimento.cd_procedimento = $cd_procedimento";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasProcedimentoMAP::rsToObj($aReg);
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function getAll($aFiltro=[], $aOrdenacao=[], $qtd = NULL, $pagina = NULL){
	    if($pagina != NULL){
	        $sql = "
                   SELECT TOP($qtd) *
                      FROM(
                           SELECT
                    		row_number()OVER(ORDER BY sicas_procedimento.cd_procedimento ASC)AS row_number,
                            ".SicasProcedimentoMAP::dataToSelect()."
                        from
                            {$this->joinTabelas}
                          )tb
                     where
                        row_number > ".$qtd*($pagina-1);
	    } else {
	        $sql = "SELECT
                        ".SicasProcedimentoMAP::dataToSelect()."
                    from
                        $join";
                        
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
	                $aObj[] = SicasProcedimentoMAP::rsToObj($aReg);
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

	function totalColecao(){
		$sql = "select count(*) from usersicas.sicas_procedimento";
		try {
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			return (int)$aReg[''];
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function consultar($valor){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    ".SicasProcedimentoMAP::dataToSelect()." 
                from
                    usersicas.sicas_procedimento
                where
                    sicas_procedimento.num_procedimento like '$valor' 
					or sicas_procedimento.nm_procedimento like '$valor' 
					or sicas_procedimento.num_custo_operacional like '$valor' 
					or sicas_procedimento.num_honorario like '$valor' 
					or sicas_procedimento.num_med_filme like '$valor' 
					or sicas_procedimento.num_auxiliares like '$valor' 
					or sicas_procedimento.num_port_anest like '$valor' 
					or sicas_procedimento.sigla like '$valor' 
					or sicas_procedimento.red_registro like '$valor' 
					or sicas_procedimento.status like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasProcedimentoMAP::rsToObj($aReg);
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
}