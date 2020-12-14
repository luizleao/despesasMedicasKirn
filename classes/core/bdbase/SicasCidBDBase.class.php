<?php
class SicasCidBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao) {
		try {
			$this->oConexao = $oConexao;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
		}
	}
	function inserir($oSicasCid) {
		$reg = SicasCidMAP::objToRs ( $oSicasCid );
		$aCampo = array_keys ( $reg );
		$sql = "
                insert into usersicas.sicas_cid(
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
	function alterar($oSicasCid) {
		$reg = SicasCidMAP::objToRs ( $oSicasCid );
		$sql = "
                    update 
                        usersicas.sicas_cid 
                    set
                        ";
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_cid")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode ( ",\n", $a );
		$sql .= "
                    where
                        cd_cid = {$reg['cd_cid']}";
		
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_cid")
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
	function excluir($cd_cid) {
		$sql = "
                    delete from
                        usersicas.sicas_cid 
                    where
                        cd_cid = $cd_cid";
		
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
	function get($cd_cid) {
		$sql = "
                    select 
                        ".SicasCidMAP::dataToSelect()." 
                    from
                        usersicas.sicas_cid 
				    left join usersicas.sicas_cid cid_pai
					   on (sicas_cid.cd_cid_pai = sicas_cid.cd_cid) 
                    where
                        sicas_cid.cd_cid = $cd_cid";
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->numRows () != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasCidMAP::rsToObj ( $aReg );
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	
	function getAll($aFiltro = [], $aOrdenacao = [], $qtd = NULL, $pagina = NULL){
	    if($pagina != NULL){
	        $sql = "
                   SELECT TOP($qtd) *
                      FROM(
                           SELECT
                    		row_number()OVER(ORDER BY sicas_cid.cd_cid ASC)AS row_number,
                            ".SicasCidMAP::dataToSelect()."
                        from
                            usersicas.sicas_cid 
			        left join usersicas.sicas_cid cid_pai
				       on (sicas_cid.cd_cid_pai = cid_pai.cd_cid)
                          )tb
                     where
                        row_number > ".$qtd*($pagina-1);
	    } else {
	        $sql = "SELECT
                        ".SicasCidMAP::dataToSelect()."
                    from
                        usersicas.sicas_cid 
			        left join usersicas.sicas_cid cid_pai
				       on (sicas_cid.cd_cid_pai = cid_pai.cd_cid)";
                        
            if(count($aFiltro)> 0){
                $sql .= " where ";
                $sql .= implode(" and ", $aFiltro);
            }
            
            if(count($aOrdenacao)> 0){
                $sql .= " order by ";
                $sql .= implode(",", $aOrdenacao);
            }
	    }
	    
	    //Util::trace($sql);
	    
	    try {
	        $this->oConexao->execute($sql);
	        $aObj = array();
	        if($this->oConexao->numRows()!= 0){
	            while($aReg = $this->oConexao->fetchReg()){
	                $aObj [] = SicasCidMAP::rsToObj($aReg);
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
	
	function totalColecao() {
		$sql = "select count(*) from usersicas.sicas_cid";
		try {
			$this->oConexao->execute($sql);
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
                    ".SicasCidMAP::dataToSelect()."
                from
                    usersicas.sicas_cid 
				left join usersicas.sicas_cid cid_pai
					on (sicas_cid.cd_cid_pai = sicas_cid.cd_cid)
                where
                    sicas_cid.cd_cid like '$valor'
                    or sicas_cid.desc_cid like '$valor' 
					or sicas_cid.desc_cid_abrev like '$valor' 
					or sicas_cid.cd_cid_pai like '$valor'";
		
		//Util::trace($sql);
		
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = SicasCidMAP::rsToObj ( $aReg );
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