<?php
class SicasServidorBDBase{
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = "
                                usersicas.sicas_servidor
            		    	left join usersicas.sicas_pessoa
            		    		on(sicas_servidor.cd_pessoa = sicas_pessoa.cd_pessoa)
            		    	left join usersicas.sicas_estado_civil
            		    		on(sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
            		    	left join usersicas.sicas_pessoa_categoria
            		    		on(sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
                            left join usersicas.sicas_pessoa_categoria categoria_servidor
            		    		on(sicas_servidor.cd_categoria = categoria_servidor.cd_categoria)
            		    	left join usersicas.sicas_lotacao
            		    		on(sicas_servidor.cd_lotacao = sicas_lotacao.cd_lotacao)
                            left join usersicas.sicas_lotacao lotacao_pai
            		    		on(sicas_lotacao.cd_lotacao_pai = lotacao_pai.cd_lotacao)
            		    	left join usersicas.rh_cargo
            		    		on(sicas_servidor.cd_cargo = rh_cargo.cd_cargo)";
		try{
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function cadastrar($oSicasServidor){
		$reg = SicasServidorMAP::objToRsInsert($oSicasServidor);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_servidor(
                    " . implode(',', $aCampo) . "
               ) 
                values(
                    :" . implode(", :", $aCampo) . ")";
		
		foreach($reg as $cv => $vl)
			$regTemp[":$cv"] =($vl == '') ? NULL : $vl;
		
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
	
	function alterar($oSicasServidor){
		$reg = SicasServidorMAP::objToRs($oSicasServidor);
		//print "<pre>"; print_r($reg); print "</pre>";
		$sql = "
                    update 
                        usersicas.sicas_servidor 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_servidor")
				continue;
			$a[] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_servidor ={$reg['cd_servidor']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_servidor")
				continue;
			$regTemp[":$cv"] =($vl == '') ? NULL : $vl;
		}
		try{
			//print "<pre>$sql</pre>"; //exit;
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
	function excluir($cd_servidor){
		$sql = "
                delete from
                    usersicas.sicas_servidor 
                where
                    cd_servidor = $cd_servidor";
		
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
	function get($cd_servidor){
		$sql = "
                select 
                	".SicasServidorMAP::dataToSelect()."
				from
                    ".$this->joinTabelas." 
                where
                    sicas_servidor.cd_servidor = $cd_servidor";
		try{
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasServidorMAP::rsToObj($aReg);
			} else{
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function getAll($aFiltro = [], $aOrdenacao = []){
		$sql = "
                select
                    ".SicasServidorMAP::dataToSelect()."
                from
                    ".$this->joinTabelas;
		
		if(count($aFiltro) > 0){
			$sql .= " where ";
			$sql .= implode(" and ", $aFiltro);
		}
		
		if(count($aOrdenacao) > 0){
			$sql .= " order by ";
			$sql .= implode(",", $aOrdenacao);
		}
		try{
			//Util::trace($sql); //exit;
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasServidorMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_servidor";
		try{
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			return (int) $aReg[''];
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function consultar($valor, $servidor_ativo=NULL){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                   ".SicasServidorMAP::dataToSelect()."
                from
                    ".$this->joinTabelas."
                where
                   (".SicasServidorMAP::filterLike($valor).")";

		$sql .= ($servidor_ativo) ? " and sicas_servidor.status = 1" : "";

		//Util::trace($sql);
		
		try{
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasServidorMAP::rsToObj($aReg);
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