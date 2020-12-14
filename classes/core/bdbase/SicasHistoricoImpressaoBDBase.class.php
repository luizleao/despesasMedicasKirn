<?php
class SicasHistoricoImpressaoBDBase {
	public $oConexao;
	public $msg;
	function __construct(Conexao $oConexao){
		try {
			$this->oConexao = $oConexao;
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
		}
	}
	function inserir($oSicasHistoricoImpressao){
		$reg = SicasHistoricoImpressaoMAP::objToRs($oSicasHistoricoImpressao);
		$aCampo = array_keys($reg);
		$sql = "
                insert into usersicas.sicas_historico_impressao(
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
	function alterar($oSicasHistoricoImpressao){
		$reg = SicasHistoricoImpressaoMAP::objToRs($oSicasHistoricoImpressao);
		$sql = "
                    update 
                        usersicas.sicas_historico_impressao 
                    set
                        ";
		foreach($reg as $cv => $vl){
			if($cv == "cd_carteira")
				continue;
			$a [] = "$cv = :$cv";
		}
		$sql .= implode(",\n", $a);
		$sql .= "
                    where
                        cd_carteira = {$reg['cd_carteira']}";
		
		foreach($reg as $cv => $vl){
			if($cv == "cd_carteira")
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
	function excluir($cd_carteira){
		$sql = "
                delete from
                    usersicas.sicas_historico_impressao 
                where
                    cd_carteira = $cd_carteira";
		
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
	function get($cd_carteira){
		$sql = "
                    select 
                        sicas_historico_impressao.cd_carteira as sicas_historico_impressao_cd_carteira,
					sicas_historico_impressao.cd_pessoa as sicas_historico_impressao_cd_pessoa,
					sicas_historico_impressao.dt_impressao as sicas_historico_impressao_dt_impressao,
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
					sicas_pessoa.uf_identidade as sicas_pessoa_uf_identidade 
                    from
                        usersicas.sicas_historico_impressao 
				left join usersicas.sicas_pessoa 
					on(sicas_historico_impressao.cd_pessoa = sicas_pessoa.cd_pessoa)
                    where
                        sicas_historico_impressao.cd_carteira = $cd_carteira";
		try {
			$this->oConexao->execute($sql);
			if($this->oConexao->numRows()!= 0){
				$aReg = $this->oConexao->fetchReg();
				return SicasHistoricoImpressaoMAP::rsToObj($aReg);
			} else {
				$this->msg = "Nenhum registro encontrado!";
				return false;
			}
		} catch(PDOException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	function getAll($aFiltro = NULL, $aOrdenacao = NULL){
		$sql = "
                select
                    sicas_historico_impressao.cd_carteira as sicas_historico_impressao_cd_carteira,
					sicas_historico_impressao.cd_pessoa as sicas_historico_impressao_cd_pessoa,
					sicas_historico_impressao.dt_impressao as sicas_historico_impressao_dt_impressao,
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
					sicas_pessoa.uf_identidade as sicas_pessoa_uf_identidade 
                from
                    usersicas.sicas_historico_impressao 
				left join usersicas.sicas_pessoa 
					on(sicas_historico_impressao.cd_pessoa = sicas_pessoa.cd_pessoa)";
		
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
					$aObj [] = SicasHistoricoImpressaoMAP::rsToObj($aReg);
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
		$sql = "select count(*)from usersicas.sicas_historico_impressao";
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
                    sicas_historico_impressao.cd_carteira as sicas_historico_impressao_cd_carteira,
					sicas_historico_impressao.cd_pessoa as sicas_historico_impressao_cd_pessoa,
					sicas_historico_impressao.dt_impressao as sicas_historico_impressao_dt_impressao,
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
					sicas_pessoa.uf_identidade as sicas_pessoa_uf_identidade 
                from
                    usersicas.sicas_historico_impressao 
				left join usersicas.sicas_pessoa 
					on(sicas_historico_impressao.cd_pessoa = sicas_pessoa.cd_pessoa)
                where
                    sicas_historico_impressao.cd_pessoa like '$valor' 
					or sicas_historico_impressao.dt_impressao like '$valor'";
		// print "<pre>$sql</pre>";
		try {
			$this->oConexao->execute($sql);
			$aObj = array();
			if($this->oConexao->numRows()!= 0){
				while($aReg = $this->oConexao->fetchReg()){
					$aObj [] = SicasHistoricoImpressaoMAP::rsToObj($aReg);
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