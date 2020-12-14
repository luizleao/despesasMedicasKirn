<?php
require_once "../classes/autoload.php";

$server = new SoapServer(null, array('uri' => "http://encaminhamentoWS/"));
//$server = new SoapServer("service.wsdl");

$server->setClass('ControllerSicasEncaminhamento');
$server->handle();
