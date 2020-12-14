<?php
class SicasConsultaMedicaCidBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao) {
		try {
			$this->oConexao = $oConexao;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
		}
	}
	function inserir($oSicasConsultaMedicaCid) {
		$reg = SicasConsultaMedicaCidMAP::objToRs($oSicasConsultaMedicaCid);
		$aCampo = array_keys ( $reg );
		$sql = "
                insert into usersicas.sicas_consulta_medica_cid(
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
			return true;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function alterar($oSicasConsultaMedicaCid) {
		$reg = SicasConsultaMedicaCidMAP::objToRs ( $oSicasConsultaMedicaCid );
		$sql = "
                    update 
                        usersicas.sicas_consulta_medica_cid 
                    set
                        ";
		foreach ( $reg as $cv => $vl ) {
			
			$a [] = "$cv = :$cv";
		}
		$sql .= implode ( ",\n", $a );
		$sql .= "
                    where
                        ";
		
		foreach ( $reg as $cv => $vl ) {
			
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
	function excluir() {
		$sql = "
                    delete from
                        usersicas.sicas_consulta_medica_cid 
                    where
                        ";
		
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
	function get(){
		$sql = "
                    select 
                        ".SicasConsultaMedicaCidMAP::dataToSelect()."
                    from
                        usersicas.sicas_consulta_medica_cid 
    				left join usersicas.sicas_cid 
    					on (sicas_consulta_medica_cid.cd_cid = sicas_cid.cd_cid)
                    left join usersicas.sicas_consulta_medica 
    					on (sicas_consulta_medica_cid.cd_consulta_medica = sicas_consulta_medica.cd_consulta_medica) 
                    where
                        sicas_cid.cd_cid = '$cd_cid'
                        and sicas_consulta_medica.cd_consulta_medica = $cd_consulta_medica";
		try {
			$this->oConexao->execute($sql);
			if ($this->oConexao->numRows() != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasConsultaMedicaCidMAP::rsToObj ( $aReg );
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
                    ".SicasConsultaMedicaCidMAP::dataToSelect()." 
                from
                    usersicas.sicas_consulta_medica_cid 
				left join usersicas.sicas_cid 
    					on (sicas_consulta_medica_cid.cd_cid = sicas_cid.cd_cid)
                left join usersicas.sicas_consulta_medica 
					on (sicas_consulta_medica_cid.cd_consulta_medica = sicas_consulta_medica.cd_consulta_medica)";
		
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
					$aObj [] = SicasConsultaMedicaCidMAP::rsToObj ( $aReg );
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
		$sql = "select count(*) from usersicas.sicas_consulta_medica_cid";
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
                    sicas_consulta_medica_cid.cd_cid as sicas_consulta_medica_cid_cd_cid,
					sicas_consulta_medica_cid.cd_consulta_medica as sicas_consulta_medica_cid_cd_consulta_medica,
					sicas_cid.cd_cid as sicas_cid_cd_cid,
					sicas_cid.desc_cid as sicas_cid_desc_cid,
					sicas_cid.desc_cid_abrev as sicas_cid_desc_cid_abrev,
					sicas_cid.cd_cid_pai as sicas_cid_cd_cid_pai 
                from
                    usersicas.sicas_consulta_medica_cid 
				left join usersicas.sicas_cid 
					on (sicas_consulta_medica_cid.cd_cid = sicas_cid.cd_cid)
                where
                    sicas_consulta_medica_cid.cd_cid like '$valor' 
					or sicas_consulta_medica_cid.cd_consulta_medica like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = SicasConsultaMedicaCidMAP::rsToObj ( $aReg );
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