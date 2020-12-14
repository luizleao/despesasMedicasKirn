<?php
class SicasParamDescontoBDBase {
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = " usersicas.sicas_param_desconto";
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasParamDesconto){
		$reg = SicasParamDescontoMAP::objToRs($oSicasParamDesconto);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_param_desconto(
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
	function alterar($oSicasParamDesconto){
		$reg = SicasParamDescontoMAP::objToRs($oSicasParamDesconto);
		$sql = "
                    update 
                        usersicas.sicas_param_desconto 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_param_desc")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_param_desc = {$reg['cd_param_desc']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_param_desc")
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
	function excluir($cd_param_desc){
		$sql = "
                delete from
                    usersicas.sicas_param_desconto 
                where
                    cd_param_desc = $cd_param_desc";
		
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
	function get($cd_param_desc){
		$sql = "
                select 
                    ".SicasParamDescontoMAP::dataToSelect()." 
                from
                    {$this->joinTabelas} 
                where
                    sicas_param_desconto.cd_param_desc = $cd_param_desc";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasParamDescontoMAP::rsToObj($aReg);
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function getAll($aFiltro=[], $aOrdenacao=[], $qtd=NULL, $pagina=NULL){
		if($pagina != NULL){
		    $sql = "
                    select
                        top($qtd)*
                    from(
                        select
                            row_number()OVER(ORDER BY sicas_param_desconto.cd_param_desc asc)as row_number,
                            ".SicasParamDescontoMAP::dataToSelect()."
                        from
                            {$this->joinTabelas}
                         )tb
                     where
                        row_number > ".$qtd*($pagina-1);
		} else {
		    $sql = "
                    select
                        ".SicasPessoaCategoriaMap::dataToSelect()."
                    from
                        {$this->joinTabelas}";
                        
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
					$aObj [] = SicasParamDescontoMAP::rsToObj($aReg);
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
		$sql = "select count(*)from usersicas.sicas_param_desconto";
		try {
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			
			return(int)$aReg[''];
			
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function consultar($valor, $aFiltro=[], $aOrdenacao=[]){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    ".SicasParamDescontoMAP::dataToSelect()." 
                from
                    {$this->joinTabelas}
                where
                   (".SicasParamDescontoMAP::filterLike($valor).")";
		
		if(count($aFiltro)> 0){
		    $sql .=  " and(".implode(" and ", $aFiltro). ")";
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
					$aObj [] = SicasParamDescontoMAP::rsToObj($aReg);
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