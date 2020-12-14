<?php
class SicasDependenteBDBase {
	public $oConexao;
	public $msg;
	public $joinTabelas;
	function __construct(Conexao $oConexao){
		try {
			$this->oConexao = $oConexao;
			$this->joinTabelas = "
                                 usersicas.sicas_dependente 
                            left join usersicas.sicas_pessoa 
                                on(sicas_dependente.cd_pessoa = sicas_pessoa.cd_pessoa)
                            left join usersicas.sicas_servidor 
                                on(sicas_dependente.cd_servidor = sicas_servidor.cd_servidor)
                            left join usersicas.sicas_pessoa pessoa_servidor 
                                on(sicas_servidor.cd_pessoa = pessoa_servidor.cd_pessoa)
                            left join usersicas.sicas_lotacao 
                                on(sicas_servidor.cd_lotacao = sicas_lotacao.cd_lotacao)
                            left join usersicas.sicas_lotacao lotacao_pai 
                                on(lotacao_pai.cd_lotacao = sicas_lotacao.cd_lotacao_pai)
                            left join usersicas.rh_cargo 
                                on(sicas_servidor.cd_cargo = rh_cargo.cd_cargo)
                            left join usersicas.sicas_pessoa_categoria categoria_servidor 
                                on(sicas_servidor.cd_categoria = categoria_servidor.cd_categoria)
                            left join usersicas.sicas_pessoa_categoria 
                                on(sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
                            left join usersicas.sicas_estado_civil 
                                on(sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
                            left join usersicas.sicas_grau_parentesco 
                                on(sicas_dependente.cd_grau_parentesco = sicas_grau_parentesco.cd_grau_parentesco)
                            left join usersicas.sicas_escolaridade 
                                on(sicas_dependente.cd_escolaridade = sicas_escolaridade.cd_escolaridade)";
			
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasDependente){
		$reg = SicasDependenteMAP::objToRsInsert($oSicasDependente);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_dependente(
                    " . implode(',', $aCampo) . "
               ) 
                values(
                    :" . implode(", :", $aCampo) . ")";
		
		foreach($reg as $cv => $vl)
			$regTemp[":$cv"] =($vl == '') ? NULL : $vl;
		
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
	function alterar($oSicasDependente){
		$reg = SicasDependenteMAP::objToRs($oSicasDependente);
		$sql = "
                    update 
                        usersicas.sicas_dependente 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_dependente")
				continue;
			$a[] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_dependente = {$reg['cd_dependente']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_dependente")
				continue;
			$regTemp[":$cv"] =($vl == '') ? NULL : $vl;
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
	function excluir($cd_dependente){
		$sql = "
                    delete from
                        usersicas.sicas_dependente 
                    where
                        cd_dependente = $cd_dependente";
		
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
	
	function get($cd_dependente){
		$sql = "
				select 
					".SicasDependenteMAP::dataToSelect()." 
                from
                    ".$this->joinTabelas." 
                where
                    sicas_dependente.cd_dependente = $cd_dependente";
    	try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasDependenteMAP::rsToObj($aReg);
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
					".SicasDependenteMAP::dataToSelect()." 
                from
                    ".$this->joinTabelas;
		
		if(count($aFiltro) > 0){
			$sql .= " where ";
			$sql .= implode(" and ", $aFiltro);
		}
		
		if(count($aOrdenacao) > 0){
			$sql .= " order by ";
			$sql .= implode(",", $aOrdenacao);
		}
		
		//Util::trace($sql);
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasDependenteMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_dependente";
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
					".SicasDependenteMAP::dataToSelect()." 
                from
                    ".$this->joinTabelas."
                where
                    ".SicasDependenteMAP::filterLike($valor);
		//Util::trace($sql);
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasDependenteMAP::rsToObj($aReg);
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