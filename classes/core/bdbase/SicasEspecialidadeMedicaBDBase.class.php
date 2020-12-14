<?php
class SicasEspecialidadeMedicaBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao){
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasEspecialidadeMedica){
		$reg = SicasEspecialidadeMedicaMAP::objToRsInsert($oSicasEspecialidadeMedica);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_especialidade_medica(
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
	function alterar($oSicasEspecialidadeMedica){
		$reg = SicasEspecialidadeMedicaMAP::objToRs($oSicasEspecialidadeMedica);
		$sql = "
                    update 
                        usersicas.sicas_especialidade_medica 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_especialidade_medica")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_especialidade_medica = {$reg['cd_especialidade_medica']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_especialidade_medica")
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
	function excluir($cd_especialidade_medica){
		$sql = "
                    delete from
                        usersicas.sicas_especialidade_medica 
                    where
                        cd_especialidade_medica = $cd_especialidade_medica";
		
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
	function get($cd_especialidade_medica){
		$sql = "
                    select 
                        sicas_especialidade_medica.cd_especialidade_medica as sicas_especialidade_medica_cd_especialidade_medica,
					sicas_especialidade_medica.nm_especialidade as sicas_especialidade_medica_nm_especialidade,
					sicas_especialidade_medica.status as sicas_especialidade_medica_status 
                    from
                        usersicas.sicas_especialidade_medica 
                    where
                        sicas_especialidade_medica.cd_especialidade_medica = $cd_especialidade_medica";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasEspecialidadeMedicaMAP::rsToObj($aReg);
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
                    sicas_especialidade_medica.cd_especialidade_medica as sicas_especialidade_medica_cd_especialidade_medica,
					sicas_especialidade_medica.nm_especialidade as sicas_especialidade_medica_nm_especialidade,
					sicas_especialidade_medica.status as sicas_especialidade_medica_status 
                from
                    usersicas.sicas_especialidade_medica";
		
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
					$aObj [] = SicasEspecialidadeMedicaMAP::rsToObj($aReg);
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
		$sql = "select count(*)from usersicas.sicas_especialidade_medica";
		try {
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			return(int)$aReg[''];
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function consultar($valor){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    sicas_especialidade_medica.cd_especialidade_medica as sicas_especialidade_medica_cd_especialidade_medica,
					sicas_especialidade_medica.nm_especialidade as sicas_especialidade_medica_nm_especialidade,
					sicas_especialidade_medica.status as sicas_especialidade_medica_status 
                from
                    usersicas.sicas_especialidade_medica
                where
                    sicas_especialidade_medica.nm_especialidade like '$valor' 
					or sicas_especialidade_medica.status like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasEspecialidadeMedicaMAP::rsToObj($aReg);
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