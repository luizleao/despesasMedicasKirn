<?php
class SicasCredenciamentoBDBase{
	public $oConexao;
	public $msg;
	public $joinTabelas;
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = "
                    usersicas.sicas_credenciamento 
				left join usersicas.sicas_credenciado 
					on(sicas_credenciamento.cd_credenciado = sicas_credenciado.cd_credenciado)";
		try{
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	
	function cadastrar($oSicasCredenciamento){
		$reg = SicasCredenciamentoMAP::objToRsInsert($oSicasCredenciamento);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_credenciamento(
                    " . implode(',', $aCampo) . "
               ) 
                values(
                    :" . implode(", :", $aCampo) . ")";
		
		foreach($reg as $cv => $vl)
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
		
		try{
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
	
	function alterar($oSicasCredenciamento){
		$reg = SicasCredenciamentoMAP::objToRs($oSicasCredenciamento);
		$sql = "
                update 
                    usersicas.sicas_credenciamento 
                set
                    ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_credenciamento")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                where
                    cd_credenciamento = {$reg['cd_credenciamento']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_credenciamento")
				continue;
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
		}
		try{
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
	
	function excluir($cd_credenciamento){
		$sql = "
                delete from
                    usersicas.sicas_credenciamento 
                where
                    cd_credenciamento = $cd_credenciamento";
		
		try{
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
	
	function get($cd_credenciamento){
		$sql = "
                select 
                    ".SicasCredenciamentoMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    sicas_credenciamento.cd_credenciamento = $cd_credenciamento";
		try{
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasCredenciamentoMAP::rsToObj($aReg);
			} else{
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
                    		row_number()OVER(ORDER BY sicas_credenciado.nm_credenciado ASC)AS row_number,
                            ".SicasCredenciamentoMAP::dataToSelect()."
                        from
                            {$this->joinTabelas}
                          )tb
                     where
                        row_number > ".$qtd*($pagina-1);
	    } else {
	        $sql = "SELECT
                        ".SicasCredenciamentoMAP::dataToSelect()."
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
	                $aObj [] = SicasCredenciamentoMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_credenciamento";
		try{
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
                    ".SicasCredenciamentoMAP::dataToSelect()." 
                from
                    {$this->joinTabelas}
                where
                    ".SicasCredenciamentoMAP::filterLike($valor);
		// print "<pre>$sql</pre>";
		try{
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasCredenciamentoMAP::rsToObj($aReg);
				}
				return $aObj;
			} else{
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
}