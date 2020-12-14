<?php
class RhCargoComissaoBDBase{
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = "usersicas.rh_cargo_comissao
					left join usersicas.sicas_lotacao
						on (sicas_lotacao.cd_lotacao = rh_cargo_comissao.cd_lotacao)
                    left join usersicas.sicas_lotacao lotacao_pai
    		    		on (sicas_lotacao.cd_lotacao_pai = lotacao_pai.cd_lotacao)
					left join usersicas.sicas_servidor
						on (sicas_servidor.cd_servidor = rh_cargo_comissao.cd_servidor)
					left join usersicas.sicas_pessoa 
						on (sicas_servidor.cd_pessoa = sicas_pessoa.cd_pessoa
							and sicas_pessoa.status = 1)
					left join usersicas.sicas_estado_civil 
						on (sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
					left join usersicas.sicas_pessoa_categoria 
						on (sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
                    left join usersicas.sicas_pessoa_categoria categoria_servidor
    		    		on(sicas_servidor.cd_categoria = categoria_servidor.cd_categoria)
    		    	left join usersicas.rh_cargo
    		    		on(sicas_servidor.cd_cargo = rh_cargo.cd_cargo)";
		try{
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oRhCargoComissao){
		$reg = RhCargoComissaoMAP::objToRsInsert($oRhCargoComissao);
		
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.rh_cargo_comissao(
                    " . implode(',', $aCampo) . "
            ) 
                values(
					:" . implode(", :", $aCampo) . ")";
					// print "<pre>$sql</pre>";
		foreach($reg as $cv => $vl)
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
		
		try{
			$this->oConexao->executePrepare($sql, $regTemp);
			// print "<pre>$sql</pre>";
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
	function alterar($oRhCargoComissao){
		$reg = RhCargoComissaoMAP::objToRs($oRhCargoComissao);
		// print "<pre>"; print_r($reg); print "</pre>";
		$sql = "
                    update 
                        usersicas.rh_cargo_comissao 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_cargo_comissao")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
						cd_cargo_comissao ={$reg['cd_cargo_comissao']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_cargo_comissao")
				continue;
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
		}
		try{
			// print "<pre>$sql</pre>"; //exit;
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
	function excluir($cd_cargo_comissao){
		$sql = "
                delete from
                    usersicas.rh_cargo_comissao 
                where
                    cd_cargo_comissao = $cd_cargo_comissao";
		
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
	
	function get($cd_cargo_comissao){
		$sql = "
                select 
                    ".RhCargoComissaoMAP::dataToSelect()."
                from
					".$this->joinTabelas." 
                where
                    rh_cargo_comissao.cd_cargo_comissao = $cd_cargo_comissao";
		try{
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return RhCargoComissaoMAP::rsToObj($aReg);
			} else{
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function getAll($aFiltro=[], $aOrdenacao=[]){
		$sql = "
                select
					".RhCargoComissaoMAP::dataToSelect()."
                from
					".$this->joinTabelas;
       
		//Util::trace($sql);
		
		if(count($aFiltro) > 0){
			$sql .= " where ";
			$sql .= implode(" and ", $aFiltro);
		}
		
		if(count($aOrdenacao) > 0){
			$sql .= " order by ";
			$sql .= implode(",", $aOrdenacao);
		}
		try{
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = RhCargoComissaoMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.rh_cargo_comissao";
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
				".RhCargoComissaoMAP::dataToSelect()."
			from
				{$this->joinTabelas}
			where
				".RhCargoComissaoMAP::filterLike($valor);
		
		//Util::trace($sql);
		
		try{
			$this->oConexao->execute($sql);
			$aObj = [];
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[]=RhCargoComissaoMAP::rsToObj($aReg);
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