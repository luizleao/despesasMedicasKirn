<?php
class RhIesBDBase {
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
	
    function cadastrar($oRhIes){
		$reg = RhIesMAP::objToRsInsert($oRhIes);
		$aCampo = array_keys($reg);
		$sql = "
				insert into usersicas.rh_ies(
					".implode(',', $aCampo)."
				)
				values(
					:".implode(", :", $aCampo).")";
		
		foreach($reg as $cv=>$vl)
			$regTemp[":$cv"] = ($vl=='') ? NULL : $vl;

		//Util::trace($sql);
		try{
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
	
	function alterar($oRhIes){
    	$reg = RhIesMAP::objToRs($oRhIes);
        $sql = "
                update 
                    usersicas.rh_ies 
                set
                    ";
        foreach($reg as $cv=>$vl){
            if($cv == "cd_ies") continue;
            $a[] = "$cv = :$cv";
        }
        $sql .= implode(",\n", $a);
        $sql .= "
                where
                    cd_ies = {$reg['cd_ies']}";

        foreach($reg as $cv=>$vl){
            if($cv == "cd_ies") continue;
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
	
	function excluir($cd_ies){
        $sql = "
                delete from
                    usersicas.rh_ies 
                where
                    cd_ies = $cd_ies";

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
	
	function get($cd_ies){
        $sql = "
                select 
					".RhIesMAP::dataToSelect()." 
                from
					usersicas.rh_ies 
                where
					rh_ies.cd_ies = $cd_ies";
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $oReg = $this->oConexao->fetchReg();
                return RhIesMAP::rsToObj($oReg);
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
	
    function getAll($aFiltro = [], $aOrdenacao = [], $qtd = NULL, $pagina = NULL){
        $sql = "
				select
					".RhIesMAP::dataToSelect()." 
				from
					usersicas.rh_ies";
        
        if(count($aFiltro)>0){
            $sql .= " where ";
            $sql .= implode(" and ", $aFiltro);
        }
        
        if(count($aOrdenacao)>0){
            $sql .= " order by ";
            $sql .= implode(",", $aOrdenacao);
        }
    /*    
        $sql .= ($pagina != NULL) ? "
        		limit ".$qtd*($pagina-1).", $qtd" : "";
				*/
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($oReg = $this->oConexao->fetchReg()){
                    $aObj[] = RhIesMAP::rsToObj($oReg);
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
	
    function consultar($valor){
    	$valor = Util::formataConsultaLike($valor); 

        $sql = "
				select
					".RhIesMAP::dataToSelect()." 
				from
					usersicas.rh_ies
                where
					".RhIesMAP::filterLike($valor);
					
        //print "<pre>$sql</pre>";
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($oReg = $this->oConexao->fetchReg()){
                    $aObj[] = RhIesMAP::rsToObj($oReg);
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
        $sql = "select count(*) from usersicas.rh_ies";
        try{
            $this->oConexao->execute($sql);
            $oReg = $this->oConexao->fetchRow();
            return (int) $oReg[0];
        }
        catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
    }
}