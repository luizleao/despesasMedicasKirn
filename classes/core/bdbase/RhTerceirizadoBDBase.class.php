<?php
class RhTerceirizadoBDBase {
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
	
    function inserir($oRhTerceirizado){
		$reg = RhTerceirizadoMAP::objToRs($oRhTerceirizado);
		$aCampo = array_keys($reg);
		$sql = "
				insert into usersicas.rh_terceirizado(
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
	
	function alterar($oRhTerceirizado){
    	$reg = RhTerceirizadoMAP::objToRs($oRhTerceirizado);
        $sql = "
                update 
                    usersicas.rh_terceirizado 
                set
                    ";
        foreach($reg as $cv=>$vl){
            if($cv == "cd_terceirizado") continue;
            $a[] = "$cv = :$cv";
        }
        $sql .= implode(",\n", $a);
        $sql .= "
                where
                    cd_terceirizado = {$reg['cd_terceirizado']}";

        foreach($reg as $cv=>$vl){
            if($cv == "cd_terceirizado") continue;
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
	
	function excluir($cd_terceirizado){
        $sql = "
                delete from
                    usersicas.rh_terceirizado 
                where
                    cd_terceirizado = $cd_terceirizado";

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
	
	function get($cd_terceirizado){
        $sql = "
                select 
					rh_terceirizado.cd_terceirizado as rh_terceirizado_cd_terceirizado,
					rh_terceirizado.cd_pessoa as rh_terceirizado_cd_pessoa,
					rh_terceirizado.cd_lotacao as rh_terceirizado_cd_lotacao,
					rh_terceirizado.cargo as rh_terceirizado_cargo,
					rh_terceirizado.status as rh_terceirizado_status,
					sicas_pessoa.cd_pessoa as sicas_pessoa_cd_pessoa,
					sicas_pessoa.nm_pessoa as sicas_pessoa_nm_pessoa,
					sicas_pessoa.email as sicas_pessoa_email,
					sicas_pessoa.dt_nascimento as sicas_pessoa_dt_nascimento,
					sicas_pessoa.genero as sicas_pessoa_genero,
					sicas_pessoa.cd_estado_civil as sicas_pessoa_cd_estado_civil,
					sicas_pessoa.identidade as sicas_pessoa_identidade,
					sicas_pessoa.nm_orgao_emissor as sicas_pessoa_nm_orgao_emissor,
					sicas_pessoa.dt_emissao as sicas_pessoa_dt_emissao,
					sicas_pessoa.cpf as sicas_pessoa_cpf,
					sicas_pessoa.endereco as sicas_pessoa_endereco,
					sicas_pessoa.complemento as sicas_pessoa_complemento,
					sicas_pessoa.bairro as sicas_pessoa_bairro,
					sicas_pessoa.cidade as sicas_pessoa_cidade,
					sicas_pessoa.uf as sicas_pessoa_uf,
					sicas_pessoa.cep as sicas_pessoa_cep,
					sicas_pessoa.telefone as sicas_pessoa_telefone,
					sicas_pessoa.grupo_sanguineo as sicas_pessoa_grupo_sanguineo,
					sicas_pessoa.tipo_beneficiario as sicas_pessoa_tipo_beneficiario,
					sicas_pessoa.status as sicas_pessoa_status,
					sicas_pessoa.foto as sicas_pessoa_foto,
					sicas_pessoa.cd_categoria as sicas_pessoa_cd_categoria,
					sicas_pessoa.uf_identidade as sicas_pessoa_uf_identidade,
					sicas_lotacao.cd_lotacao as sicas_lotacao_cd_lotacao,
					sicas_lotacao.sigla as sicas_lotacao_sigla,
					sicas_lotacao.cd_siged as sicas_lotacao_cd_siged,
					sicas_lotacao.nm_lotacao as sicas_lotacao_nm_lotacao,
					sicas_lotacao.status as sicas_lotacao_status,
					sicas_lotacao.cd_lotacao_pai as sicas_lotacao_cd_lotacao_pai 
                from
					usersicas.rh_terceirizado 
				left join usersicas.sicas_pessoa 
					on (rh_terceirizado.cd_pessoa = sicas_pessoa.cd_pessoa)
				left join usersicas.sicas_lotacao 
					on (rh_terceirizado.cd_lotacao = sicas_lotacao.cd_lotacao) 
                where
					rh_terceirizado.cd_terceirizado = $cd_terceirizado";
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $aReg = $this->oConexao->fetchReg();
                return RhTerceirizadoMAP::rsToObj($aReg);
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
	
    function getAll($aFiltro = NULL, $aOrdenacao = NULL){
        $sql = "
				select
					rh_terceirizado.cd_terceirizado as rh_terceirizado_cd_terceirizado,
					rh_terceirizado.cd_pessoa as rh_terceirizado_cd_pessoa,
					rh_terceirizado.cd_lotacao as rh_terceirizado_cd_lotacao,
					rh_terceirizado.cargo as rh_terceirizado_cargo,
					rh_terceirizado.status as rh_terceirizado_status,
					sicas_pessoa.cd_pessoa as sicas_pessoa_cd_pessoa,
					sicas_pessoa.nm_pessoa as sicas_pessoa_nm_pessoa,
					sicas_pessoa.email as sicas_pessoa_email,
					sicas_pessoa.dt_nascimento as sicas_pessoa_dt_nascimento,
					sicas_pessoa.genero as sicas_pessoa_genero,
					sicas_pessoa.cd_estado_civil as sicas_pessoa_cd_estado_civil,
					sicas_pessoa.identidade as sicas_pessoa_identidade,
					sicas_pessoa.nm_orgao_emissor as sicas_pessoa_nm_orgao_emissor,
					sicas_pessoa.dt_emissao as sicas_pessoa_dt_emissao,
					sicas_pessoa.cpf as sicas_pessoa_cpf,
					sicas_pessoa.endereco as sicas_pessoa_endereco,
					sicas_pessoa.complemento as sicas_pessoa_complemento,
					sicas_pessoa.bairro as sicas_pessoa_bairro,
					sicas_pessoa.cidade as sicas_pessoa_cidade,
					sicas_pessoa.uf as sicas_pessoa_uf,
					sicas_pessoa.cep as sicas_pessoa_cep,
					sicas_pessoa.telefone as sicas_pessoa_telefone,
					sicas_pessoa.grupo_sanguineo as sicas_pessoa_grupo_sanguineo,
					sicas_pessoa.tipo_beneficiario as sicas_pessoa_tipo_beneficiario,
					sicas_pessoa.status as sicas_pessoa_status,
					sicas_pessoa.foto as sicas_pessoa_foto,
					sicas_pessoa.cd_categoria as sicas_pessoa_cd_categoria,
					sicas_pessoa.uf_identidade as sicas_pessoa_uf_identidade,
					sicas_lotacao.cd_lotacao as sicas_lotacao_cd_lotacao,
					sicas_lotacao.sigla as sicas_lotacao_sigla,
					sicas_lotacao.cd_siged as sicas_lotacao_cd_siged,
					sicas_lotacao.nm_lotacao as sicas_lotacao_nm_lotacao,
					sicas_lotacao.status as sicas_lotacao_status,
					sicas_lotacao.cd_lotacao_pai as sicas_lotacao_cd_lotacao_pai 
				from
					usersicas.rh_terceirizado 
				left join usersicas.sicas_pessoa 
					on (rh_terceirizado.cd_pessoa = sicas_pessoa.cd_pessoa)
				left join usersicas.sicas_lotacao 
					on (rh_terceirizado.cd_lotacao = sicas_lotacao.cd_lotacao)";
        
        if(count($aFiltro)>0){
            $sql .= " where ";
            $sql .= implode(" and ", $aFiltro);
        }
        
        if(count($aOrdenacao)>0){
            $sql .= " order by ";
            $sql .= implode(",", $aOrdenacao);
        }
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($aReg = $this->oConexao->fetchReg()){
                    $aObj[] = RhTerceirizadoMAP::rsToObj($aReg);
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
        $sql = "select count(*) from usersicas.rh_terceirizado";
        try{
            $this->oConexao->execute($sql);
            $aReg = $this->oConexao->fetchReg();
            return (int) $aReg[0];
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
					rh_terceirizado.cd_terceirizado as rh_terceirizado_cd_terceirizado,
					rh_terceirizado.cd_pessoa as rh_terceirizado_cd_pessoa,
					rh_terceirizado.cd_lotacao as rh_terceirizado_cd_lotacao,
					rh_terceirizado.cargo as rh_terceirizado_cargo,
					rh_terceirizado.status as rh_terceirizado_status,
					sicas_pessoa.cd_pessoa as sicas_pessoa_cd_pessoa,
					sicas_pessoa.nm_pessoa as sicas_pessoa_nm_pessoa,
					sicas_pessoa.email as sicas_pessoa_email,
					sicas_pessoa.dt_nascimento as sicas_pessoa_dt_nascimento,
					sicas_pessoa.genero as sicas_pessoa_genero,
					sicas_pessoa.cd_estado_civil as sicas_pessoa_cd_estado_civil,
					sicas_pessoa.identidade as sicas_pessoa_identidade,
					sicas_pessoa.nm_orgao_emissor as sicas_pessoa_nm_orgao_emissor,
					sicas_pessoa.dt_emissao as sicas_pessoa_dt_emissao,
					sicas_pessoa.cpf as sicas_pessoa_cpf,
					sicas_pessoa.endereco as sicas_pessoa_endereco,
					sicas_pessoa.complemento as sicas_pessoa_complemento,
					sicas_pessoa.bairro as sicas_pessoa_bairro,
					sicas_pessoa.cidade as sicas_pessoa_cidade,
					sicas_pessoa.uf as sicas_pessoa_uf,
					sicas_pessoa.cep as sicas_pessoa_cep,
					sicas_pessoa.telefone as sicas_pessoa_telefone,
					sicas_pessoa.grupo_sanguineo as sicas_pessoa_grupo_sanguineo,
					sicas_pessoa.tipo_beneficiario as sicas_pessoa_tipo_beneficiario,
					sicas_pessoa.status as sicas_pessoa_status,
					sicas_pessoa.foto as sicas_pessoa_foto,
					sicas_pessoa.cd_categoria as sicas_pessoa_cd_categoria,
					sicas_pessoa.uf_identidade as sicas_pessoa_uf_identidade,
					sicas_lotacao.cd_lotacao as sicas_lotacao_cd_lotacao,
					sicas_lotacao.sigla as sicas_lotacao_sigla,
					sicas_lotacao.cd_siged as sicas_lotacao_cd_siged,
					sicas_lotacao.nm_lotacao as sicas_lotacao_nm_lotacao,
					sicas_lotacao.status as sicas_lotacao_status,
					sicas_lotacao.cd_lotacao_pai as sicas_lotacao_cd_lotacao_pai 
				from
					usersicas.rh_terceirizado 
				left join usersicas.sicas_pessoa 
					on (rh_terceirizado.cd_pessoa = sicas_pessoa.cd_pessoa)
				left join usersicas.sicas_lotacao 
					on (rh_terceirizado.cd_lotacao = sicas_lotacao.cd_lotacao)
                where
					rh_terceirizado.cd_pessoa like '$valor' 
					or rh_terceirizado.cd_lotacao like '$valor' 
					or rh_terceirizado.cargo like '$valor' 
					or rh_terceirizado.status like '$valor'";
        //print "<pre>$sql</pre>";
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($aReg = $this->oConexao->fetchReg()){
                    $aObj[] = RhTerceirizadoMAP::rsToObj($aReg);
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