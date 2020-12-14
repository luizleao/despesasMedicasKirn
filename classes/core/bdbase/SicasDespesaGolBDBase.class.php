<?php
class SicasDespesaGolBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao) {
		try {
			$this->oConexao = $oConexao;
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
		}
	}
	function inserir($oSicasDespesaGol) {
		$reg = SicasDespesaGolMAP::objToRs ( $oSicasDespesaGol );
		$aCampo = array_keys ( $reg );
		$sql = "
                insert into usersicas.sicas_despesa_gol(
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
	function alterar($oSicasDespesaGol) {
		$reg = SicasDespesaGolMAP::objToRs ( $oSicasDespesaGol );
		$sql = "
                    update 
                        usersicas.sicas_despesa_gol 
                    set
                        ";
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_despesa_gol")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode ( ",\n", $a );
		$sql .= "
                    where
                        cd_despesa_gol = {$reg['cd_despesa_gol']}";
		
		foreach ( $reg as $cv => $vl ) {
			if ($cv == "cd_despesa_gol")
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
	function excluir($cd_despesa_gol) {
		$sql = "
                    delete from
                        usersicas.sicas_despesa_gol 
                    where
                        cd_despesa_gol = $cd_despesa_gol";
		
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
	function get($cd_despesa_gol) {
		$sql = "
                    select 
                        sicas_despesa_gol.cd_despesa_gol as sicas_despesa_gol_cd_despesa_gol,
					sicas_despesa_gol.ano_mes as sicas_despesa_gol_ano_mes,
					sicas_despesa_gol.matricula as sicas_despesa_gol_matricula,
					sicas_despesa_gol.cd_pessoa as sicas_despesa_gol_cd_pessoa,
					sicas_despesa_gol.cd_credenciado as sicas_despesa_gol_cd_credenciado,
					sicas_despesa_gol.vl_despesa as sicas_despesa_gol_vl_despesa,
					sicas_despesa_gol.vl_d_despesa as sicas_despesa_gol_vl_d_despesa,
					sicas_despesa_gol.porcentagem_desconto as sicas_despesa_gol_porcentagem_desconto,
					sicas_despesa_gol.remuneracao as sicas_despesa_gol_remuneracao,
					sicas_despesa_gol.cd_tipo_despesa as sicas_despesa_gol_cd_tipo_despesa,
					sicas_despesa_gol.flg_desconta as sicas_despesa_gol_flg_desconta,
					sicas_despesa_gol.flg_fis_jur as sicas_despesa_gol_flg_fis_jur,
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
					sicas_tipo_despesa.cd_tipo_despesa as sicas_tipo_despesa_cd_tipo_despesa,
					sicas_tipo_despesa.nm_despesa as sicas_tipo_despesa_nm_despesa,
					sicas_tipo_despesa.credenciado as sicas_tipo_despesa_credenciado,
					sicas_tipo_despesa.status as sicas_tipo_despesa_status 
                    from
                        usersicas.sicas_despesa_gol 
				left join usersicas.sicas_pessoa 
					on (sicas_despesa_gol.cd_pessoa = sicas_pessoa.cd_pessoa)
				left join usersicas.sicas_credenciado 
					on (sicas_despesa_gol.cd_credenciado = sicas_credenciado.cd_credenciado)
				left join usersicas.sicas_tipo_despesa 
					on (sicas_despesa_gol.cd_tipo_despesa = sicas_tipo_despesa.cd_tipo_despesa) 
                    where
                        sicas_despesa_gol.cd_despesa_gol = $cd_despesa_gol";
		try {
			$this->oConexao->execute ( $sql );
			if ($this->oConexao->numRows () != 0) {
				$aReg = $this->oConexao->fetchReg ();
				return SicasDespesaGolMAP::rsToObj ( $aReg );
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function getAll($aFiltro=[], $aOrdenacao=[]) {
		$sql = "
                select
                    sicas_despesa_gol.cd_despesa_gol as sicas_despesa_gol_cd_despesa_gol,
					sicas_despesa_gol.ano_mes as sicas_despesa_gol_ano_mes,
					sicas_despesa_gol.matricula as sicas_despesa_gol_matricula,
					sicas_despesa_gol.cd_pessoa as sicas_despesa_gol_cd_pessoa,
					sicas_despesa_gol.cd_credenciado as sicas_despesa_gol_cd_credenciado,
					sicas_despesa_gol.vl_despesa as sicas_despesa_gol_vl_despesa,
					sicas_despesa_gol.vl_d_despesa as sicas_despesa_gol_vl_d_despesa,
					sicas_despesa_gol.porcentagem_desconto as sicas_despesa_gol_porcentagem_desconto,
					sicas_despesa_gol.remuneracao as sicas_despesa_gol_remuneracao,
					sicas_despesa_gol.cd_tipo_despesa as sicas_despesa_gol_cd_tipo_despesa,
					sicas_despesa_gol.flg_desconta as sicas_despesa_gol_flg_desconta,
					sicas_despesa_gol.flg_fis_jur as sicas_despesa_gol_flg_fis_jur,
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
					sicas_tipo_despesa.cd_tipo_despesa as sicas_tipo_despesa_cd_tipo_despesa,
					sicas_tipo_despesa.nm_despesa as sicas_tipo_despesa_nm_despesa,
					sicas_tipo_despesa.credenciado as sicas_tipo_despesa_credenciado,
					sicas_tipo_despesa.status as sicas_tipo_despesa_status 
                from
                    usersicas.sicas_despesa_gol 
				left join usersicas.sicas_pessoa 
					on (sicas_despesa_gol.cd_pessoa = sicas_pessoa.cd_pessoa)
				left join usersicas.sicas_credenciado 
					on (sicas_despesa_gol.cd_credenciado = sicas_credenciado.cd_credenciado)
				left join usersicas.sicas_tipo_despesa 
					on (sicas_despesa_gol.cd_tipo_despesa = sicas_tipo_despesa.cd_tipo_despesa)";
		
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
					$aObj [] = SicasDespesaGolMAP::rsToObj ( $aReg );
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
		$sql = "select count(*) from usersicas.sicas_despesa_gol";
		try {
			$this->oConexao->execute ( $sql );
			$aReg = $this->oConexao->fetchReg ();
			return (int)$aReg[''];
		} catch ( PDOException $e ) {
			$this->msg = $e->getMessage ();
			return false;
		}
	}
	function consultar($valor) {
		$valor = Util::formataConsultaLike ( $valor );
		
		$sql = "
                select
                    sicas_despesa_gol.cd_despesa_gol as sicas_despesa_gol_cd_despesa_gol,
					sicas_despesa_gol.ano_mes as sicas_despesa_gol_ano_mes,
					sicas_despesa_gol.matricula as sicas_despesa_gol_matricula,
					sicas_despesa_gol.cd_pessoa as sicas_despesa_gol_cd_pessoa,
					sicas_despesa_gol.cd_credenciado as sicas_despesa_gol_cd_credenciado,
					sicas_despesa_gol.vl_despesa as sicas_despesa_gol_vl_despesa,
					sicas_despesa_gol.vl_d_despesa as sicas_despesa_gol_vl_d_despesa,
					sicas_despesa_gol.porcentagem_desconto as sicas_despesa_gol_porcentagem_desconto,
					sicas_despesa_gol.remuneracao as sicas_despesa_gol_remuneracao,
					sicas_despesa_gol.cd_tipo_despesa as sicas_despesa_gol_cd_tipo_despesa,
					sicas_despesa_gol.flg_desconta as sicas_despesa_gol_flg_desconta,
					sicas_despesa_gol.flg_fis_jur as sicas_despesa_gol_flg_fis_jur,
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
					sicas_tipo_despesa.cd_tipo_despesa as sicas_tipo_despesa_cd_tipo_despesa,
					sicas_tipo_despesa.nm_despesa as sicas_tipo_despesa_nm_despesa,
					sicas_tipo_despesa.credenciado as sicas_tipo_despesa_credenciado,
					sicas_tipo_despesa.status as sicas_tipo_despesa_status 
                from
                    usersicas.sicas_despesa_gol 
				left join usersicas.sicas_pessoa 
					on (sicas_despesa_gol.cd_pessoa = sicas_pessoa.cd_pessoa)
				left join usersicas.sicas_credenciado 
					on (sicas_despesa_gol.cd_credenciado = sicas_credenciado.cd_credenciado)
				left join usersicas.sicas_tipo_despesa 
					on (sicas_despesa_gol.cd_tipo_despesa = sicas_tipo_despesa.cd_tipo_despesa)
                where
                    sicas_despesa_gol.ano_mes like '$valor' 
					or sicas_despesa_gol.matricula like '$valor' 
					or sicas_despesa_gol.cd_pessoa like '$valor' 
					or sicas_despesa_gol.cd_credenciado like '$valor' 
					or sicas_despesa_gol.vl_despesa like '$valor' 
					or sicas_despesa_gol.vl_d_despesa like '$valor' 
					or sicas_despesa_gol.porcentagem_desconto like '$valor' 
					or sicas_despesa_gol.remuneracao like '$valor' 
					or sicas_despesa_gol.cd_tipo_despesa like '$valor' 
					or sicas_despesa_gol.flg_desconta like '$valor' 
					or sicas_despesa_gol.flg_fis_jur like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute ( $sql );
			$aObj = array ();
			if ($this->oConexao->numRows () != 0) {
				while ( $aReg = $this->oConexao->fetchReg () ) {
					$aObj [] = SicasDespesaGolMAP::rsToObj ( $aReg );
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