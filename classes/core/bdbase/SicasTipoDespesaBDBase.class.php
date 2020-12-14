<?php
class SicasTipoDespesaBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao){
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasTipoDespesa){
		$reg = SicasTipoDespesaMAP::objToRs($oSicasTipoDespesa);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_tipo_despesa(
                    " . implode(',', $aCampo) . "
               ) 
                values(
                    :" . implode(", :", $aCampo) . ")";
		
		foreach($reg as $cv => $vl)
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
		
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
	function alterar($oSicasTipoDespesa){
		$reg = SicasTipoDespesaMAP::objToRs($oSicasTipoDespesa);
		$sql = "
                    update 
                        usersicas.sicas_tipo_despesa 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_tipo_despesa")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_tipo_despesa = {$reg['cd_tipo_despesa']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_tipo_despesa")
				continue;
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
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
	function excluir($cd_tipo_despesa){
		$sql = "
                    delete from
                        usersicas.sicas_tipo_despesa 
                    where
                        cd_tipo_despesa = $cd_tipo_despesa";
		
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
	function get($cd_tipo_despesa){
		$sql = "
                    select 
                        sicas_tipo_despesa.cd_tipo_despesa as sicas_tipo_despesa_cd_tipo_despesa,
    					sicas_tipo_despesa.nm_despesa as sicas_tipo_despesa_nm_despesa,
    					sicas_tipo_despesa.credenciado as sicas_tipo_despesa_credenciado,
    					sicas_tipo_despesa.status as sicas_tipo_despesa_status 
                    from
                        usersicas.sicas_tipo_despesa 
                    where
                        sicas_tipo_despesa.cd_tipo_despesa = $cd_tipo_despesa";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasTipoDespesaMAP::rsToObj($aReg);
			} else {
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
                    sicas_tipo_despesa.cd_tipo_despesa as sicas_tipo_despesa_cd_tipo_despesa,
					sicas_tipo_despesa.nm_despesa as sicas_tipo_despesa_nm_despesa,
					sicas_tipo_despesa.credenciado as sicas_tipo_despesa_credenciado,
					sicas_tipo_despesa.status as sicas_tipo_despesa_status 
                from
                    usersicas.sicas_tipo_despesa";
		
		if(count($aFiltro) > 0){
			$sql .= " where ";
			$sql .= implode(" and ", $aFiltro);
		}
		
		if(count($aOrdenacao) > 0){
			$sql .= " order by ";
			$sql .= implode(",", $aOrdenacao);
		}
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasTipoDespesaMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_tipo_despesa";
		try {
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			return(int) $aReg [''];
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function consultar($valor){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    sicas_tipo_despesa.cd_tipo_despesa as sicas_tipo_despesa_cd_tipo_despesa,
					sicas_tipo_despesa.nm_despesa as sicas_tipo_despesa_nm_despesa,
					sicas_tipo_despesa.credenciado as sicas_tipo_despesa_credenciado,
					sicas_tipo_despesa.status as sicas_tipo_despesa_status 
                from
                    usersicas.sicas_tipo_despesa
                where
                    sicas_tipo_despesa.nm_despesa like '$valor' 
					or sicas_tipo_despesa.credenciado like '$valor' 
					or sicas_tipo_despesa.status like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasTipoDespesaMAP::rsToObj($aReg);
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