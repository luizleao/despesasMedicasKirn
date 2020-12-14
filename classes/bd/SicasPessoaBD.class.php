<?php
class SicasPessoaBD extends SicasPessoaBDBase {
	function __construct($conexao=NULL){
		if (!$conexao)
			$conexao = new Conexao ();
		if ($conexao->msg != ""){
			$this->msg = $conexao->msg;
		} else {
			parent::__construct($conexao);
		}
	}
	
	function consultarBeneficiario($valor){
	    $valor = Util::formataConsultaLike($valor);
	    
	    $sql = "
                select tb.* from 
                    (select  
                        sicas_pessoa.cd_pessoa as sicas_pessoa_cd_pessoa, 
                        sicas_pessoa.nm_pessoa as sicas_pessoa_nm_pessoa, 
                        sicas_servidor.cd_matricula as sicas_servidor_cd_matricula, 
                        pessoa_servidor.nm_pessoa as nome_servidor,
                        sicas_dependente.dependente_proas as usuario_proas,
                        NULL as status_servidor
                    from 
                        usersicas.sicas_pessoa
                    inner join usersicas.sicas_dependente
                        on (sicas_dependente.cd_pessoa = sicas_pessoa.cd_pessoa)
                    inner join usersicas.sicas_servidor
                        on (sicas_servidor.cd_servidor = sicas_dependente.cd_servidor)
                    inner join usersicas.sicas_pessoa pessoa_servidor
                        on (sicas_servidor.cd_pessoa = pessoa_servidor.cd_pessoa)
                
                    union all 
                
                    select 
                        sicas_pessoa.cd_pessoa as sicas_pessoa_cd_pessoa, 
                        sicas_pessoa.nm_pessoa as sicas_pessoa_nm_pessoa, 
                        sicas_servidor.cd_matricula as sicas_servidor_cd_matricula,
                        NULL as nome_servidor,
                        sicas_servidor.usuario_proas,
                        sicas_servidor.status as status_servidor
                    from 
                        usersicas.sicas_pessoa
                    inner join usersicas.sicas_servidor
                        on (sicas_pessoa.cd_pessoa = sicas_servidor.cd_pessoa
                            and sicas_servidor.status = 1)
                    ) tb
                where 
                    (tb.sicas_pessoa_nm_pessoa like '".$valor."'
                    or tb.nome_servidor like '".$valor."')
                    and tb.usuario_proas = 1
                order by
					tb.sicas_pessoa_nm_pessoa";
	    
	    //Util::trace($sql);
	    
	    try {
	        $this->oConexao->execute($sql);
	        $aObj = array();
	        if($this->oConexao->numRows()!= 0){
	            while($aReg = $this->oConexao->fetchReg()){
	                $aObj[] = SicasPessoaMAP::rsToObj($aReg);
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
	
	function getAllNotServidor(){
		$sql = "
                select
                    ".SicasPessoaMAP::dataToSelect()."
                from
                    usersicas.sicas_pessoa
				left join usersicas.sicas_estado_civil
					on(sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
				left join usersicas.sicas_pessoa_categoria
					on(sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
                where
                    sicas_pessoa.cd_pessoa not in (select 
                    									sicas_servidor.cd_pessoa 
                    								from 
                    									usersicas.sicas_servidor
                    								where
                    									sicas_pessoa.cd_pessoa = sicas_servidor.cd_pessoa)
				order by
					sicas_pessoa.nm_pessoa";
	
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows() != 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj[] = SicasPessoaMAP::rsToObj($aReg);
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
	
	function getAllDependenteEnabled(){
	    $sql = "
                select
                    ".SicasPessoaMAP::dataToSelect()."
                from
                    usersicas.sicas_pessoa
				left join usersicas.sicas_estado_civil
					on(sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
				left join usersicas.sicas_pessoa_categoria
					on(sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
                where
                    sicas_pessoa.cd_pessoa not in (select
                    									sicas_servidor.cd_pessoa
                    								from
                    									usersicas.sicas_servidor
                    								where
                    									sicas_pessoa.cd_pessoa = sicas_servidor.cd_pessoa)
                    and sicas_pessoa.cd_pessoa not in (select
                        									sicas_dependente.cd_pessoa
                        								from
                        									usersicas.sicas_dependente
                        								where
                        									sicas_pessoa.cd_pessoa = sicas_dependente.cd_pessoa)
                    and sicas_pessoa.status=1
				order by
					sicas_pessoa.nm_pessoa";
	    
	    try {
	        $this->oConexao->execute($sql);
	        $aObj = array();
	        if($this->oConexao->numRows() != 0){
	            while($aReg = $this->oConexao->fetchReg()){
	                $aObj[] = SicasPessoaMAP::rsToObj($aReg);
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
	
	public function getByEmail($email){
		$sql = "
		    	select
			    	".SicasPessoaMAP::dataToSelect()."
		    	from
		    		usersicas.sicas_pessoa
		    	left join usersicas.sicas_estado_civil
		    		on (sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
		    	left join usersicas.sicas_pessoa_categoria
		    		on (sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
		    	where
		    		sicas_pessoa.email = '$email'
    				and sicas_pessoa.status = 1";
		try {
			$this->oConexao->execute($sql);
			if ($this->oConexao->numRows() != 0) {
				$aReg = $this->oConexao->fetchReg();
				return SicasPessoaMAP::rsToObj($aReg);
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	public function getByNome($nome) {
		$nome = Util::formataConsultaLike ($nome);
		
		$sql = "
				select
					".SicasPessoaMAP::dataToSelect()."
				from
					usersicas.sicas_pessoa
				left join usersicas.sicas_estado_civil
					on (sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
				left join usersicas.sicas_pessoa_categoria
					on (sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
				where
					sicas_pessoa.nm_pessoa like '$nome'
					and sicas_pessoa.status = 1";
		try {
			$this->oConexao->execute ($sql);
			if ($this->oConexao->numRows() != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasPessoaMAP::rsToObj ($aReg);
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage ();
			return false;
		}
	}

	/**
	 * Obter registro de SicasPessoa ativo no PROAS por CPF
	 * Data 25-01-2018
	 * Teste SAMS por Lee Ewerton.
	 *
	 * @access public
	 * @param string $cpf
	 * @return SicasPessoa
	 */
	public function getSicasPessoaAtivoPROASPorCpf($cpf){
		$sql = "
                select
					".SicasPessoaMAP::dataToSelect()."
		    	from
		    		usersicas.sicas_pessoa
		    	left join usersicas.sicas_estado_civil
		    		on(sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
		    	left join usersicas.sicas_pessoa_categoria
		    		on(sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
				where
					sicas_pessoa.cpf 		  = '$cpf'
					and sicas_pessoa.status   = 1
					and sicas_pessoa_categoria.cd_categoria in (1,4,68) -- Ativo, Comissao, Dependente"; 
		//print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute ($sql);
			if ($this->oConexao->numRows() != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasPessoaMAP::rsToObj ($aReg);
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage ();
			return false;
		}
	}
}	