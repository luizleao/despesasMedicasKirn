<?php
class SicasParamDesconto {
	public $cd_param_desc;
	public $descricao_param;
	public $percentagem_desconto;
	public $status;
	function __construct($cd_param_desc = NULL, $descricao_param = NULL, $percentagem_desconto = NULL, $status = NULL) {
		$this->cd_param_desc = $cd_param_desc;
		$this->descricao_param = $descricao_param;
		$this->percentagem_desconto = $percentagem_desconto;
		$this->status = $status;
	}
}