<?php
class SicasGrauParentesco {
	public $cd_grau_parentesco;
	public $desc_grauparentesco;
	public $nm_grau_parentesco;
	public $status;
	function __construct($cd_grau_parentesco = NULL, $desc_grauparentesco = NULL, $nm_grau_parentesco = NULL, $status = NULL) {
		$this->cd_grau_parentesco = $cd_grau_parentesco;
		$this->desc_grauparentesco = $desc_grauparentesco;
		$this->nm_grau_parentesco = $nm_grau_parentesco;
		$this->status = $status;
	}
}