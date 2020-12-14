<?php
class SicasDespesaBDBase {
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = "
                        usersicas.sicas_despesa
                	left join usersicas.sicas_procedimento_autorizado
                		on(sicas_despesa.cd_procedimento_autorizado = sicas_procedimento_autorizado.cd_procedimento_autorizado)
                	left join usersicas.sicas_salario
                		on(sicas_despesa.cd_salario = sicas_salario.cd_salario)
                    left join usersicas.sicas_fatura
                		on(sicas_despesa.cd_fatura = sicas_fatura.cd_fatura)
                    left join usersicas.sicas_servidor
                		on(sicas_servidor.cd_servidor = sicas_salario.cd_servidor)
                    left join usersicas.sicas_pessoa
                		on(sicas_servidor.cd_pessoa = sicas_pessoa.cd_pessoa)";
	    
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function cadastrar($oSicasDespesa){
	    $reg = SicasDespesaMAP::objToRsInsert($oSicasDespesa);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_despesa(
                    " . implode(',', $aCampo). "
               )
                values(
                    :" . implode(", :", $aCampo). ")";
		//Util::trace($sql);
		//Util::trace($reg);
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
	function alterar($oSicasDespesa){
		$reg = SicasDespesaMAP::objToRs($oSicasDespesa);
		$sql = "
                update 
                    usersicas.sicas_despesa 
                set
                    ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_despesa")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                where
                    cd_despesa = {$reg['cd_despesa']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_despesa")
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
	function excluir($cd_despesa){
		$sql = "
                delete from
                    usersicas.sicas_despesa 
                where
                    cd_despesa = $cd_despesa";
		
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
	
	function get($cd_despesa){
		$sql = "
                select 
                    ".SicasDespesaMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    sicas_despesa.cd_despesa = $cd_despesa";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasDespesaMAP::rsToObj($aReg);
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	function getAll($aFiltro=[], $aOrdenacao=[], $qtd = NULL, $pagina = NULL){
	    if($pagina != NULL){
    		$sql = "
                   select top($qtd) *
                      from(
                           select
                    		row_number()OVER(ORDER BY sicas_despesa.cd_despesa ASC)AS row_number, 
                            ".SicasDespesaMAP::dataToSelect()."
                        from
                            {$this->joinTabelas}
                          )tb
                     where 
                        row_number > ".$qtd*($pagina-1);
	    } else {
	        $sql = "select  
                        ".SicasDespesaMAP::dataToSelect()."
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
					$aObj [] = SicasDespesaMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_despesa";
		try {
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			
			//Util::trace($aReg);
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
                    ".SicasDespesaMAP::dataToSelect()."
                from
                    {$this->joinTabelas}
                where
                    ".SicasDespesaMAP::filterLike($valor);
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasDespesaMAP::rsToObj($aReg);
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