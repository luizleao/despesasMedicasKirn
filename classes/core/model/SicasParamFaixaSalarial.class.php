<?php
class SicasParamFaixaSalarial {
	public $cd_param_faixa_sal;
	public $val_faixa_inicial;
	public $flg_faixa_ini_inclusive;
	public $val_faixa_final;
	public $flg_faixa_fin_inclusive;
	public $percentagem_desconto;
	public $status;
	function __construct($cd_param_faixa_sal = NULL, $val_faixa_inicial = NULL, $flg_faixa_ini_inclusive = NULL, $val_faixa_final = NULL, $flg_faixa_fin_inclusive = NULL, $percentagem_desconto = NULL, $status = NULL) {
		$this->cd_param_faixa_sal = $cd_param_faixa_sal;
		$this->val_faixa_inicial = $val_faixa_inicial;
		$this->flg_faixa_ini_inclusive = $flg_faixa_ini_inclusive;
		$this->val_faixa_final = $val_faixa_final;
		$this->flg_faixa_fin_inclusive = $flg_faixa_fin_inclusive;
		$this->percentagem_desconto = $percentagem_desconto;
		$this->status = $status;
	}
}