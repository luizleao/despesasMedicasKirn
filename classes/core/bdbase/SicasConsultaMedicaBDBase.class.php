<?php
class SicasConsultaMedicaBDBase{
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = "
                    usersicas.sicas_consulta_medica 
				left join usersicas.sicas_atendimento 
					on(sicas_consulta_medica.cd_atendimento = sicas_atendimento.cd_atendimento)
				left join usersicas.sicas_medico 
					on(sicas_consulta_medica.cd_medico = sicas_medico.cd_medico)
				left join usersicas.sicas_tipo_atendimento 
					on(sicas_consulta_medica.cd_tipo_atendimento = sicas_tipo_atendimento.cd_tipo_atendimento)";
		try{
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasConsultaMedica){
		$reg = SicasConsultaMedicaMAP::objToRsInsert($oSicasConsultaMedica);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_consulta_medica(
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
	function alterar($oSicasConsultaMedica){
		$reg = SicasConsultaMedicaMAP::objToRs($oSicasConsultaMedica);
		$sql = "
                    update 
                        usersicas.sicas_consulta_medica 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_consulta_medica")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_consulta_medica ={$reg['cd_consulta_medica']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_consulta_medica")
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
	function excluir($cd_consulta_medica){
		$sql = "
                    delete from
                        usersicas.sicas_consulta_medica 
                    where
                        cd_consulta_medica = $cd_consulta_medica";
		
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
	function get($cd_consulta_medica){
		$sql = "
                select 
                    ".SicasConsultaMedicaMAP::dataToSelect()."
                from
                    {$this->joinTabelas} 
                where
                    sicas_consulta_medica.cd_consulta_medica = $cd_consulta_medica";
		try{
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasConsultaMedicaMAP::rsToObj($aReg);
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
                    		row_number()OVER(ORDER BY sicas_consulta_medica.cd_consulta_medica ASC)AS row_number,
                            ".SicasConsultaMedicaMAP::dataToSelect()."
                        from
                            {$this->joinTabelas}
                          )tb
                     where
                        row_number > ".$qtd*($pagina-1);
	    } else {
	        $sql = "SELECT
                        ".SicasConsultaMedicaMAP::dataToSelect()."
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
	                $aObj [] = SicasConsultaMedicaMAP::rsToObj($aReg);
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
		$sql = "select count (*) from usersicas.sicas_consulta_medica";
		try{
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			//Util::trace($aReg);
			return (int) $aReg[''];
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function consultar($valor){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    ".SicasConsultaMedicaMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    sicas_consulta_medica.cd_atendimento like '$valor' 
					or sicas_consulta_medica.dt_consulta like '$valor' 
					or sicas_consulta_medica.cd_medico like '$valor' 
					or sicas_consulta_medica.qp_paciente like '$valor' 
					or sicas_consulta_medica.exame_fisico like '$valor' 
					or sicas_consulta_medica.exame_solicitado like '$valor' 
					or sicas_consulta_medica.diag_paciente like '$valor' 
					or sicas_consulta_medica.cd_tipo_atendimento like '$valor' 
					or sicas_consulta_medica.resultado like '$valor' 
					or sicas_consulta_medica.tratamento like '$valor' 
					or sicas_consulta_medica.status like '$valor'";
		// print "<pre>$sql</pre>";
		try{
			$this->oConexao->execute($sql);
			$aObj = [];
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasConsultaMedicaMAP::rsToObj($aReg);
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