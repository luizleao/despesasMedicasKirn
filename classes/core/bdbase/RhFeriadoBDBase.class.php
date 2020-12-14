<?php
class RhFeriadoBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao) {
		try {
			$this->oConexao = $oConexao;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
		}
	}
	function inserir($oRhFeriado) {
		$reg = RhFeriadoMAP::objToRsInsert ( $oRhFeriado );
		$aCampo = array_keys ( $reg );
		$sql = "
                insert into usersicas.rh_feriado(
                    " . implode ( ',', $aCampo ) . "
                ) 
                values(
                    :" . implode ( ", :", $aCampo ) . ")";
		// print "<pre>"; print_r($reg); print "</pre>";
		// die("<pre>$sql</pre>");
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
	function alterar($oRhFeriado) {
		$reg = RhFeriadoMAP::objToRs ( $oRhFeriado );
		$sql = "
                    update 
                        usersicas.rh_feriado 
                    set
                        ";
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_feriado")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode ( ",\n", $a );
		$sql .= "
                    where
                        cd_feriado = {$reg['cd_feriado']}";
		
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_feriado")
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
	function excluir($cd_feriado) {
		$sql = "
                    delete from
                        usersicas.rh_feriado 
                    where
                        cd_feriado = $cd_feriado";
		
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
	function get($cd_feriado) {
		$sql = "
                    select 
                        rh_feriado.cd_feriado as rh_feriado_cd_feriado,
					rh_feriado.data_feriado as rh_feriado_data_feriado,
					rh_feriado.descricao_feriado as rh_feriado_descricao_feriado,
					rh_feriado.esfera_feriado as rh_feriado_esfera_feriado 
                    from
                        usersicas.rh_feriado 
                    where
                        rh_feriado.cd_feriado = $cd_feriado";
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->numRows () != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return RhFeriadoMAP::rsToObj ( $aReg );
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
                    rh_feriado.cd_feriado as rh_feriado_cd_feriado,
                    rh_feriado.data_feriado as rh_feriado_data_feriado,
                    rh_feriado.descricao_feriado as rh_feriado_descricao_feriado,
                    rh_feriado.esfera_feriado as rh_feriado_esfera_feriado 
                from
                    usersicas.rh_feriado";
		
		if (count ( $aFiltro ) > 0) {
			$sql .= " where ";
			$sql .= implode ( " and ", $aFiltro );
		}
		
		if (count ( $aOrdenacao ) > 0) {
			$sql .= " order by ";
			$sql .= implode ( ",", $aOrdenacao );
		}
		try {
			// Util::trace($sql);
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = RhFeriadoMAP::rsToObj ( $aReg );
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
		$sql = "select count(*) from usersicas.rh_feriado";
		try {
			$this->oConexao->execute ( $sql );
			$aReg = $this->oConexao->fetchReg ();
			return ( int ) $aReg [0];
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function consultar($valor) {
		$valor = Util::formataConsultaLike ( $valor );
		
		$sql = "
                select
                    rh_feriado.cd_feriado as rh_feriado_cd_feriado,
					rh_feriado.data_feriado as rh_feriado_data_feriado,
					rh_feriado.descricao_feriado as rh_feriado_descricao_feriado,
					rh_feriado.esfera_feriado as rh_feriado_esfera_feriado 
                from
                    usersicas.rh_feriado
                where
                    rh_feriado.data_feriado like '$valor' 
					or rh_feriado.descricao_feriado like '$valor' 
					or rh_feriado.esfera_feriado like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = RhFeriadoMAP::rsToObj ( $aReg );
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