<?php
class SicasPessoaBDBase {
	public $oConexao;
	public $msg;
	
	function __construct(Conexao $oConexao){
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	
	function inserir($oSicasPessoa){
		$reg = SicasPessoaMAP::objToRsInsert($oSicasPessoa);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_pessoa(
                    ".implode(',', $aCampo)."
               )
                values(
                    :".implode(", :", $aCampo).")";
		
		foreach($reg as $cv => $vl)
			$regTemp [":$cv"] = ($vl == '') ? NULL : $vl;
		
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
	function alterar($oSicasPessoa){
		$reg = SicasPessoaMAP::objToRs($oSicasPessoa);
		//print "<pre>"; print_r($reg); print "</pre>";
		$sql = "
                update 
                	usersicas.sicas_pessoa 
                set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_pessoa")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_pessoa = {$reg['cd_pessoa']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_pessoa")
				continue;
			$regTemp [":$cv"] =($vl == '')? NULL : $vl;
		}
		try {
			//print "<pre>$sql</pre>"; //exit;
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
	function excluir($cd_pessoa){
		$sql = "
                delete from
                	usersicas.sicas_pessoa 
               	where
                	cd_pessoa = $cd_pessoa";
		
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
	function get($cd_pessoa){
		$sql = "
				select 
					".SicasPessoaMAP::dataToSelect()." 
				from
					usersicas.sicas_pessoa 
				left join usersicas.sicas_estado_civil 
					on (sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
				left join usersicas.sicas_pessoa_categoria 
					on (sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
				where
					sicas_pessoa.cd_pessoa = $cd_pessoa";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasPessoaMAP::rsToObj($aReg);
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function getAll($aFiltro=[], $aOrdenacao=[], $qtde=NULL, $pagina=NULL){
		$sql = "
                select
                    ".SicasPessoaMAP::dataToSelect()." 
                from
                    usersicas.sicas_pessoa 
				left join usersicas.sicas_estado_civil 
					on(sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
				left join usersicas.sicas_pessoa_categoria 
					on(sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)";
		
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
					$aObj[] = SicasPessoaMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_pessoa";
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
                    ".SicasPessoaMAP::dataToSelect()." 
                from
                    usersicas.sicas_pessoa 
                left join usersicas.sicas_estado_civil 
                    on(sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
                left join usersicas.sicas_pessoa_categoria 
                    on(sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
                where
                    ".SicasPessoaMAP::filterLike($valor)."
				order by
					sicas_pessoa.nm_pessoa";
		
		//Util::trace($sql);
		
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasPessoaMAP::rsToObj($aReg);
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