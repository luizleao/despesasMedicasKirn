<?php
class SicasEspecialidadeMedicaCredenciadoBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao){
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasEspecialidadeMedicaCredenciado){
		$reg = SicasEspecialidadeMedicaCredenciadoMAP::objToRs($oSicasEspecialidadeMedicaCredenciado);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_especialidade_medica_credenciado(
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
	function alterar($oSicasEspecialidadeMedicaCredenciado){
		$reg = SicasEspecialidadeMedicaCredenciadoMAP::objToRs($oSicasEspecialidadeMedicaCredenciado);
		$sql = "
                    update 
                        usersicas.sicas_especialidade_medica_credenciado 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_especialidade_medica_credenciado")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_especialidade_medica_credenciado = {$reg['cd_especialidade_medica_credenciado']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_especialidade_medica_credenciado")
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
	function excluir($cd_especialidade_medica_credenciado){
		$sql = "
                    delete from
                        usersicas.sicas_especialidade_medica_credenciado 
                    where
                        cd_especialidade_medica_credenciado = $cd_especialidade_medica_credenciado";
		
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
	function get($cd_especialidade_medica_credenciado){
		$sql = "
                    select 
                        sicas_especialidade_medica_credenciado.cd_especialidade_medica_credenciado as sicas_especialidade_medica_credenciado_cd_especialidade_medica_credenciado,
					sicas_especialidade_medica_credenciado.cd_credenciado as sicas_especialidade_medica_credenciado_cd_credenciado,
					sicas_especialidade_medica_credenciado.cd_especialidade_medica as sicas_especialidade_medica_credenciado_cd_especialidade_medica,
					sicas_especialidade_medica_credenciado.status as sicas_especialidade_medica_credenciado_status,
					sicas_credenciado.cd_credenciado as sicas_credenciado_cd_credenciado,
					sicas_credenciado.nm_credenciado as sicas_credenciado_nm_credenciado,
					sicas_credenciado.dt_nascimento as sicas_credenciado_dt_nascimento,
					sicas_credenciado.hora_atendimento as sicas_credenciado_hora_atendimento,
					sicas_credenciado.nm_servicos as sicas_credenciado_nm_servicos,
					sicas_credenciado.profissional_liberal as sicas_credenciado_profissional_liberal,
					sicas_credenciado.endereco as sicas_credenciado_endereco,
					sicas_credenciado.complemento as sicas_credenciado_complemento,
					sicas_credenciado.bairro as sicas_credenciado_bairro,
					sicas_credenciado.cidade as sicas_credenciado_cidade,
					sicas_credenciado.uf as sicas_credenciado_uf,
					sicas_credenciado.cep as sicas_credenciado_cep,
					sicas_credenciado.telefone1 as sicas_credenciado_telefone1,
					sicas_credenciado.telefone2 as sicas_credenciado_telefone2,
					sicas_credenciado.fax1 as sicas_credenciado_fax1,
					sicas_credenciado.ramal1 as sicas_credenciado_ramal1,
					sicas_credenciado.tipo as sicas_credenciado_tipo,
					sicas_credenciado.cd_pis_pasep as sicas_credenciado_cd_pis_pasep,
					sicas_credenciado.cpf as sicas_credenciado_cpf,
					sicas_credenciado.cgc as sicas_credenciado_cgc,
					sicas_credenciado.guia_prev_social as sicas_credenciado_guia_prev_social,
					sicas_credenciado.status as sicas_credenciado_status,
					sicas_especialidade_medica.cd_especialidade_medica as sicas_especialidade_medica_cd_especialidade_medica,
					sicas_especialidade_medica.nm_especialidade as sicas_especialidade_medica_nm_especialidade,
					sicas_especialidade_medica.status as sicas_especialidade_medica_status 
                    from
                        usersicas.sicas_especialidade_medica_credenciado 
				left join usersicas.sicas_credenciado 
					on(sicas_especialidade_medica_credenciado.cd_credenciado = sicas_credenciado.cd_credenciado)
				left join usersicas.sicas_especialidade_medica 
					on(sicas_especialidade_medica_credenciado.cd_especialidade_medica = sicas_especialidade_medica.cd_especialidade_medica)
                    where
                        sicas_especialidade_medica_credenciado.cd_especialidade_medica_credenciado = $cd_especialidade_medica_credenciado";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasEspecialidadeMedicaCredenciadoMAP::rsToObj($aReg);
			} else {
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
                    sicas_especialidade_medica_credenciado.cd_especialidade_medica_credenciado as sicas_especialidade_medica_credenciado_cd_especialidade_medica_credenciado,
					sicas_especialidade_medica_credenciado.cd_credenciado as sicas_especialidade_medica_credenciado_cd_credenciado,
					sicas_especialidade_medica_credenciado.cd_especialidade_medica as sicas_especialidade_medica_credenciado_cd_especialidade_medica,
					sicas_especialidade_medica_credenciado.status as sicas_especialidade_medica_credenciado_status,
					sicas_credenciado.cd_credenciado as sicas_credenciado_cd_credenciado,
					sicas_credenciado.nm_credenciado as sicas_credenciado_nm_credenciado,
					sicas_credenciado.dt_nascimento as sicas_credenciado_dt_nascimento,
					sicas_credenciado.hora_atendimento as sicas_credenciado_hora_atendimento,
					sicas_credenciado.nm_servicos as sicas_credenciado_nm_servicos,
					sicas_credenciado.profissional_liberal as sicas_credenciado_profissional_liberal,
					sicas_credenciado.endereco as sicas_credenciado_endereco,
					sicas_credenciado.complemento as sicas_credenciado_complemento,
					sicas_credenciado.bairro as sicas_credenciado_bairro,
					sicas_credenciado.cidade as sicas_credenciado_cidade,
					sicas_credenciado.uf as sicas_credenciado_uf,
					sicas_credenciado.cep as sicas_credenciado_cep,
					sicas_credenciado.telefone1 as sicas_credenciado_telefone1,
					sicas_credenciado.telefone2 as sicas_credenciado_telefone2,
					sicas_credenciado.fax1 as sicas_credenciado_fax1,
					sicas_credenciado.ramal1 as sicas_credenciado_ramal1,
					sicas_credenciado.tipo as sicas_credenciado_tipo,
					sicas_credenciado.cd_pis_pasep as sicas_credenciado_cd_pis_pasep,
					sicas_credenciado.cpf as sicas_credenciado_cpf,
					sicas_credenciado.cgc as sicas_credenciado_cgc,
					sicas_credenciado.guia_prev_social as sicas_credenciado_guia_prev_social,
					sicas_credenciado.status as sicas_credenciado_status,
					sicas_especialidade_medica.cd_especialidade_medica as sicas_especialidade_medica_cd_especialidade_medica,
					sicas_especialidade_medica.nm_especialidade as sicas_especialidade_medica_nm_especialidade,
					sicas_especialidade_medica.status as sicas_especialidade_medica_status 
                from
                    usersicas.sicas_especialidade_medica_credenciado 
				left join usersicas.sicas_credenciado 
					on(sicas_especialidade_medica_credenciado.cd_credenciado = sicas_credenciado.cd_credenciado)
				left join usersicas.sicas_especialidade_medica 
					on(sicas_especialidade_medica_credenciado.cd_especialidade_medica = sicas_especialidade_medica.cd_especialidade_medica)";
		
		if(count($aFiltro)> 0){
			$sql .= " where ";
			$sql .= implode(" and ", $aFiltro);
		}
		
		if(count($aOrdenacao)> 0){
			$sql .= " order by ";
			$sql .= implode(",", $aOrdenacao);
		}
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasEspecialidadeMedicaCredenciadoMAP::rsToObj($aReg);
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
		$sql = "select count(*) from usersicas.sicas_especialidade_medica_credenciado";
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
                    sicas_especialidade_medica_credenciado.cd_especialidade_medica_credenciado as sicas_especialidade_medica_credenciado_cd_especialidade_medica_credenciado,
					sicas_especialidade_medica_credenciado.cd_credenciado as sicas_especialidade_medica_credenciado_cd_credenciado,
					sicas_especialidade_medica_credenciado.cd_especialidade_medica as sicas_especialidade_medica_credenciado_cd_especialidade_medica,
					sicas_especialidade_medica_credenciado.status as sicas_especialidade_medica_credenciado_status,
					sicas_credenciado.cd_credenciado as sicas_credenciado_cd_credenciado,
					sicas_credenciado.nm_credenciado as sicas_credenciado_nm_credenciado,
					sicas_credenciado.dt_nascimento as sicas_credenciado_dt_nascimento,
					sicas_credenciado.hora_atendimento as sicas_credenciado_hora_atendimento,
					sicas_credenciado.nm_servicos as sicas_credenciado_nm_servicos,
					sicas_credenciado.profissional_liberal as sicas_credenciado_profissional_liberal,
					sicas_credenciado.endereco as sicas_credenciado_endereco,
					sicas_credenciado.complemento as sicas_credenciado_complemento,
					sicas_credenciado.bairro as sicas_credenciado_bairro,
					sicas_credenciado.cidade as sicas_credenciado_cidade,
					sicas_credenciado.uf as sicas_credenciado_uf,
					sicas_credenciado.cep as sicas_credenciado_cep,
					sicas_credenciado.telefone1 as sicas_credenciado_telefone1,
					sicas_credenciado.telefone2 as sicas_credenciado_telefone2,
					sicas_credenciado.fax1 as sicas_credenciado_fax1,
					sicas_credenciado.ramal1 as sicas_credenciado_ramal1,
					sicas_credenciado.tipo as sicas_credenciado_tipo,
					sicas_credenciado.cd_pis_pasep as sicas_credenciado_cd_pis_pasep,
					sicas_credenciado.cpf as sicas_credenciado_cpf,
					sicas_credenciado.cgc as sicas_credenciado_cgc,
					sicas_credenciado.guia_prev_social as sicas_credenciado_guia_prev_social,
					sicas_credenciado.status as sicas_credenciado_status,
					sicas_especialidade_medica.cd_especialidade_medica as sicas_especialidade_medica_cd_especialidade_medica,
					sicas_especialidade_medica.nm_especialidade as sicas_especialidade_medica_nm_especialidade,
					sicas_especialidade_medica.status as sicas_especialidade_medica_status 
                from
                    usersicas.sicas_especialidade_medica_credenciado 
				left join usersicas.sicas_credenciado 
					on(sicas_especialidade_medica_credenciado.cd_credenciado = sicas_credenciado.cd_credenciado)
				left join usersicas.sicas_especialidade_medica 
					on(sicas_especialidade_medica_credenciado.cd_especialidade_medica = sicas_especialidade_medica.cd_especialidade_medica)
                where
                    sicas_especialidade_medica_credenciado.cd_credenciado like '$valor' 
					or sicas_especialidade_medica_credenciado.cd_especialidade_medica like '$valor' 
					or sicas_especialidade_medica_credenciado.status like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasEspecialidadeMedicaCredenciadoMAP::rsToObj($aReg);
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