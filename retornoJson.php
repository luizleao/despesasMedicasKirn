<?php
require_once("classes/autoload.php");

switch ($_REQUEST['acao']){
	case "consultarSicasServidor":
	    $oController = new ControllerSicasServidor();
		echo json_encode($oController->consultar(urldecode($_REQUEST['nm_pessoa']), $_REQUEST['servidor_ativo']));	
	break;
	
	case "getAllSicasServidor":
	    $oController = new ControllerSicasServidor();
		echo json_encode ($oController->getAll(["sicas_servidor.cd_categoria in (
                                                ".SicasPessoaCategoriaEnum::ATIVO_PERMANENTE.",
                                                ".SicasPessoaCategoriaEnum::REQUISITADO.",
                                                ".SicasPessoaCategoriaEnum::CARGO_EM_COMISSAO.",
                                                ".SicasPessoaCategoriaEnum::LOTACAO_PROVISORIA.",
                                                ".SicasPessoaCategoriaEnum::CONTRATO_TEMPORARIO.",
                                                ".SicasPessoaCategoriaEnum::SERVIDOR.")",
											   "sicas_servidor.status = 1"], 
											   ["sicas_pessoa.nm_pessoa"]));
	break;

	case "getAllSicasServidorLotacao":
	    $oController = new ControllerSicasServidor();
		echo json_encode ($oController->getAll(["sicas_lotacao.cd_lotacao = {$_REQUEST['cd_lotacao']}",
												"sicas_servidor.cd_categoria in (
                                                ".SicasPessoaCategoriaEnum::ATIVO_PERMANENTE.",
                                                ".SicasPessoaCategoriaEnum::REQUISITADO.",
                                                ".SicasPessoaCategoriaEnum::CARGO_EM_COMISSAO.",
                                                ".SicasPessoaCategoriaEnum::LOTACAO_PROVISORIA.",
                                                ".SicasPessoaCategoriaEnum::CONTRATO_TEMPORARIO.",
                                                ".SicasPessoaCategoriaEnum::SERVIDOR.")",
												"sicas_servidor.status = 1"],
												["sicas_pessoa.nm_pessoa"]));
	break;
		
	case 'getAllSicasPessoaCategoria':
	    $oController = new ControllerSicasPessoaCategoria();
		echo json_encode($oController->getAll([],["desc_categoria_abrev"]));
	break;
	
	case 'getAllSicasServidorFolhaFrequencia':
	    $oController = new ControllerSicasServidor();
		echo json_encode($oController->getAll(["sicas_lotacao.cd_lotacao={$_REQUEST['cd_lotacao']}",
											   "sicas_servidor.cd_categoria in (
                                                ".SicasPessoaCategoriaEnum::ATIVO_PERMANENTE.",
                                                ".SicasPessoaCategoriaEnum::REQUISITADO.",
                                                ".SicasPessoaCategoriaEnum::CARGO_EM_COMISSAO.",
                                                ".SicasPessoaCategoriaEnum::LOTACAO_PROVISORIA.",
                                                ".SicasPessoaCategoriaEnum::CONTRATO_TEMPORARIO.",
                                                ".SicasPessoaCategoriaEnum::SERVIDOR.")",
											   "sicas_servidor.status = 1"], 
		                                       ["sicas_pessoa.nm_pessoa"]));
	break;
	
	case 'consultarSicasLotacao':
	    $oController = new ControllerSicasLotacao();
		echo json_encode($oController->consultar(urldecode($_REQUEST['busca'])));
	break;
	
	case 'consultarRhCargo':
	    $oController = new ControllerRhCargo();
	    echo json_encode($oController->consultar(urldecode($_REQUEST['busca'])));
	break;

	case 'consultarRhCargoComissao':
	    $oController = new ControllerRhCargoComissao();
	    echo json_encode($oController->consultar(urldecode($_REQUEST['busca'])));
		//Util::trace($oController->consultarRhCargoComissao($_REQUEST['busca']));
	break;
	
	case 'consultarSicasPessoa':
	    $oController = new ControllerSicasPessoa();
	    echo json_encode($oController->consultar(urldecode($_REQUEST['busca'])));
	break;
	
	case 'consultarCredenciado':
	    $oController = new ControllerSicasCredenciado();
	    echo json_encode($oController->consultar(urldecode($_REQUEST['busca']), ["sicas_credenciado.nm_credenciado"]));
	break;
	
	case 'consultarCredenciadoAtivo':
	    $oController = new ControllerSicasCredenciado();
	    echo json_encode($oController->consultarCredenciadoAtivo(urldecode($_REQUEST['busca'])));
	    break;
	
	case 'consultarBeneficiario':
	    $oController = new ControllerSicasPessoa();
	    echo json_encode($oController->consultarBeneficiario(urldecode($_REQUEST['busca'])));
    break;
    
	case 'getAllProcedimentoPendenteCredenciado':
	    $oController = new ControllerSicasProcedimentoAutorizado();
	    echo json_encode($oController->getAllProcedimentoPendenteCredenciado($_REQUEST['cd_credenciado'], $_REQUEST['dataInicio'], $_REQUEST['dataFim']));
	    break;
	    
	case 'getAllFaturaCredenciado':
	    $oController = new ControllerSicasFatura();
	    echo json_encode($oController->getAllFaturaCredenciado($_REQUEST['cd_credenciado']));
	    break;
	    
	    
}