<?php
class RhCargoComissao {
    public $cd_cargo_comissao;
    public $oSicasLotacao;
    public $oSicasServidor;
	public $descricao;
	public $das;
    public $status;
    
	function __construct($cd_cargo_comissao = NULL, SicasLotacao $oSicasLotacao = NULL, SicasServidor $oSicasServidor = NULL, $descricao = NULL, $das = NULL, $status = NULL) {
        $this->cd_cargo_comissao = $cd_cargo_comissao;
        $this->oSicasLotacao = $oSicasLotacao;
        $this->oSicasServidor = $oSicasServidor;
        $this->descricao = $descricao;
        $this->das = $das;
		$this->status = $status;
	}
}