<?php
class SicasFaturaBD extends SicasFaturaBDBase{
    function __construct($conexao = NULL){
        if(!$conexao) 
            $conexao = new Conexao();
        if($conexao->msg != ""){
            $this->msg = $conexao->msg;
        } else {
            parent::__construct($conexao);
        }
    }
	
    /**
     * Retorna instância da classe SicasFatura por num fatura do credenciado
     *
     * @param string $num_fatura
     * @param integer $cd_credenciado
     * @return SicasFatura|boolean
     */
    function getByFaturaCredenciado($num_fatura, $cd_credenciado){
        $sql = "
                select
					".SicasFaturaMAP::dataToSelect()."
                from
					usersicas.sicas_fatura
				left join usersicas.sicas_credenciado
					on (sicas_fatura.cd_credenciado = sicas_credenciado.cd_credenciado)
                where
					sicas_fatura.num_fatura              = '$num_fatura'
                    and sicas_credenciado.cd_credenciado = $cd_credenciado";
        try{
            $this->oConexao->execute($sql);
            if($this->oConexao->numRows() != 0){
                $oReg = $this->oConexao->fetchReg();
                return SicasFaturaMAP::rsToObj($oReg);
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
}