<?php
class RhRamalBDBase {
    public $oConexao;
    public $msg;

    function __construct(Conexao $oConexao){
        try{
            $this->oConexao = $oConexao;
        } 
        catch (PDOException $e){
            $this->msg = $e->getMessage();
        }
    }
	
    function inserir($oRhRamal){
		$reg = RhRamalMAP::objToRsInsert($oRhRamal);
		$aCampo = array_keys($reg);
		$sql = "
				insert into usersicas.rh_ramal(
					".implode(',', $aCampo)."
				)
				values(
					:".implode(", :", $aCampo).")";

		foreach($reg as $cv=>$vl)
			$regTemp[":$cv"] = ($vl=='') ? NULL : $vl;

		try{
			//Util::trace($sql);
			//Util::trace($regTemp);
			
			$this->oConexao->executePrepare($sql, $regTemp);
			if($this->oConexao->msg != ""){
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return $this->oConexao->lastID();
		}
		catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function alterar($oRhRamal){
    	$reg = RhRamalMAP::objToRs($oRhRamal);
        $sql = "
                update 
                    usersicas.rh_ramal 
                set
                    ";
        foreach($reg as $cv=>$vl){
            if($cv == "cd_ramal") continue;
            $a[] = "$cv = :$cv";
        }
        $sql .= implode(",\n", $a);
        $sql .= "
                where
                    cd_ramal = {$reg['cd_ramal']}";

        foreach($reg as $cv=>$vl){
            if($cv == "cd_ramal") continue;
            $regTemp[":$cv"] = ($vl=='') ? NULL : $vl;
        }
        try{
            $this->oConexao->executePrepare($sql, $regTemp);
            if($this->oConexao->msg != ""){
                $this->msg = $this->oConexao->msg;
                return false;
            }
            return true;
        }
        catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
	}
	
	function excluir($cd_ramal){
        $sql = "
                delete from
                    usersicas.rh_ramal 
                where
                    cd_ramal = $cd_ramal";

        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->msg != ""){
                $this->msg = $this->oConexao->msg;
                return false;
            }
            return true;
        }
        catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
	}
	
	function get($cd_ramal){
        $sql = "
                select 
					rh_ramal.cd_ramal as rh_ramal_cd_ramal,
					rh_ramal.cd_lotacao as rh_ramal_cd_lotacao,
					rh_ramal.ramal as rh_ramal_ramal,
					rh_ramal.descricao as rh_ramal_descricao,
					sicas_lotacao.cd_lotacao as sicas_lotacao_cd_lotacao,
					sicas_lotacao.sigla as sicas_lotacao_sigla,
					sicas_lotacao.cd_siged as sicas_lotacao_cd_siged,
					sicas_lotacao.nm_lotacao as sicas_lotacao_nm_lotacao,
					sicas_lotacao.status as sicas_lotacao_status 
                from
					usersicas.rh_ramal 
				left join usersicas.sicas_lotacao 
					on (rh_ramal.cd_lotacao = sicas_lotacao.cd_lotacao) 
                where
					rh_ramal.cd_ramal = $cd_ramal";
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $aReg = $this->oConexao->fetchReg();
                return RhRamalMAP::rsToObj($aReg);
            } else {
                $this->msg = "Nenhum registro encontrado!";
                return false;
            }
        }
        catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
	}
	
    function getAll($aFiltro = NULL, $aOrdenacao = NULL){
        $sql = "
				select
					rh_ramal.cd_ramal as rh_ramal_cd_ramal,
					rh_ramal.cd_lotacao as rh_ramal_cd_lotacao,
					rh_ramal.ramal as rh_ramal_ramal,
					rh_ramal.descricao as rh_ramal_descricao,
					sicas_lotacao.sigla as sicas_lotacao_sigla,
					sicas_lotacao.cd_siged as sicas_lotacao_cd_siged,
					sicas_lotacao.nm_lotacao as sicas_lotacao_nm_lotacao,
					sicas_lotacao.status as sicas_lotacao_status 
				from
					usersicas.rh_ramal 
				left join usersicas.sicas_lotacao 
					on (rh_ramal.cd_lotacao = sicas_lotacao.cd_lotacao)";
        
        if(count($aFiltro)>0){
            $sql .= " where ";
            $sql .= implode(" and ", $aFiltro);
        }
        
        if(count($aOrdenacao)>0){
            $sql .= " order by ";
            $sql .= implode(",", $aOrdenacao);
        }
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($aReg = $this->oConexao->fetchReg()){
                    $aObj[] = RhRamalMAP::rsToObj($aReg);
                }
                return $aObj;
            } else {
                return false;
            }
        }
        catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
    }

    function totalColecao(){
        $sql = "select count(*) from usersicas.rh_ramal";
        try{
            $this->oConexao->execute($sql);
            $aReg = $this->oConexao->fetchReg();
            return (int) $aReg[0];
        }
        catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
    }
	
    function consultar($valor){
    	$valor = Util::formataConsultaLike($valor); 

        $sql = "
				select
					rh_ramal.cd_ramal as rh_ramal_cd_ramal,
					rh_ramal.ramal as rh_ramal_ramal,
					rh_ramal.descricao as rh_ramal_descricao,
					sicas_lotacao.cd_lotacao as sicas_lotacao_cd_lotacao,
					sicas_lotacao.sigla as sicas_lotacao_sigla,
					sicas_lotacao.cd_siged as sicas_lotacao_cd_siged,
					sicas_lotacao.nm_lotacao as sicas_lotacao_nm_lotacao,
					sicas_lotacao.status as sicas_lotacao_status 
				from
					usersicas.rh_ramal 
				left join usersicas.sicas_lotacao 
					on (rh_ramal.cd_lotacao = sicas_lotacao.cd_lotacao)
                where
					sicas_lotacao.nm_lotacao like '$valor'
					or sicas_lotacao.sigla like '$valor'
					or rh_ramal.ramal like '$valor' 
					or rh_ramal.descricao like '$valor'";
        //print "<pre>$sql</pre>";
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($aReg = $this->oConexao->fetchReg()){
                    $aObj[] = RhRamalMAP::rsToObj($aReg);
                }
                return $aObj;
            } else {
                return false;
            }
        }
    	catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
    }
}