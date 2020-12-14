<?php
require_once '../classes/autoload.php';
// $oClient = new SoapClient("http://localhost:8008/rh/ws/?wsdl");
$oClient = new SoapClient(null, array("location" => "http://rh.sudam.intra/ws/", //"location" => "http://172.16.107.84/ws/",//
							          "uri"	    => "http://ws-rh/"));
Util::trace($oClient);
//$retornoWS = $oClient->getSicasPessoaPorNome('RUBENS GOMES MESQUITA');

//$retornoWS = $oClient->getSicasServidorPessoa(637);

//$retornoWS = $oClient->getAllSicasPessoaCategoria();
//$retornoWS = $oClient->getSicasPessoaCategoria(1);

//echo "month(sicas_pessoa.dt_nascimento) = ".date('m');
/*
$retornoWS = $oClient->getAllSicasPessoa(["month(sicas_pessoa.dt_nascimento) = '".date('m')."'", 
										  "sicas_pessoa.tipo_beneficiario = 'S'",
										  "sicas_pessoa.status = 1"],
										 ["day(sicas_pessoa.dt_nascimento)",
										 "sicas_pessoa.nm_pessoa"]);

echo "<pre>"; 
foreach ($retornoWS as $obj)  
	echo date("d", strtotime($obj->dt_nascimento))."\t".$obj->nm_pessoa."\n"; 
echo "</pre>";
*/

$retornoWS = $oClient->getSicasEncaminhamentoByValidacao("9fd2f9eb79fed5878fa8ff26d033b60f");
print "<pre>"; 	print_r ($retornoWS); print "</pre>";

//$retornoWS = $oClient->consultarRhServidorRamal('Luiz');
//print "<pre>"; 	print_r (SicasServidorMAP::wsToObj($retornoWS)); print "</pre>";

//$oController = new Controller();

//$a = $oController->consultarRhServidorRamal('5404');
//print "<pre>"; 	print_r($a); print "</pre>";