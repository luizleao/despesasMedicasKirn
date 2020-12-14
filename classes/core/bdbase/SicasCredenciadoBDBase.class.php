<?php
class SicasCredenciadoBDBase{
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao){
	    
	    $this->joinTabelas = " usersicas.sicas_credenciado";
	    //print "@@".$this->joinTabelas;
	    
		try{
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	
	function inserir($oSicasCredenciado){
		$reg = SicasCredenciadoMAP::objToRs($oSicasCredenciado);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_credenciado(
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
	function alterar($oSicasCredenciado){
		$reg = SicasCredenciadoMAP::objToRs($oSicasCredenciado);
		$sql = "
                update 
                    usersicas.sicas_credenciado 
                set
                    ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_credenciado")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_credenciado ={$reg['cd_credenciado']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_credenciado")
				continue;
			$regTemp [":$cv"] =($vl == '') ? NULL : utf8_encode($vl);
		}
		try{
		    //Util::trace($sql);
		    //Util::trace($regTemp);
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
	function excluir($cd_credenciado){
		$sql = "
                delete from
                    usersicas.sicas_credenciado 
                where
                    cd_credenciado = $cd_credenciado";
		
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
	function get($cd_credenciado){
		$sql = "
                select 
                    ".SicasCredenciadoMAP::dataToSelect()."
                from
                    {$this->joinTabelas} 
                where
                    sicas_credenciado.cd_credenciado = $cd_credenciado";
		try{
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasCredenciadoMAP::rsToObj($aReg);
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
                    		row_number()OVER(ORDER BY sicas_credenciado.nm_credenciado ASC) AS row_number,
                            ".SicasCredenciadoMAP::dataToSelect()."
                        from
                            {$this->joinTabelas}
                          )tb
                     where
                        row_number > ".$qtd*($pagina-1);
	    } else {
	        $sql = "SELECT
                        ".SicasCredenciadoMAP::dataToSelect()."
                    from
                        {$this->joinTabelas}";
                        
            if(count($aFiltro)> 0){
                $sql .= "
                    where ";
                $sql .= implode(" and ", $aFiltro);
            }
            
            if(count($aOrdenacao)> 0){
                $sql .= "
                    order by ";
                $sql .= implode(",", $aOrdenacao);
            }
	    }
	    
	    //Util::trace($sql);
	    
	    try {
	        $this->oConexao->execute($sql);
	        $aObj = array();
	        if($this->oConexao->numRows()!= 0){
	            while($aReg = $this->oConexao->fetchReg()){
	                $aObj[] = SicasCredenciadoMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_credenciado";
		try{
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			return (int)$aReg[''];
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function consultar($valor, $aOrdenacao=[]){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    ".SicasCredenciadoMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    ".SicasCredenciadoMAP::filterLike($valor);
        
        if(count($aOrdenacao)> 0){
            $sql .= "
                order by ".implode(",", $aOrdenacao);
        }
		
		//Util::trace($sql);
		
		try{
			$this->oConexao->execute($sql);
			$aObj = [];
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasCredenciadoMAP::rsToObj($aReg);
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