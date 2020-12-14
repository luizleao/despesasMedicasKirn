<?php
class SicasAtendimentoBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao) {
		try {
			$this->oConexao = $oConexao;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
		}
	}
	function inserir($oSicasAtendimento) {
		$reg = SicasAtendimentoMAP::objToRsInsert($oSicasAtendimento);
		$aCampo = array_keys ( $reg );
		$sql = "
                insert into usersicas.sicas_atendimento(
                    " . implode ( ',', $aCampo ) . "
                ) 
                values(
                    :" . implode ( ", :", $aCampo ) . ")";
		
		foreach ( $reg as $cv => $vl )
			$regTemp [":$cv"] = ($vl == '') ? NULL : $vl;
		
		try {
			$this->oConexao->executePrepare ( $sql, $regTemp );
			if ($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return $this->oConexao->lastID ();
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function alterar($oSicasAtendimento) {
		$reg = SicasAtendimentoMAP::objToRs ( $oSicasAtendimento );
		$sql = "
                    update 
                        usersicas.sicas_atendimento 
                    set
                        ";
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_atendimento")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode ( ",\n", $a );
		$sql .= "
                    where
                        cd_atendimento = {$reg['cd_atendimento']}";
		
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_atendimento")
				continue;
			$regTemp [":$cv"] = ($vl == '') ? NULL : $vl;
		}
		try {
			$this->oConexao->executePrepare ( $sql, $regTemp );
			if ($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function excluir($cd_atendimento) {
		$sql = "
                    delete from
                        usersicas.sicas_atendimento 
                    where
                        cd_atendimento = $cd_atendimento";
		
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->msg != "") {
				$this->msg = $this->oConexao->msg;
				return false;
			}
			return true;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function get($cd_atendimento) {
		$sql = "
                    select 
                        sicas_atendimento.cd_atendimento as sicas_atendimento_cd_atendimento,
					sicas_atendimento.cd_pessoa as sicas_atendimento_cd_pessoa,
					sicas_atendimento.dt_ini_atendimento as sicas_atendimento_dt_ini_atendimento,
					sicas_atendimento.dt_fim_atendimento as sicas_atendimento_dt_fim_atendimento,
					sicas_atendimento.cd_medico as sicas_atendimento_cd_medico,
					sicas_atendimento.status as sicas_atendimento_status,
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
					sicas_medico.cd_medico as sicas_medico_cd_medico,
					sicas_medico.login as sicas_medico_login,
					sicas_medico.status as sicas_medico_status 
                    from
                        usersicas.sicas_atendimento 
				left join usersicas.sicas_pessoa 
					on (sicas_atendimento.cd_pessoa = sicas_pessoa.cd_pessoa)
				left join usersicas.sicas_medico 
					on (sicas_atendimento.cd_medico = sicas_medico.cd_medico) 
                    where
                        sicas_atendimento.cd_atendimento = $cd_atendimento";
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->numRows () != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasAtendimentoMAP::rsToObj ( $aReg );
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function getAll($aFiltro = NULL, $aOrdenacao = NULL) {
		$sql = "
                select
                    sicas_atendimento.cd_atendimento as sicas_atendimento_cd_atendimento,
					sicas_atendimento.cd_pessoa as sicas_atendimento_cd_pessoa,
					sicas_atendimento.dt_ini_atendimento as sicas_atendimento_dt_ini_atendimento,
					sicas_atendimento.dt_fim_atendimento as sicas_atendimento_dt_fim_atendimento,
					sicas_atendimento.cd_medico as sicas_atendimento_cd_medico,
					sicas_atendimento.status as sicas_atendimento_status,
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
					sicas_medico.cd_medico as sicas_medico_cd_medico,
					sicas_medico.login as sicas_medico_login,
					sicas_medico.status as sicas_medico_status 
                from
                    usersicas.sicas_atendimento 
				left join usersicas.sicas_pessoa 
					on (sicas_atendimento.cd_pessoa = sicas_pessoa.cd_pessoa)
				left join usersicas.sicas_medico 
					on (sicas_atendimento.cd_medico = sicas_medico.cd_medico)";
		
		if (count ( $aFiltro ) > 0) {
			$sql .= " where ";
			$sql .= implode ( " and ", $aFiltro );
		}
		
		if (count ( $aOrdenacao ) > 0) {
			$sql .= " order by ";
			$sql .= implode ( ",", $aOrdenacao );
		}
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = SicasAtendimentoMAP::rsToObj ( $aReg );
				}
				return $aObj;
			} else {
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function totalColecao() {
		$sql = "select count(*) from usersicas.sicas_atendimento";
		try {
			$this->oConexao->execute ( $sql );
			$aReg = $this->oConexao->fetchReg ();
			return ( int ) $aReg [0];
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function consultar($valor) {
		$valor = Util::formataConsultaLike ( $valor );
		
		$sql = "
                select
                    sicas_atendimento.cd_atendimento as sicas_atendimento_cd_atendimento,
					sicas_atendimento.cd_pessoa as sicas_atendimento_cd_pessoa,
					sicas_atendimento.dt_ini_atendimento as sicas_atendimento_dt_ini_atendimento,
					sicas_atendimento.dt_fim_atendimento as sicas_atendimento_dt_fim_atendimento,
					sicas_atendimento.cd_medico as sicas_atendimento_cd_medico,
					sicas_atendimento.status as sicas_atendimento_status,
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
					sicas_medico.cd_medico as sicas_medico_cd_medico,
					sicas_medico.login as sicas_medico_login,
					sicas_medico.status as sicas_medico_status 
                from
                    usersicas.sicas_atendimento 
				left join usersicas.sicas_pessoa 
					on (sicas_atendimento.cd_pessoa = sicas_pessoa.cd_pessoa)
				left join usersicas.sicas_medico 
					on (sicas_atendimento.cd_medico = sicas_medico.cd_medico)
                where
                    sicas_atendimento.cd_pessoa like '$valor' 
					or sicas_atendimento.dt_ini_atendimento like '$valor' 
					or sicas_atendimento.dt_fim_atendimento like '$valor' 
					or sicas_atendimento.cd_medico like '$valor' 
					or sicas_atendimento.status like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = SicasAtendimentoMAP::rsToObj ( $aReg );
				}
				return $aObj;
			} else {
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
}