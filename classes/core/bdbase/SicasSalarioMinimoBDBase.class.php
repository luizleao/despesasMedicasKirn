<?php
class SicasSalarioMinimoBDBase{
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao){
		try{
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function cadastrar($oSicasSalarioMinimo){
		$reg = SicasSalarioMinimoMAP::objToRsInsert($oSicasSalarioMinimo);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_salario_minimo(
                    " . implode(',', $aCampo) . "
               ) 
                values(
                    :" . implode(", :", $aCampo) . ")";
		
		foreach($reg as $cv => $vl)
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
		
		try{
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
	function alterar($oSicasSalarioMinimo){
	    $reg = SicasSalarioMinimoMAP::objToRs($oSicasSalarioMinimo);
		
		$sql = "
                update 
                    usersicas.sicas_salario_minimo 
                set
                    ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_salario_minimo")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                where
                    cd_salario_minimo ={$reg['cd_salario_minimo']}";
		
		//Util::trace($sql);
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_salario_minimo")
				continue;
			$regTemp [":$cv"] =($vl == '') ? NULL : $vl;
		}
		try{
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
	function excluir($cd_salario_minimo){
		$sql = "
                    delete from
                        usersicas.sicas_salario_minimo 
                    where
                        cd_salario_minimo = $cd_salario_minimo";
		
		try{
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
	function get($cd_salario_minimo){
		$sql = "
                    select 
                        ".SicasSalarioMinimoMAP::dataToSelect()."
                    from
                        usersicas.sicas_salario_minimo 
                    where
                        sicas_salario_minimo.cd_salario_minimo = $cd_salario_minimo";
		try{
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasSalarioMinimoMAP::rsToObj($aReg);
			} else{
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
                    ".SicasSalarioMinimoMAP::dataToSelect()." 
                from
                    usersicas.sicas_salario_minimo";
		
		if(count($aFiltro) > 0){
			$sql .= " where ";
			$sql .= implode(" and ", $aFiltro);
		}
		
		if(count($aOrdenacao) > 0){
			$sql .= " order by ";
			$sql .= implode(",", $aOrdenacao);
		}
		try{
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasSalarioMinimoMAP::rsToObj($aReg);
				}
				return $aObj;
			} else{
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function totalColecao(){
		$sql = "select count(*) from usersicas.sicas_salario_minimo";
		try{
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			return (int) $aReg [''];
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function consultar($valor){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    ".SicasSalarioMinimoMAP::dataToSelect()." 
                from
                    usersicas.sicas_salario_minimo
                where
                    ".SicasSalarioMinimoMAP::filterLike($valor);
		// print "<pre>$sql</pre>";
		try{
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasSalarioMinimoMAP::rsToObj($aReg);
				}
				return $aObj;
			} else{
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
}