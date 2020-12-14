<?php
require_once 'classes/autoload.php';
/*
require_once 'classes/ControleWS.class.php';
$oControle = new ControleWS();

$post = ["nm_pessoa" => "Coca Litro da Silvia",
		"cpf" => "111.111.111-11",
		"genero" => "M",
		"identidade" => "3672168",
		"nm_orgao_emissor" => "PC",
		"uf_identidade" => "PA",
		"dt_emissao" => "10/11/2016",
		"dt_nascimento" => "10/11/2016",
		"telefone" => '',
		"classe" => "SicasPessoa",
		"cd_estado_civil" => 1,
		"tipo_beneficiario" => 'V',
		"status" => 1
];

echo $oController->cadastraSicasPessoa($post);
echo $oController->msg;
*/

//$oController = new ControllerSicasEncaminhamento();
//$aux = $oController->getByValidacao("9fd2f9eb79fed5878fa8ff26d033b60f");
//Util::trace($aux);

//$data = new DateTime();
//Util::trace((new DateTime())->format('Y-m-d H:i:s.v'));


//$oController = new ControllerSicasEncaminhamento();

//Util::trace(Util::formataEncaminhamento($oController->gerarCodigoEncaminhamento(601)));

//Util::trace(SicasEncaminhamentoMAP::getMetaData());

/*
$reflection = new ReflectionClass('ControllerSicasPessoa');
$aMetodo = $reflection->getMethods();
Util::trace($reflection);

//Util::trace($reflection->getDefaultProperties());
Util::trace($reflection->getDocComment());

foreach($aMetodo as $metodo){
    Util::trace($metodo);
    Uti::trace($metodo);
}
*/
//$oController = new ControllerSicasEncaminhamento();
//Util::trace(Util::formataEncaminhamento($oController->gerarCodigoEncaminhamento(187)));

//$oController = new ControllerSicasServidor();
//$oServidor = $oController->get(227);

// $flagServidorEfetivo = $oServidor->serv_efetivo; 
// $flagDependente = false; 
// $flagInternacao = false; 
// $salarioServidor = 6400.00;

//Util::trace((new ControllerSicasSalario())->getAtualByServidor(227));

//echo Calculadora::getDescontoServidor(556, false);


$oController = new ControllerSicasSalario();
$oSalario = $oController->getAtualByServidor(227);
echo Calculadora::getValorProasServidor($oSalario);

//11192

// $oController = new ControllerSicasSalario();

// Util::trace($oController->getAtualByPessoaDependente(671));
// Util::trace($oController->getAtualByPessoaServidor(637));

// $numFatura = '07/2020';
// $cd_credenciado = 18;
// $oController = new ControllerSicasFatura();

// $oSicasFatura = $oController->getByFaturaCredenciado($numFatura, $cd_credenciado);

// if(!$oSicasFatura)
//     print "Não existe";
// else
//     Util::trace($oSicasFatura);
// $ws = new ControleWS();
// Util::trace($ws->consultarSicasServidorRamal('Doris'));




