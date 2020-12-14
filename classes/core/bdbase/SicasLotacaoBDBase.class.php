<?php
class SicasLotacaoBDBase {
	public $oConexao;
	public $msg;
	public $joinTabelas;
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = "usersicas.sicas_lotacao
                        left join usersicas.sicas_lotacao lotacao_pai
                            on (lotacao_pai.cd_lotacao = sicas_lotacao.cd_lotacao_pai)";
	    
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasLotacao){
		$reg = SicasLotacaoMAP::objToRsInsert($oSicasLotacao);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_lotacao(
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
	function alterar($oSicasLotacao){
		$reg = SicasLotacaoMAP::objToRs($oSicasLotacao);
		$sql = "
                update 
                    usersicas.sicas_lotacao 
                set
                    ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_lotacao")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_lotacao = {$reg['cd_lotacao']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_lotacao")
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
	function excluir($cd_lotacao){
		$sql = "
                    delete from
                        usersicas.sicas_lotacao 
                    where
                        cd_lotacao = $cd_lotacao";
		
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
	function get($cd_lotacao){
		$sql = "
                    select 
	                    ".SicasLotacaoMAP::dataToSelect()." 
                    from
                        ".$this->joinTabelas." 
                    where
                        sicas_lotacao.cd_lotacao = $cd_lotacao";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasLotacaoMAP::rsToObj($aReg);
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
                    ".SicasLotacaoMAP::dataToSelect()." 
                from
                    ".$this->joinTabelas;
		
		if(count($aFiltro)> 0){
			$sql .= " where ";
			$sql .= implode(" and ", $aFiltro);
		}
		
		if(count($aOrdenacao)> 0){
			$sql .= " order by ";
			$sql .= implode(",", $aOrdenacao);
		}
		
		//Util::trace($sql);
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasLotacaoMAP::rsToObj($aReg);
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
		$sql = "select count(*)from usersicas.sicas_lotacao";
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
                    ".SicasLotacaoMAP::dataToSelect()."  
                from
                    ".$this->joinTabelas."
                where
                	".SicasLotacaoMAP::filterLike($valor);
		
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasLotacaoMAP::rsToObj($aReg);
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