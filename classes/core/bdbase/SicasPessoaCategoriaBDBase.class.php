<?php
class SicasPessoaCategoriaBDBase {
	public $oConexao;
	public $msg;
	public $joinTabelas;
	
	function __construct(Conexao $oConexao){
	    $this->joinTabelas = "usersicas.sicas_pessoa_categoria";
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasPessoaCategoria){
		$reg = SicasPessoaCategoriaMAP::objToRsInsert($oSicasPessoaCategoria);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_pessoa_categoria(
                    " . implode(',', $aCampo). "
               )
                values(
                    :" . implode(", :", $aCampo). ")";
		
		foreach($reg as $cv => $vl)
			$regTemp [":$cv"] =($vl == '')? NULL : $vl;
		
		//Util::trace($sql);
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
	function alterar($oSicasPessoaCategoria){
		$reg = SicasPessoaCategoriaMAP::objToRs($oSicasPessoaCategoria);
		$sql = "
                    update 
                        usersicas.sicas_pessoa_categoria 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_categoria")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_categoria = {$reg['cd_categoria']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_categoria")
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
	function excluir($cd_categoria){
		$sql = "
                    delete from
                        usersicas.sicas_pessoa_categoria 
                    where
                        cd_categoria = $cd_categoria";
		
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
	function get($cd_categoria){
		$sql = "
                    select 
                        sicas_pessoa_categoria.cd_categoria as sicas_pessoa_categoria_cd_categoria,
    					sicas_pessoa_categoria.desc_categoria as sicas_pessoa_categoria_desc_categoria,
    					sicas_pessoa_categoria.desc_categoria_abrev as sicas_pessoa_categoria_desc_categoria_abrev 
                    from
                        usersicas.sicas_pessoa_categoria 
                    where
                        sicas_pessoa_categoria.cd_categoria = $cd_categoria";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasPessoaCategoriaMAP::rsToObj($aReg);
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
                            row_number() OVER (ORDER BY sicas_pessoa_categoria.cd_categoria asc) as row_number,
                            ".SicasPessoaCategoriaMap::dataToSelect()."
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
					$aObj [] = SicasPessoaCategoriaMAP::rsToObj($aReg);
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
		$sql = "select count(*)from usersicas.sicas_pessoa_categoria";
		try {
			$this->oConexao->execute($sql);
			$aReg = $this->oConexao->fetchReg();
			return(int)$aReg[''];
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function consultar($valor){
		$valor = Util::formataConsultaLike($valor);
		
		$sql = "
                select
                    sicas_pessoa_categoria.cd_categoria as sicas_pessoa_categoria_cd_categoria,
					sicas_pessoa_categoria.desc_categoria as sicas_pessoa_categoria_desc_categoria,
					sicas_pessoa_categoria.desc_categoria_abrev as sicas_pessoa_categoria_desc_categoria_abrev 
                from
                    usersicas.sicas_pessoa_categoria
                where
                    sicas_pessoa_categoria.desc_categoria like '$valor' 
					or sicas_pessoa_categoria.desc_categoria_abrev like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasPessoaCategoriaMAP::rsToObj($aReg);
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