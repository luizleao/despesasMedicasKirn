<?php
require ("WSDLCreator.php");

try {
	// informamos o nome do namespace e o endereco do arquivo WSDL
	$oWSDL = new WSDLCreator ( "RHWSDL", "http://localhost:8008/rh/ws/service2.wsdl" );
	
	// adicionamos a classe ControleWeb
	$oWSDL->addFile ( dirname(dirname(__FILE__)) . "/classes/class.ControleWS.php" );
	
	// agora indicamos a URL para acessar os metodos da classe Calculadora
	$oWSDL->addURLToClass ( "ControleWS", "http://localhost:8008/rh/ws/index2.php" );
	
	// criamos o arquivo WSDL
	$oWSDL->createWSDL ();
	
	// e o salvamos com o nome desejado
	$oWSDL->saveWSDL ( dirname(dirname(__FILE__)) . "/ws/service2.wsdl" );
} catch ( Exception $e ) {
	echo $e->getMessage ();
}
