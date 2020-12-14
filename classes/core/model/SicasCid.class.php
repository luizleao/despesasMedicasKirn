<?php
class SicasCid {
	public $cd_cid;
	public $desc_cid;
	public $desc_cid_abrev;
	public $oCid_pai;
	function __construct($cd_cid = NULL, $desc_cid = NULL, $desc_cid_abrev = NULL, SicasCid $oCid_pai = NULL) {
		$this->cd_cid = $cd_cid;
		$this->desc_cid = $desc_cid;
		$this->desc_cid_abrev = $desc_cid_abrev;
		$this->oCid_pai = $oCid_pai;
	}
}