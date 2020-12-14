<?php
class SicasEncaminhamentoBD extends SicasEncaminhamentoBDBase {
	function __construct($conexao = NULL) {
		if (! $conexao)
			$conexao = new Conexao ();
		if ($conexao->msg != "") {
			$this->msg = $conexao->msg;
		} else {
			parent::__construct ( $conexao );
		}
	}
	
	
	/**
	 * Retorna instância da classe SicasEncaminhamento pelo codigo de validacao
	 *
	 * @param integer $cd_validacao
	 * @return SicasEncaminhamento|boolean
	 */
	function getByValidacao($cd_validacao){
	    $sql = "
                select
					".SicasEncaminhamentoMAP::dataToSelect()."
                from
					{$this->joinTabelas}
                where
					sicas_encaminhamento.cd_validacao = '$cd_validacao'";
		
	   // Util::trace($sql);
		
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
}