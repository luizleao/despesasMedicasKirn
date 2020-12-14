<?php
class RhEstagiarioBDBase {
    public $oConexao;
    public $msg;
    public $joinTables;
    
    function __construct(Conexao $oConexao){
        $this->joinTables = " usersicas.rh_estagiario 
        				left join usersicas.sicas_pessoa 
        					on (rh_estagiario.cd_pessoa = sicas_pessoa.cd_pessoa)
                        left join usersicas.sicas_pessoa_categoria 
        					on (sicas_pessoa_categoria.cd_categoria = sicas_pessoa.cd_categoria)
                        left join usersicas.sicas_estado_civil 
        					on (sicas_estado_civil.cd_estado_civil = sicas_pessoa.cd_estado_civil)
        				left join usersicas.sicas_lotacao 
        					on (rh_estagiario.cd_lotacao = sicas_lotacao.cd_lotacao)
                        left join usersicas.sicas_lotacao lotacao_pai 
        					on (lotacao_pai.cd_lotacao = sicas_lotacao.cd_lotacao_pai)
        				left join usersicas.rh_ies 
        					on (rh_estagiario.cd_ies = rh_ies.cd_ies)";
        try{
            $this->oConexao = $oConexao;
        } 
        catch (PDOException $e){
            $this->msg = $e->getMessage();
        }
    }
	
    function cadastrar($oRhEstagiario){
		$reg = RhEstagiarioMAP::objToRsInsert($oRhEstagiario);
		$aCampo = array_keys($reg);
		$sql = "
				insert into usersicas.rh_estagiario(
					".implode(',', $aCampo)."
				)
				values(
					:".implode(", :", $aCampo).")";

		foreach($reg as $cv=>$vl)
			$regTemp[":$cv"] = ($vl=='') ? NULL : $vl;

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
	
	function alterar($oRhEstagiario){
    	$reg = RhEstagiarioMAP::objToRs($oRhEstagiario);
        $sql = "
                update 
                    usersicas.rh_estagiario 
                set
                    ";
        foreach($reg as $cv=>$vl){
            if($cv == "cd_estagiario") continue;
            $a[] = "$cv = :$cv";
        }
        $sql .= implode(",\n", $a);
        $sql .= "
                where
                    cd_estagiario = {$reg['cd_estagiario']}";

        foreach($reg as $cv=>$vl){
            if($cv == "cd_estagiario") continue;
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
	
	function excluir($cd_estagiario){
        $sql = "
                delete from
                    usersicas.rh_estagiario 
                where
                    cd_estagiario = $cd_estagiario";

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
	
	function get($cd_estagiario){
        $sql = "
                select 
					".RhEstagiarioMAP::dataToSelect()." 
                from
					".$this->joinTables."
                where
					rh_estagiario.cd_estagiario = $cd_estagiario";
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $oReg = $this->oConexao->fetchReg();
                return RhEstagiarioMAP::rsToObj($oReg);
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
	
    function getAll($aFiltro=[], $aOrdenacao=[], $qtd = NULL, $pagina = NULL){
        $sql = "
				select
					".RhEstagiarioMAP::dataToSelect()." 
				from
					".$this->joinTables;
        
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
        //Util::trace($sql);
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($oReg = $this->oConexao->fetchReg()){
                    $aObj[] = RhEstagiarioMAP::rsToObj($oReg);
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
					".RhEstagiarioMAP::dataToSelect()." 
				from
					".$this->joinTables."
                where
					".RhEstagiarioMAP::filterLike($valor);
					
        //print "<pre>$sql</pre>";
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($oReg = $this->oConexao->fetchReg()){
                    $aObj[] = RhEstagiarioMAP::rsToObj($oReg);
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
        $sql = "select count(*) from usersicas.rh_estagiario";
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