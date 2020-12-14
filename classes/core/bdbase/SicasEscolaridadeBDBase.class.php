<?php
class SicasEscolaridadeBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao) {
		try {
			$this->oConexao = $oConexao;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
		}
	}
	function inserir($oSicasEscolaridade) {
		$reg = SicasEscolaridadeMAP::objToRsInsert( $oSicasEscolaridade );
		$aCampo = array_keys ( $reg );
		$sql = "
                insert into usersicas.sicas_escolaridade(
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
	function alterar($oSicasEscolaridade) {
		$reg = SicasEscolaridadeMAP::objToRs ( $oSicasEscolaridade );
		$sql = "
                    update 
                        usersicas.sicas_escolaridade 
                    set
                        ";
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_escolaridade")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode ( ",\n", $a );
		$sql .= "
                    where
                        cd_escolaridade = {$reg['cd_escolaridade']}";
		
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_escolaridade")
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
	function excluir($cd_escolaridade) {
		$sql = "
                    delete from
                        usersicas.sicas_escolaridade 
                    where
                        cd_escolaridade = $cd_escolaridade";
		
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
	function get($cd_escolaridade) {
		$sql = "
                    select 
                        sicas_escolaridade.cd_escolaridade as sicas_escolaridade_cd_escolaridade,
					sicas_escolaridade.nm_escolaridade as sicas_escolaridade_nm_escolaridade,
					sicas_escolaridade.status as sicas_escolaridade_status 
                    from
                        usersicas.sicas_escolaridade 
                    where
                        sicas_escolaridade.cd_escolaridade = $cd_escolaridade";
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->numRows () != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasEscolaridadeMAP::rsToObj ( $aReg );
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function getAll($aFiltro=[], $aOrdenacao=[]) {
		$sql = "
                select
                    sicas_escolaridade.cd_escolaridade as sicas_escolaridade_cd_escolaridade,
					sicas_escolaridade.nm_escolaridade as sicas_escolaridade_nm_escolaridade,
					sicas_escolaridade.status as sicas_escolaridade_status 
                from
                    usersicas.sicas_escolaridade";
		
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
					$aObj[] = SicasEscolaridadeMAP::rsToObj ( $aReg );
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
		$sql = "select count(*) from usersicas.sicas_escolaridade";
		try {
			$this->oConexao->execute ( $sql );
			$aReg = $this->oConexao->fetchReg ();
			return (int)$aReg[''];
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function consultar($valor) {
		$valor = Util::formataConsultaLike ( $valor );
		
		$sql = "
                select
                    sicas_escolaridade.cd_escolaridade as sicas_escolaridade_cd_escolaridade,
					sicas_escolaridade.nm_escolaridade as sicas_escolaridade_nm_escolaridade,
					sicas_escolaridade.status as sicas_escolaridade_status 
                from
                    usersicas.sicas_escolaridade
                where
                    sicas_escolaridade.nm_escolaridade like '$valor' 
					or sicas_escolaridade.status like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = SicasEscolaridadeMAP::rsToObj ( $aReg );
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