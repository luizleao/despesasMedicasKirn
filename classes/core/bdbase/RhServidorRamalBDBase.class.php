<?php
class RhServidorRamalBDBase {
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
	
    function inserir($oRhServidorRamal){
		$reg = RhServidorRamalMAP::objToRs($oRhServidorRamal);
		$aCampo = array_keys($reg);
		$sql = "
				insert into usersicas.rh_servidor_ramal(
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
				//echo "@@@".$this->oConexao->msg;
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		}
		catch(PDOException $e){
			//echo "@@@".$e->getMessage();
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function alterar($oRhServidorRamal){
    	$reg = RhServidorRamalMAP::objToRs($oRhServidorRamal);
        $sql = "
                update 
                    usersicas.rh_servidor_ramal 
                set
                    ";
        foreach($reg as $cv=>$vl){
            if($cv == "cd_servidor" || $cv == "cd_ramal") continue;
            $a[] = "$cv = :$cv";
        }
        $sql .= implode(",\n", $a);
        $sql .= "
                where
                    cd_servidor = {$reg['cd_servidor']} 
					and cd_ramal = {$reg['cd_ramal']}";

        foreach($reg as $cv=>$vl){
            if($cv == "cd_servidor" || $cv == "cd_ramal") continue;
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
	
	function excluir($cd_servidor, $cd_ramal){
        $sql = "
                delete from
                    usersicas.rh_servidor_ramal 
                where
                    cd_servidor = $cd_servidor 
					and cd_ramal = $cd_ramal";

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
	
	function get($cd_servidor,$cd_ramal){
        $sql = "
                select 
					".RhServidorRamalMAP::dataToSelect()."
                from
					usersicas.rh_servidor_ramal 
				left join usersicas.sicas_servidor 
					on (rh_servidor_ramal.cd_servidor = sicas_servidor.cd_servidor)
				left join usersicas.sicas_pessoa 
					on (sicas_pessoa.cd_pessoa = sicas_servidor.cd_pessoa)
				left join usersicas.rh_ramal 
					on (rh_servidor_ramal.cd_ramal = rh_ramal.cd_ramal)
				left join usersicas.sicas_lotacao
					on (sicas_lotacao.cd_lotacao = rh_ramal.cd_lotacao) 
                where
					rh_servidor_ramal.cd_servidor = $cd_servidor 
					and rh_servidor_ramal.cd_ramal = $cd_ramal";
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $aReg = $this->oConexao->fetchReg();
                return RhServidorRamalMAP::rsToObj($aReg);
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
					".RhServidorRamalMAP::dataToSelect()."
                from
					usersicas.rh_servidor_ramal 
				left join usersicas.sicas_servidor 
					on (rh_servidor_ramal.cd_servidor = sicas_servidor.cd_servidor)
				left join usersicas.sicas_pessoa 
					on (sicas_pessoa.cd_pessoa = sicas_servidor.cd_pessoa)
				left join usersicas.rh_ramal 
					on (rh_servidor_ramal.cd_ramal = rh_ramal.cd_ramal)
				left join usersicas.sicas_lotacao
					on (sicas_lotacao.cd_lotacao = rh_ramal.cd_lotacao)";
        
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
                    $aObj[] = RhServidorRamalMAP::rsToObj($aReg);
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
        $sql = "select count(*) from usersicas.rh_servidor_ramal";
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
					".RhServidorRamalMAP::dataToSelect()."
                from
					usersicas.rh_servidor_ramal 
				left join usersicas.sicas_servidor 
					on (rh_servidor_ramal.cd_servidor = sicas_servidor.cd_servidor)
				left join usersicas.sicas_pessoa 
					on (sicas_pessoa.cd_pessoa = sicas_servidor.cd_pessoa)
				left join usersicas.rh_ramal 
					on (rh_servidor_ramal.cd_ramal = rh_ramal.cd_ramal)
				left join usersicas.sicas_lotacao
					on (sicas_lotacao.cd_lotacao = rh_ramal.cd_lotacao)
                where
					".RhServidorRamalMAP::filterLike($valor);
        //print "<pre>$sql</pre>";
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($aReg = $this->oConexao->fetchReg()){
                    $aObj[] = RhServidorRamalMAP::rsToObj($aReg);
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