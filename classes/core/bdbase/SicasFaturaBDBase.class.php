<?php
class SicasFaturaBDBase {
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
    
	/**
	 * Cadastrar instância da classe SicasFatura
	 * 
	 * @param SicasFatura $oSicasFatura
	 * @return integer|boolean
	 */	
    function cadastrar($oSicasFatura){
		$reg = SicasFaturaMAP::objToRsInsert($oSicasFatura);
		$aCampo = array_keys($reg);
		$sql = "
				insert into usersicas.sicas_fatura(
					".implode(',', $aCampo)."
				)
				values(
					:".implode(", :", $aCampo).")";
        
		//Util::trace($sql);
        
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
	
	/**
	 * Alterar instância da classe SicasFatura
	 * 
	 * @param SicasFatura $oSicasFatura
	 * @return boolean
	 */	
	function alterar($oSicasFatura){
    	$reg = SicasFaturaMAP::objToRs($oSicasFatura);
        $sql = "
                update 
                    usersicas.sicas_fatura 
                set
                    ";
        foreach($reg as $cv=>$vl){
            if($cv == "cd_fatura") continue;
            $a[] = "$cv = :$cv";
        }
        $sql .= implode(",\n", $a);
        $sql .= "
                where
                    cd_fatura = {$reg['cd_fatura']}";

        foreach($reg as $cv=>$vl){
            if($cv == "cd_fatura") continue;
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
	
	/**
	 * Excluir instância da classe SicasFatura
	 * 
	 * @param integer $cd_fatura
	 * @return boolean
	 */
	function excluir($cd_fatura){
        $sql = "
                delete from
                    usersicas.sicas_fatura 
                where
                    cd_fatura = $cd_fatura";

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
	
	/**
	 * Retorna instância da classe SicasFatura
	 * 
	 * @param integer $cd_fatura
	 * @return SicasFatura|boolean
	 */
	function get($cd_fatura){
        $sql = "
                select 
					".SicasFaturaMAP::dataToSelect()." 
                from
					usersicas.sicas_fatura 
				left join usersicas.sicas_credenciado 
					on (sicas_fatura.cd_credenciado = sicas_credenciado.cd_credenciado) 
                where
					sicas_fatura.cd_fatura = $cd_fatura";
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $oReg = $this->oConexao->fetchReg();
                return SicasFaturaMAP::rsToObj($oReg);
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
	
	/**
	 * Retorna a lista de registros da tabela SicasFatura
	 * 
	 * @param string[] $aFiltro
	 * @param string[] $aOrdenacao
	 * @param integer $qtd
	 * @param integer $pagina
	 * @return SicasFatura[]|boolean
	 */
    function getAll($aFiltro = [], $aOrdenacao = [], $qtd = NULL, $pagina = NULL){
        $sql = "
				select
					".SicasFaturaMAP::dataToSelect()." 
				from
					usersicas.sicas_fatura 
				left join usersicas.sicas_credenciado 
					on (sicas_fatura.cd_credenciado = sicas_credenciado.cd_credenciado)";
        
        if(count($aFiltro)>0){
            $sql .= " where ";
            $sql .= implode(" and ", $aFiltro);
        }
        
        if(count($aOrdenacao)>0){
            $sql .= " order by ";
            $sql .= implode(",", $aOrdenacao);
        }
        
        $sql .= ($pagina != NULL) ? "
        		limit ".$qtd*($pagina-1).", $qtd" : "";
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($oReg = $this->oConexao->fetchReg()){
                    $aObj[] = SicasFaturaMAP::rsToObj($oReg);
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

	/**
	 * Consultar instâncias da classe SicasFatura
	 * 
	 * @param string $valor
	 * @return SicasFatura[]|boolean
	 */
    function consultar($valor){
    	$valor = Util::formataConsultaLike($valor); 

        $sql = "
				select
					".SicasFaturaMAP::dataToSelect()." 
				from
					usersicas.sicas_fatura 
				left join usersicas.sicas_credenciado 
					on (sicas_fatura.cd_credenciado = sicas_credenciado.cd_credenciado)
                where
					".SicasFaturaMAP::filterLike($valor);
					
        //print "<pre>$sql</pre>";
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($oReg = $this->oConexao->fetchReg()){
                    $aObj[] = SicasFaturaMAP::rsToObj($oReg);
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

	/**
	 * Retorna o total de instâncias da classe SicasFatura
	 * 
	 * @return integer|boolean
	 */
    function totalColecao(){
        $sql = "select count(*) from usersicas.sicas_fatura";
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