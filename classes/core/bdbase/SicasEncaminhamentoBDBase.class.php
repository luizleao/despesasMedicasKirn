<?php
class SicasEncaminhamentoBDBase {
    public $oConexao;
    public $msg;
    public $joinTabelas;
    
    function __construct(Conexao $oConexao){
        $this->joinTabelas = "
                            usersicas.sicas_encaminhamento
                        left join usersicas.sicas_pessoa
        					on (sicas_encaminhamento.cd_pessoa = sicas_pessoa.cd_pessoa)
        				left join usersicas.sicas_medico
        					on (sicas_encaminhamento.cd_medico = sicas_medico.cd_medico)
                        left join usersicas.sicas_servidor
        					on (sicas_servidor.cd_servidor = sicas_medico.cd_servidor)
                        left join usersicas.sicas_lotacao
        					on (sicas_servidor.cd_lotacao = sicas_lotacao.cd_lotacao)
                        left join usersicas.sicas_lotacao lotacao_pai
        					on (sicas_lotacao.cd_lotacao_pai = lotacao_pai.cd_lotacao)
                        left join usersicas.rh_cargo
        					on (sicas_servidor.cd_cargo = rh_cargo.cd_cargo)
                        left join usersicas.sicas_pessoa pessoa_servidor
        					on (pessoa_servidor.cd_pessoa = sicas_servidor.cd_pessoa)
                        left join usersicas.sicas_pessoa_categoria categoria_servidor 
				           on (pessoa_servidor.cd_categoria = categoria_servidor.cd_categoria)
                        left join usersicas.sicas_estado_civil 
				           on (sicas_pessoa.cd_estado_civil = sicas_estado_civil.cd_estado_civil)
			            left join usersicas.sicas_pessoa_categoria 
				           on (sicas_pessoa.cd_categoria = sicas_pessoa_categoria.cd_categoria)
        				left join usersicas.sicas_consulta_medica
        					on (sicas_encaminhamento.cd_consulta_medica = sicas_consulta_medica.cd_consulta_medica)
                        left join usersicas.sicas_atendimento
        					on (sicas_atendimento.cd_atendimento = sicas_consulta_medica.cd_atendimento)
                        left join usersicas.sicas_tipo_atendimento
        					on (sicas_consulta_medica.cd_tipo_atendimento = sicas_tipo_atendimento.cd_tipo_atendimento)
        				left join usersicas.sicas_credenciado
        					on (sicas_encaminhamento.cd_credenciado = sicas_credenciado.cd_credenciado)
        				left join usersicas.sicas_tipo_despesa
        					on (sicas_encaminhamento.cd_tipo_despesa = sicas_tipo_despesa.cd_tipo_despesa)";
        try{
            $this->oConexao = $oConexao;
        }
        catch (PDOException $e){
            $this->msg = $e->getMessage();
        }
    }
    
    /**
     * Cadastrar instância da classe SicasEncaminhamento
     *
     * @param SicasEncaminhamento $oSicasEncaminhamento
     * @return integer|boolean
     */
    function inserir($oSicasEncaminhamento){
        $reg = SicasEncaminhamentoMAP::objToRs($oSicasEncaminhamento);
        $aCampo = array_keys($reg);
        $sql = "
				insert into usersicas.sicas_encaminhamento(
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
                return true;
            }
            catch(PDOException $e){
                $this->msg = $e->getMessage();
                return false;
            }
    }
    
    /**
     * Alterar instância da classe SicasEncaminhamento
     *
     * @param SicasEncaminhamento $oSicasEncaminhamento
     * @return boolean
     */
    function alterar($oSicasEncaminhamento){
        $reg = SicasEncaminhamentoMAP::objToRs($oSicasEncaminhamento);
        $sql = "
                update
                    usersicas.sicas_encaminhamento
                set
                    ";
        foreach($reg as $cv=>$vl){
            if($cv == "cd_encaminhamento") continue;
            $a[] = "$cv = :$cv";
        }
        $sql .= implode(",\n", $a);
        $sql .= "
                where
                    cd_encaminhamento = {$reg['cd_encaminhamento']}";
        
        foreach($reg as $cv=>$vl){
            if($cv == "cd_encaminhamento") continue;
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
    
    /**
     * Excluir instância da classe SicasEncaminhamento
     *
     * @param integer $cd_encaminhamento
     * @return boolean
     */
    function excluir($cd_encaminhamento){
        $sql = "
                delete from
                    usersicas.sicas_encaminhamento
                where
                    cd_encaminhamento = $cd_encaminhamento";
        
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
    
    /**
     * Retorna instância da classe SicasEncaminhamento
     *
     * @param integer $cd_encaminhamento
     * @return SicasEncaminhamento|boolean
     */
    function get($cd_encaminhamento){
        $sql = "
                select
					".SicasEncaminhamentoMAP::dataToSelect()."
                from
					{$this->joinTabelas}
                where
					sicas_encaminhamento.cd_encaminhamento = '$cd_encaminhamento'";
	    //Util::trace($sql);
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $oReg = $this->oConexao->fetchReg();
                return SicasEncaminhamentoMAP::rsToObj($oReg);
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
    
    /**
     * Retorna a lista de registros da tabela SicasEncaminhamento
     *
     * @param string[] $aFiltro
     * @param string[] $aOrdenacao
     * @param integer $qtd
     * @param integer $pagina
     * @return SicasEncaminhamento[]|boolean
     */
    function getAll($aFiltro=[], $aOrdenacao=[], $qtd = NULL, $pagina = NULL) {
        if($pagina != NULL){
            $sql = "
                   SELECT TOP($qtd) *
                      FROM(
                           SELECT
                    		row_number()OVER(ORDER BY sicas_encaminhamento.cd_encaminhamento ASC)AS row_number,
                            ".SicasEncaminhamentoMAP::dataToSelect()."
                        from
                            {$this->joinTabelas}
                          )tb
                     where
                        row_number > ".$qtd*($pagina-1);
        } else {
            $sql = "SELECT
                        ".SicasEncaminhamentoMAP::dataToSelect()."
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
            $aObj = [];
            if($this->oConexao->numRows()!= 0){
                while($aReg = $this->oConexao->fetchReg()){
                    $aObj[] = SicasEncaminhamentoMAP::rsToObj($aReg);
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
    
    /**
     * Consultar instâncias da classe SicasEncaminhamento
     *
     * @param string $valor
     * @return SicasEncaminhamento[]|boolean
     */
    function consultar($valor){
        $valor = Util::formataConsultaLike($valor);
        
        $sql = "
				select
					".SicasEncaminhamentoMAP::dataToSelect()."
				from
					{$this->joinTabelas}
                where
					".SicasEncaminhamentoMAP::filterLike($valor);
        
        //print "<pre>$sql</pre>";
        try{
            $this->oConexao->execute($sql);
            $aObj = array();
            if($this->oConexao->numRows() != 0){
                while ($oReg = $this->oConexao->fetchReg()){
                    $aObj[] = SicasEncaminhamentoMAP::rsToObj($oReg);
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
    
    /**
     * Retorna o total de instâncias da classe SicasEncaminhamento
     *
     * @return integer|boolean
     */
    function totalColecao(){
        $sql = "select count(*) from usersicas.sicas_encaminhamento";
        try{
            $this->oConexao->execute($sql);
            $oReg = $this->oConexao->fetchRow();
            return (int)$oReg[''];
        }
        catch(PDOException $e){
            $this->msg = $e->getMessage();
            return false;
        }
    }
}