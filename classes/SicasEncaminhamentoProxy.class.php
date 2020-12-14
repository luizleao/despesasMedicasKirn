<?php
class SicasEncaminhamentoProxy extends SicasEncaminhamentoBDBase{
	
	public $msg;
	public $oConexao;
	
	function __construct($conexao = NULL) {
	    if (!$conexao)
	        $conexao = new Conexao ();
	        if ($conexao->msg != "") {
	            $this->msg = $conexao->msg;
	        } else {
	            parent::__construct ($conexao);
	        }
	}
    
	
	/**
	 * View que retorna dados dos encaminhamentos medicos dos servidores e seus dependentes
	 *
	 * @access public
     * @param string[] $aFiltro Filtro de consulta
     * @param string[] $aOrdenacao Ordenação dos campos
     * @param integer $pagina Numero da Pagina 
	 * @return SicasEncaminhamento[]
	 */
    public function viewEncaminhamentoServidorDependente($aFiltro=[], $aOrdenacao=[]){
        $sql = "SELECT 
                    *
                FROM 
                    usersicas.vw_encaminhamento_servidor_dependente";
                        
        if(count($aFiltro)> 0){
            $sql .= " where ";
            $sql .= implode(" and ", $aFiltro);
        }
        
        if(count($aOrdenacao)> 0){
            $sql .= " order by ";
            $sql .= implode(",", $aOrdenacao);
        }
        
        
        //Util::trace($sql);
        try {
            $this->oConexao->execute($sql);
            $aObj = [];
            if($this->oConexao->numRows()!= 0){
                while($aReg = $this->oConexao->fetchReg()){
                    $aObj[] = $aReg;
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