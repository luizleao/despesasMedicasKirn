<?php
class SicasTipoAtendimentoBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao) {
		try {
			$this->oConexao = $oConexao;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
		}
	}
	function inserir($oSicasTipoAtendimento) {
		$reg = SicasTipoAtendimentoMAP::objToRs ( $oSicasTipoAtendimento );
		$aCampo = array_keys ( $reg );
		$sql = "
                insert into usersicas.sicas_tipo_atendimento(
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
	function alterar($oSicasTipoAtendimento) {
		$reg = SicasTipoAtendimentoMAP::objToRs ( $oSicasTipoAtendimento );
		$sql = "
                    update 
                        usersicas.sicas_tipo_atendimento 
                    set
                        ";
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_tipo_atendimento")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode ( ",\n", $a );
		$sql .= "
                    where
                        cd_tipo_atendimento = {$reg['cd_tipo_atendimento']}";
		
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_tipo_atendimento")
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
	function excluir($cd_tipo_atendimento) {
		$sql = "
                    delete from
                        usersicas.sicas_tipo_atendimento 
                    where
                        cd_tipo_atendimento = $cd_tipo_atendimento";
		
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
	function get($cd_tipo_atendimento) {
		$sql = "
                    select 
                        sicas_tipo_atendimento.cd_tipo_atendimento as sicas_tipo_atendimento_cd_tipo_atendimento,
					sicas_tipo_atendimento.nm_tipo_atendimento as sicas_tipo_atendimento_nm_tipo_atendimento,
					sicas_tipo_atendimento.fl_atendimento as sicas_tipo_atendimento_fl_atendimento,
					sicas_tipo_atendimento.pericia as sicas_tipo_atendimento_pericia,
					sicas_tipo_atendimento.status as sicas_tipo_atendimento_status 
                    from
                        usersicas.sicas_tipo_atendimento 
                    where
                        sicas_tipo_atendimento.cd_tipo_atendimento = $cd_tipo_atendimento";
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->numRows () != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasTipoAtendimentoMAP::rsToObj ( $aReg );
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function getAll($aFiltro = NULL, $aOrdenacao = NULL) {
		$sql = "
                select
                    sicas_tipo_atendimento.cd_tipo_atendimento as sicas_tipo_atendimento_cd_tipo_atendimento,
					sicas_tipo_atendimento.nm_tipo_atendimento as sicas_tipo_atendimento_nm_tipo_atendimento,
					sicas_tipo_atendimento.fl_atendimento as sicas_tipo_atendimento_fl_atendimento,
					sicas_tipo_atendimento.pericia as sicas_tipo_atendimento_pericia,
					sicas_tipo_atendimento.status as sicas_tipo_atendimento_status 
                from
                    usersicas.sicas_tipo_atendimento";
		
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
					$aObj [] = SicasTipoAtendimentoMAP::rsToObj ( $aReg );
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
		$sql = "select count(*) from usersicas.sicas_tipo_atendimento";
		try {
			$this->oConexao->execute ( $sql );
			$aReg = $this->oConexao->fetchReg ();
			return (int) $aReg [''];
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function consultar($valor) {
		$valor = Util::formataConsultaLike ( $valor );
		
		$sql = "
                select
                    sicas_tipo_atendimento.cd_tipo_atendimento as sicas_tipo_atendimento_cd_tipo_atendimento,
					sicas_tipo_atendimento.nm_tipo_atendimento as sicas_tipo_atendimento_nm_tipo_atendimento,
					sicas_tipo_atendimento.fl_atendimento as sicas_tipo_atendimento_fl_atendimento,
					sicas_tipo_atendimento.pericia as sicas_tipo_atendimento_pericia,
					sicas_tipo_atendimento.status as sicas_tipo_atendimento_status 
                from
                    usersicas.sicas_tipo_atendimento
                where
                    sicas_tipo_atendimento.nm_tipo_atendimento like '$valor' 
					or sicas_tipo_atendimento.fl_atendimento like '$valor' 
					or sicas_tipo_atendimento.pericia like '$valor' 
					or sicas_tipo_atendimento.status like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = SicasTipoAtendimentoMAP::rsToObj ( $aReg );
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