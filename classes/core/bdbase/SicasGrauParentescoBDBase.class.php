<?php
class SicasGrauParentescoBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao){
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasGrauParentesco){
		$reg = SicasGrauParentescoMAP::objToRs($oSicasGrauParentesco);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_grau_parentesco(
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
	function alterar($oSicasGrauParentesco){
		$reg = SicasGrauParentescoMAP::objToRs($oSicasGrauParentesco);
		$sql = "
                    update 
                        usersicas.sicas_grau_parentesco 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_grau_parentesco")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_grau_parentesco = {$reg['cd_grau_parentesco']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_grau_parentesco")
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
	function excluir($cd_grau_parentesco){
		$sql = "
                    delete from
                        usersicas.sicas_grau_parentesco 
                    where
                        cd_grau_parentesco = $cd_grau_parentesco";
		
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
	function get($cd_grau_parentesco){
		$sql = "
                    select 
                        ".SicasGrauParentescoMAP::dataToSelect()."
                    from
                        usersicas.sicas_grau_parentesco 
                    where
                        sicas_grau_parentesco.cd_grau_parentesco = $cd_grau_parentesco";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasGrauParentescoMAP::rsToObj($aReg);
			} else {
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
                    ".SicasGrauParentescoMAP::dataToSelect()."
                from
                    usersicas.sicas_grau_parentesco";
		
		if(count($aFiltro)> 0){
			$sql .= " where ";
			$sql .= implode(" and ", $aFiltro);
		}
		
		if(count($aOrdenacao)> 0){
			$sql .= " order by ";
			$sql .= implode(",", $aOrdenacao);
		}
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasGrauParentescoMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_grau_parentesco";
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
                    ".SicasGrauParentescoMAP::dataToSelect()."
                from
                    usersicas.sicas_grau_parentesco
                where
                    ".SicasGrauParentescoMAP::filterLike($valor);
		
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasGrauParentescoMAP::rsToObj($aReg);
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