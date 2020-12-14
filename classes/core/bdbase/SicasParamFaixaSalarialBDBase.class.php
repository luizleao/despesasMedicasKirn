<?php
class SicasParamFaixaSalarialBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao) {
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e) {
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasParamFaixaSalarial) {
		$reg = SicasParamFaixaSalarialMAP::objToRs($oSicasParamFaixaSalarial);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_param_faixa_salarial(
                    " . implode(',', $aCampo) . "
               ) 
                values(
                    :" . implode(", :", $aCampo) . ")";
		
		foreach($reg as $cv => $vl)
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
		
		try {
			$this->oConexao->executePrepare($sql, $regTemp);
			if($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return $this->oConexao->lastID();
		} catch(PDOException $e) {
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function alterar($oSicasParamFaixaSalarial) {
		$reg = SicasParamFaixaSalarialMAP::objToRs($oSicasParamFaixaSalarial);
		$sql = "
                    update 
                        usersicas.sicas_param_faixa_salarial 
                    set
                        ";
		foreach($reg as $cv => $vl) {
			if($cv == "cd_param_faixa_sal")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_param_faixa_sal = {$reg['cd_param_faixa_sal']}";
		
		foreach($reg as $cv => $vl) {
			if($cv == "cd_param_faixa_sal")
				continue;
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
		}
		try {
			$this->oConexao->executePrepare($sql, $regTemp);
			if($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch(PDOException $e) {
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function excluir($cd_param_faixa_sal) {
		$sql = "
                delete from
                    usersicas.sicas_param_faixa_salarial 
                where
                    cd_param_faixa_sal = $cd_param_faixa_sal";
		
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch(PDOException $e) {
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function get($cd_param_faixa_sal) {
		$sql = "
                    select 
                        ".SicasParamFaixaSalarialMAP::dataToSelect()." 
                    from
                        usersicas.sicas_param_faixa_salarial 
                    where
                        sicas_param_faixa_salarial.cd_param_faixa_sal = $cd_param_faixa_sal";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0) {
				$aReg = $this->oConexao->fetchReg();
				return SicasParamFaixaSalarialMAP::rsToObj($aReg);
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e) {
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function getAll($aFiltro=[], $aOrdenacao=[]) {
		$sql = "
                select
                    ".SicasParamFaixaSalarialMAP::dataToSelect()." 
                from
                    usersicas.sicas_param_faixa_salarial";
		
		if(count($aFiltro) > 0) {
			$sql .= " where ";
			$sql .= implode(" and ", $aFiltro);
		}
		
		if(count($aOrdenacao) > 0) {
			$sql .= " order by ";
			$sql .= implode(",", $aOrdenacao);
		}
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0) {
				while($aReg = $this->oConexao->fetchReg()) {
					$aObj[] = SicasParamFaixaSalarialMAP::rsToObj($aReg);
				}
				return $aObj;
			} else {
				return false;
			}
		} catch(PDOException $e) {
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function totalColecao() {
		$sql = "select count(*) from usersicas.sicas_param_faixa_salarial";
		try {
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			return (int)$aReg[''];
		} catch(PDOException $e) {
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function consultar($valor) {
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    ".SicasParamFaixaSalarialMAP::dataToSelect()." 
                from
                    usersicas.sicas_param_faixa_salarial
                where
                    ".SicasParamFaixaSalarialMAP::filterLike($valor);
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0) {
				while($aReg = $this->oConexao->fetchReg()) {
					$aObj [] = SicasParamFaixaSalarialMAP::rsToObj($aReg);
				}
				return $aObj;
			} else {
				return false;
			}
		} catch(PDOException $e) {
			$this->msg = $e->getMessage();
			return false;
		}
	}
}