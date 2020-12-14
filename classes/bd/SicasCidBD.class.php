<?php
class SicasCidBD extends SicasCidBDBase {
	function __construct($conexao = NULL) {
		if (! $conexao)
			$conexao = new Conexao ();
		if ($conexao->msg != "") {
			$this->msg = $conexao->msg;
		} else {
			parent::__construct ( $conexao );
		}
	}
}