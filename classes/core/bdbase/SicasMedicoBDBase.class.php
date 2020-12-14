<?php
class SicasMedicoBDBase {
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = "usersicas.sicas_medico
                            left join usersicas.sicas_servidor
                                on(sicas_medico.cd_servidor = sicas_servidor.cd_servidor)
                            left join usersicas.sicas_pessoa_categoria categoria_servidor
                                on(sicas_servidor.cd_categoria = categoria_servidor.cd_categoria)
                            left join usersicas.sicas_lotacao
                                on(sicas_lotacao.cd_lotacao = sicas_servidor.cd_lotacao)
                            left join usersicas.sicas_lotacao lotacao_pai
                                on(sicas_lotacao.cd_lotacao_pai = lotacao_pai.cd_lotacao)
                            left join usersicas.sicas_pessoa
                                on(sicas_pessoa.cd_pessoa = sicas_servidor.cd_pessoa)
                            left join usersicas.sicas_pessoa_categoria
                                on(sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
                            left join usersicas.sicas_estado_civil
                                on(sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
                            left join usersicas.rh_cargo
            		    		on(sicas_servidor.cd_cargo = rh_cargo.cd_cargo)";
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function cadastrar($oSicasMedico){
		$reg = SicasMedicoMAP::objToRsInsert($oSicasMedico);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_medico(
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
	function alterar($oSicasMedico){
		$reg = SicasMedicoMAP::objToRs($oSicasMedico);
		$sql = "
                    update 
                        usersicas.sicas_medico 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_medico")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_medico = {$reg['cd_medico']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_medico")
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
	function excluir($cd_medico){
		$sql = "
                delete from
                    usersicas.sicas_medico 
                where
                    cd_medico = $cd_medico";
	
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
	function get($cd_medico){
		$sql = "
                    select 
                        ".SicasMedicoMAP::dataToSelect()."
                    from
                        {$this->joinTabelas} 
                    where
                        sicas_medico.cd_medico = $cd_medico";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasMedicoMAP::rsToObj($aReg);
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
                   SELECT TOP($qtd)*
                      FROM(
                           SELECT
                    		row_number()OVER(ORDER BY sicas_medico.cd_medico ASC)AS row_number,
                            ".SicasMedicoMAP::dataToSelect()."
                        from
                            {$this->joinTabelas}
                         )tb
                     where
                        row_number > ".$qtd*($pagina-1);
	    } else {
	        $sql = "SELECT
                        ".SicasMedicoMAP::dataToSelect()."
                    from
                        $join";
                        
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
	        $aObj = [];
	        if($this->oConexao->numRows()!= 0){
	            while($aReg = $this->oConexao->fetchReg()){
	                $aObj[] = SicasMedicoMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_medico";
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
                    ".SicasMedicoMAP::dataToSelect()." 
                from
                    {$this->joinTabelas}
                where
                    ".SicasMedicoMAP::filterLike($valor);
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasMedicoMAP::rsToObj($aReg);
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