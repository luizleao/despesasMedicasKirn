<?php
class RhCargoBDBase{
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao){
		try{
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oRhCargo){
		$reg = RhCargoMAP::objToRs($oRhCargo);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.rh_cargo(
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
	function alterar($oRhCargo){
		$reg = RhCargoMAP::objToRs($oRhCargo);
		$sql = "
                    update 
                        usersicas.rh_cargo 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_cargo")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_cargo ={$reg['cd_cargo']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_cargo")
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
	function excluir($cd_cargo){
		$sql = "
                    delete from
                        usersicas.rh_cargo 
                    where
                        cd_cargo = $cd_cargo";
		
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
	function get($cd_cargo){
		$sql = "
                    select 
                        rh_cargo.cd_cargo as rh_cargo_cd_cargo,
                        rh_cargo.descricao_cargo as rh_cargo_descricao_cargo,
                        rh_cargo.descricao_cargo_abrev as rh_cargo_descricao_cargo_abrev,
                        rh_cargo.num_siape_cargo as rh_cargo_num_siape_cargo,
                        rh_cargo.status as rh_cargo_status 
                    from
                        usersicas.rh_cargo 
                    where
                        rh_cargo.cd_cargo = $cd_cargo";
		try{
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return RhCargoMAP::rsToObj($aReg);
			} else{
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function getAll($aFiltro = NULL, $aOrdenacao = NULL){
		$sql = "
                select
                    rh_cargo.cd_cargo as rh_cargo_cd_cargo,
					rh_cargo.descricao_cargo as rh_cargo_descricao_cargo,
					rh_cargo.descricao_cargo_abrev as rh_cargo_descricao_cargo_abrev,
					rh_cargo.num_siape_cargo as rh_cargo_num_siape_cargo,
					rh_cargo.status as rh_cargo_status 
                from
                    usersicas.rh_cargo";
		
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
					$aObj [] = RhCargoMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.rh_cargo";
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
                    rh_cargo.cd_cargo as rh_cargo_cd_cargo,
                    rh_cargo.descricao_cargo as rh_cargo_descricao_cargo,
                    rh_cargo.descricao_cargo_abrev as rh_cargo_descricao_cargo_abrev,
                    rh_cargo.num_siape_cargo as rh_cargo_num_siape_cargo,
                    rh_cargo.status as rh_cargo_status 
                from
                    usersicas.rh_cargo
                where
                    rh_cargo.descricao_cargo like '$valor' 
                    or rh_cargo.descricao_cargo_abrev like '$valor' 
                    or rh_cargo.num_siape_cargo like '$valor' 
                    or rh_cargo.status like '$valor'";
		// print "<pre>$sql</pre>";
		try{
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = RhCargoMAP::rsToObj($aReg);
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