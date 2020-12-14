<?php
class RhServidorRamalBD extends RhServidorRamalBDBase{
    function __construct($conexao = NULL){
        if(!$conexao) 
            $conexao = new Conexao();
        if($conexao->msg != ""){
            $this->msg = $conexao->msg;
        } else {
            parent::__construct($conexao);
        }
    }
	
    public function getAllRhServidorRamalPorRamal($cd_ramal){
    	$sql = "
				select
					rh_servidor_ramal.cd_servidor as rh_servidor_ramal_cd_servidor,
					rh_servidor_ramal.cd_ramal as rh_servidor_ramal_cd_ramal,
					sicas_servidor.cd_servidor as sicas_servidor_cd_servidor,
					sicas_servidor.cd_pessoa as sicas_servidor_cd_pessoa,
					sicas_servidor.cd_matricula as sicas_servidor_cd_matricula,
					sicas_servidor.cd_lotacao as sicas_servidor_cd_lotacao,
					sicas_servidor.status as sicas_servidor_status,
					sicas_servidor.serv_efetivo as sicas_servidor_serv_efetivo,
					sicas_servidor.cd_cargo as sicas_servidor_cd_cargo,
					sicas_pessoa.cd_pessoa as sicas_pessoa_cd_pessoa,
					sicas_pessoa.nm_pessoa as sicas_pessoa_nm_pessoa,
					sicas_pessoa.email as sicas_pessoa_email,
					sicas_pessoa.dt_nascimento as sicas_pessoa_dt_nascimento,
					sicas_pessoa.genero as sicas_pessoa_genero,
					rh_ramal.cd_ramal as rh_ramal_cd_ramal,
					rh_ramal.cd_lotacao as rh_ramal_cd_lotacao,
					rh_ramal.ramal as rh_ramal_ramal,
					rh_ramal.descricao as rh_ramal_descricao
				from
					usersicas.sicas_servidor
				join usersicas.sicas_pessoa
					on (sicas_pessoa.cd_pessoa = sicas_servidor.cd_pessoa
						and sicas_pessoa.status   = 1 
						and sicas_servidor.status = 1)
				left join usersicas.rh_servidor_ramal
					on (rh_servidor_ramal.cd_servidor = sicas_servidor.cd_servidor)
				left join usersicas.rh_ramal
					on (rh_servidor_ramal.cd_ramal = rh_ramal.cd_ramal)
    			where
    				rh_servidor_ramal.cd_ramal = $cd_ramal";
    	
    	try{
    		$this->oConexao->execute($sql);
    		$aObj = array();
    		if($this->oConexao->numRows() != 0){
    			while ($aReg = $this->oConexao->fetchReg()){
    				$aObj[] = RhServidorRamalMAP::rsToObj($aReg);
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
    
    public function getAllRhRamalPorServidor($cd_servidor){
    	$sql = "SELECT 
    				rh_servidor_ramal.cd_servidor as rh_servidor_ramal_cd_servidor,
					rh_servidor_ramal.cd_ramal as rh_servidor_ramal_cd_ramal,
					sicas_servidor.cd_servidor as sicas_servidor_cd_servidor,
					sicas_servidor.cd_pessoa as sicas_servidor_cd_pessoa,
					sicas_servidor.cd_matricula as sicas_servidor_cd_matricula,
					sicas_servidor.cd_lotacao as sicas_servidor_cd_lotacao,
					sicas_servidor.status as sicas_servidor_status,
					sicas_servidor.serv_efetivo as sicas_servidor_serv_efetivo,
					sicas_servidor.cd_cargo as sicas_servidor_cd_cargo,
					sicas_pessoa.cd_pessoa as sicas_pessoa_cd_pessoa,
					sicas_pessoa.nm_pessoa as sicas_pessoa_nm_pessoa,
					sicas_pessoa.email as sicas_pessoa_email,
					sicas_pessoa.dt_nascimento as sicas_pessoa_dt_nascimento,
					sicas_pessoa.genero as sicas_pessoa_genero,
					rh_ramal.cd_ramal as rh_ramal_cd_ramal,
					rh_ramal.cd_lotacao as rh_ramal_cd_lotacao,
					rh_ramal.ramal as rh_ramal_ramal,
					rh_ramal.descricao as rh_ramal_descricao
				FROM 
					usersicas.sicas_servidor
				join usersicas.sicas_pessoa
					on (sicas_pessoa.cd_pessoa = sicas_servidor.cd_pessoa
						and sicas_pessoa.status   = 1 
						and sicas_servidor.status = 1)
				left join usersicas.rh_servidor_ramal
					on (sicas_servidor.cd_servidor = rh_servidor_ramal.cd_servidor)
				LEFT JOIN usersicas.rh_ramal
					on (rh_servidor_ramal.cd_ramal = rh_ramal.cd_ramal)
				WHERE 
    				rh_servidor_ramal.cd_servidor =  $cd_servidor";
    	try{
    		$this->oConexao->execute($sql);
    		$aObj = array();
    		if($this->oConexao->numRows() != 0){
    			while ($aReg = $this->oConexao->fetchReg()){
    				$aObj[] = RhServidorRamalMAP::rsToObj($aReg);
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
}