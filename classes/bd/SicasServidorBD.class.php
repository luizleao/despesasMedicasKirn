<?php
class SicasServidorBD extends SicasServidorBDBase{

	function __construct($conexao = NULL){
		if(! $conexao)
			$conexao = new Conexao();
		if($conexao->msg != ""){
			$this->msg = $conexao->msg;
		} else{
			parent::__construct($conexao);
		}
	}

	public function getByEmail($email){
	    $sql = "
		    	select
			    	".SicasServidorMAP::dataToSelect()."
		    	from
		    		".$this->joinTabelas."
		    	where
		    		sicas_pessoa.email  = '$email'
					and sicas_servidor.status = 1
					and sicas_pessoa.status   = 1";
	    //Util::trace($sql);
	    try{
	        $this->oConexao->execute($sql);
	        if($this->oConexao->numRows() != 0){
	            $aReg = $this->oConexao->fetchReg();
	            return SicasServidorMAP::rsToObj($aReg);
	        } else{
	            $this->msg = "Nenhum registro encontrado!";
	            return false;
	        }
	    } catch(PDOException $e){
	        $this->msg = $e->getMessage();
	        return false;
	    }
	}
	
	public function getByMatricula($cd_matricula){
	    $sql = "
		    	select
			    	".SicasServidorMAP::dataToSelect()."
		    	from
		    		".$this->joinTabelas."
		    	where
		    		sicas_servidor.cd_matricula  = '".trim($cd_matricula)."'
				--	and sicas_servidor.status = 1
				--	and sicas_pessoa.status   = 1";
	    //Util::trace($sql);
	    try{
	        $this->oConexao->execute($sql);
	        if($this->oConexao->numRows() != 0){
	            $aReg = $this->oConexao->fetchReg();
	            return SicasServidorMAP::rsToObj($aReg);
	        } else{
	            $this->msg = "Nenhum registro encontrado!";
	            return false;
	        }
	    } catch(PDOException $e){
	        $this->msg = $e->getMessage();
	        return false;
	    }
	}
	
	public function getByPessoa($cd_pessoa){
		$sql = "
		    	select
			    	".SicasServidorMAP::dataToSelect()."
		    	from
		    		".$this->joinTabelas."
		    	where
		    		sicas_servidor.cd_pessoa  = $cd_pessoa";
		//Util::trace($sql);
		try{
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows() != 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasServidorMAP::rsToObj($aReg);
			} else{
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	public function getByDependente($cd_pessoa){
	    $sql = "
		    	select
			    	".SicasServidorMAP::dataToSelect()."
		    	from
                    ".$this->joinTabelas."
                left join usersicas.sicas_dependente
                    on (sicas_dependente.cd_servidor = sicas_servidor.cd_servidor)
		    	where
		    		sicas_dependente.cd_pessoa  = $cd_pessoa
					and sicas_servidor.status = 1
					and sicas_pessoa.status   = 1";

	    //Util::trace($sql);

	    try{
	        $this->oConexao->execute($sql);
	        if($this->oConexao->numRows() != 0){
	            $aReg = $this->oConexao->fetchReg();
	            return SicasServidorMAP::rsToObj($aReg);
	        } else{
	            $this->msg = "Nenhum registro encontrado!";
	            return false;
	        }
	    } catch(PDOException $e){
	        $this->msg = $e->getMessage();
	        return false;
	    }
	}
	
	function consultarSicasServidorRamal($valor){
	    $valor = Util::formataConsultaLike($valor);
	    
	    $sql = "
                select
                   ".SicasServidorMAP::dataToSelect()."
                from
                    ".$this->joinTabelas."
                where
                   (".SicasServidorMAP::filterLike($valor).")
                    and sicas_servidor.status = 1
                    and sicas_pessoa.status = 1
                    and sicas_servidor.cd_categoria in (".SicasPessoaCategoriaEnum::ATIVO_PERMANENTE.", 
                                                      ".SicasPessoaCategoriaEnum::REQUISITADO.", 
                                                      ".SicasPessoaCategoriaEnum::CARGO_EM_COMISSAO.", 
                                                      ".SicasPessoaCategoriaEnum::COLABORADOR_EVENTUAL.", 
                                                      ".SicasPessoaCategoriaEnum::CONTRATO_TEMPORARIO.")
                order by
                    sicas_pessoa.nm_pessoa";

	    //Util::trace($sql);

	    try{
	        $this->oConexao->execute($sql);
	        $aObj = array();
	        if($this->oConexao->numRows() != 0){
	            while($aReg = $this->oConexao->fetchReg()){
	                $aObj[] = SicasServidorMAP::rsToObj($aReg);
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