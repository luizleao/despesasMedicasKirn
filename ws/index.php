<?php
require_once "../classes/autoload.php";

$server = new SoapServer(null, array('uri' => "http://ws-rh/"));
//$server = new SoapServer("service.wsdl");

$server->setClass('ControleWS');
$server->handle();
