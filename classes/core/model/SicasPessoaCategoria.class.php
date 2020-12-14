<?php
class SicasPessoaCategoria {
	public $cd_categoria;
	public $desc_categoria;
	public $desc_categoria_abrev;
	function __construct($cd_categoria = NULL, $desc_categoria = NULL, $desc_categoria_abrev = NULL) {
		$this->cd_categoria = $cd_categoria;
		$this->desc_categoria = $desc_categoria;
		$this->desc_categoria_abrev = $desc_categoria_abrev;
	}
	function __toString() {
		return $this->desc_categoria;
	}
}