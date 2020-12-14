<?php
class HistoricoBDBase{
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao){
		try{
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oHistorico){
		$reg = HistoricoMAP::objToRs($oHistorico);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.historico(
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
	function alterar($oHistorico){
		$reg = HistoricoMAP::objToRs($oHistorico);
		$sql = "
                update 
                    usersicas.historico 
                set
                    ";
		foreach($reg as $cv => $vl){
			if($cv == "codigo")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                where
                    codigo ={$reg['codigo']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "codigo")
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
	function excluir($codigo){
		$sql = "
                delete from
                    usersicas.historico 
                where
                    codigo = $codigo";
		
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
	function get($codigo){
		$sql = "
                select 
                    historico.codigo as historico_codigo,
					historico.data_historico as historico_data_historico,
					historico.entidade as historico_entidade,
					historico.ip as historico_ip,
					historico.tipo_persistencia as historico_tipo_persistencia,
					historico.usuario as historico_usuario,
					historico.xml as historico_xml 
                from
                    usersicas.historico 
                where
                    historico.codigo = $codigo";
		try{
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return HistoricoMAP::rsToObj($aReg);
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
                    		row_number()OVER(ORDER BY historico.codigo ASC)AS row_number,
                            ".HistoricoMAP::dataToSelect()."
                        from
                            usersicas.historico
                          )tb
                     where
                        row_number > ".$qtd*($pagina-1);
	    } else {
	        $sql = "SELECT
                        ".SicasCidMAP::dataToSelect()."
                    from
                        usersicas.historico";
	        
	        if(count($aFiltro)> 0){
	            $sql .= " where ";
	            $sql .= implode(" and ", $aFiltro);
	        }
	        
	        if(count($aOrdenacao)> 0){
	            $sql .= " order by ";
	            $sql .= implode(",", $aOrdenacao);
	        }
	    }

		try{
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = HistoricoMAP::rsToObj($aReg);
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
	function totalColecao(){
		$sql = "select count(*) from usersicas.historico";
		try{
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			return(int) $aReg [0];
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function consultar($valor){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    historico.codigo as historico_codigo,
					historico.data_historico as historico_data_historico,
					historico.entidade as historico_entidade,
					historico.ip as historico_ip,
					historico.tipo_persistencia as historico_tipo_persistencia,
					historico.usuario as historico_usuario,
					historico.xml as historico_xml 
                from
                    usersicas.historico
                where
                    historico.data_historico like '$valor' 
					or historico.entidade like '$valor' 
					or historico.ip like '$valor' 
					or historico.tipo_persistencia like '$valor' 
					or historico.usuario like '$valor' 
					or historico.xml like '$valor'";
		// print "<pre>$sql</pre>";
		try{
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = HistoricoMAP::rsToObj($aReg);
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