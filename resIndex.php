<?php
require_once(dirname(__FILE__)."/classes/autoload.php");

foreach($_POST as $campo => $valor){
	$$campo = trim ($valor);
}
$oController = new Controller();

print ($oController->autenticaUsuario($login, $senha)) ? "" : $oController->msg;
