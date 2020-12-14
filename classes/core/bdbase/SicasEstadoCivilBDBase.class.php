<?php
class SicasEstadoCivilBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao) {
		try {
			$this->oConexao = $oConexao;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
		}
	}
	function inserir($oSicasEstadoCivil) {
		$reg = SicasEstadoCivilMAP::objToRs ( $oSicasEstadoCivil );
		$aCampo = array_keys ( $reg );
		$sql = "
                insert into usersicas.sicas_estado_civil(
                    " . implode ( ',', $aCampo ) . "
                ) 
                values(
                    :" . implode ( ", :", $aCampo ) . ")";
		
		foreach ( $reg as $cv => $vl )
			$regTemp [":$cv"] = ($vl == '') ? NULL : $vl;
		
		try {
			$this->oConexao->executePrepare ( $sql, $regTemp );
			if ($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return $this->oConexao->lastID ();
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function alterar($oSicasEstadoCivil) {
		$reg = SicasEstadoCivilMAP::objToRs ( $oSicasEstadoCivil );
		$sql = "
                    update 
                        usersicas.sicas_estado_civil 
                    set
                        ";
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_estado_civil")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode ( ",\n", $a );
		$sql .= "
                    where
                        cd_estado_civil = {$reg['cd_estado_civil']}";
		
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_estado_civil")
				continue;
			$regTemp [":$cv"] = ($vl == '') ? NULL : $vl;
		}
		try {
			$this->oConexao->executePrepare ( $sql, $regTemp );
			if ($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function excluir($cd_estado_civil) {
		$sql = "
                    delete from
                        usersicas.sicas_estado_civil 
                    where
                        cd_estado_civil = $cd_estado_civil";
		
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function get($cd_estado_civil) {
		$sql = "
                    select 
                        sicas_estado_civil.cd_estado_civil as sicas_estado_civil_cd_estado_civil,
					sicas_estado_civil.nm_estado_civil as sicas_estado_civil_nm_estado_civil,
					sicas_estado_civil.status as sicas_estado_civil_status 
                    from
                        usersicas.sicas_estado_civil 
                    where
                        sicas_estado_civil.cd_estado_civil = $cd_estado_civil";
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->numRows () != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasEstadoCivilMAP::rsToObj ( $aReg );
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function getAll($aFiltro = [], $aOrdenacao = []) {
		$sql = "
                select
                    sicas_estado_civil.cd_estado_civil as sicas_estado_civil_cd_estado_civil,
					sicas_estado_civil.nm_estado_civil as sicas_estado_civil_nm_estado_civil,
					sicas_estado_civil.status as sicas_estado_civil_status 
                from
                    usersicas.sicas_estado_civil";
		
		if (count ( $aFiltro ) > 0) {
			$sql .= " where ";
			$sql .= implode ( " and ", $aFiltro );
		}
		
		if (count ( $aOrdenacao ) > 0) {
			$sql .= " order by ";
			$sql .= implode ( ",", $aOrdenacao );
		}
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = SicasEstadoCivilMAP::rsToObj ( $aReg );
				}
				return $aObj;
			} else {
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function totalColecao() {
		$sql = "select count(*) from usersicas.sicas_estado_civil";
		try {
			$this->oConexao->execute ( $sql );
			$aReg = $this->oConexao->fetchReg ();
			return ( int ) $aReg [''];
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function consultar($valor) {
		$valor = Util::formataConsultaLike ( $valor );
		
		$sql = "
                select
                    sicas_estado_civil.cd_estado_civil as sicas_estado_civil_cd_estado_civil,
					sicas_estado_civil.nm_estado_civil as sicas_estado_civil_nm_estado_civil,
					sicas_estado_civil.status as sicas_estado_civil_status 
                from
                    usersicas.sicas_estado_civil
                where
                    sicas_estado_civil.nm_estado_civil like '$valor' 
					or sicas_estado_civil.status like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = SicasEstadoCivilMAP::rsToObj ( $aReg );
				}
				return $aObj;
			} else {
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
}