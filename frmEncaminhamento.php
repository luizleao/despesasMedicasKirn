<?php
require_once("classes/autoload.php");
require_once("classes/phpqrcode/qrlib.php");

$oController = new ControllerSicasEncaminhamento();
$oControllerDependente = new ControllerSicasDependente();

class PDF extends FPDF {
    public $oSicasEncaminhamento;
    function __construct(SicasEncaminhamento $oSicasEncaminhamento=NULL){
        parent::__construct();
        
        $this->oSicasEncaminhamento = $oSicasEncaminhamento;
    }
    
    // Page header
	function Header() {
	    $this->Image('img/logo_sudam_peq.jpg', 10, 8, 0, 0, '', '');
	    $this->Image('img/logo_republica.png', 185, 8, 0, 0, '', '');
	    // Colors, line width and bold font
	    $this->SetFont('Arial', '', 8);
	    $this->SetLineWidth(.1);
	    $this->SetFont('', 'B');

	    $this->SetTextColor(0);
	    $this->SetFont('Arial', '', 8);
	    $this->Cell(180, 4, utf8_decode('MINISTÉRIO DO DESENVOLVIMENTO REGIONAL'), 0, 0, 'C', false);
	    $this->Ln();
	    $this->Cell(180, 4, utf8_decode('SUPERINTENDÊNCIA DO DESENVOLVIMENTO DA AMAZÔNIA - SUDAM'), 0, 0, 'C', false);
	    $this->Ln();
	    $this->Cell(180, 4, utf8_decode('DIRETORIA DE ADMINISTRAÇÃO - DIRAD'), 0, 0, 'C', false);
	    $this->Ln();
	    $this->Cell(180, 4, utf8_decode('COORDENAÇÃO E GESTÃO DE PESSOAS - CGP'), 0, 0, 'C', false);
	    $this->Ln();
	    $this->Cell(180, 4, utf8_decode('SERVIÇO DE ASSISTÊNCIA MÉDICA E SOCIAL - SAMS'), 0, 0, 'C', false);
	    $this->Ln();
	    $this->Ln();
	}
	
	// Page footer
	function Footer() {
	    $h = 6;
	    $hFoto = 250;
	    $semBorda = 0;
	    // Gerando QRCode
	    $filename = 'img/qrcodeEncaminhamento.png';
	    QRcode::png("http://www.sudam.gov.br/validaEncaminhamento/?codigo=".md5($_REQUEST['cd_encaminhamento']), $filename);
	    
	    $this->Image($filename, $h, $hFoto, 0, 0, '', '');
	    $this->SetY(-40);
	    $this->linhaVazia($this, $h);
	    $this->Cell(30, $h, utf8_decode(" "), $semBorda, 0, 'L', false);
	    $this->Cell(53, $h, utf8_decode("Documento assinado eletronicamente por "), $semBorda, 0, 'L', false);
	    $this->SetFont('Arial', 'B', 8);
	    // Checar se ocupa cargo em comissao
	    $oControllerCargoComissao = new ControllerRhCargoComissao();
	    $oCargo = $oControllerCargoComissao->getByServidor($this->oSicasEncaminhamento->oSicasMedico->oSicasServidor->cd_servidor);
	    
	    $cargo = ($oCargo) ? $oCargo->descricao : $this->oSicasEncaminhamento->oSicasMedico->oSicasServidor->oRhCargo->descricao_cargo;
	    
	    $this->Cell(50, $h, utf8_decode($this->oSicasEncaminhamento->oSicasMedico->oSicasServidor->oSicasPessoa->nm_pessoa.", ".$cargo), $semBorda, 0, 'L', false);
	    $this->linhaVazia(4);
	    $this->SetFont('Arial', '', 8);
	    $this->Cell(30, $h, utf8_decode(""), $semBorda, 0, 'L', false);
	    $this->Cell(30, $h, utf8_decode("em ".Util::formataDataHoraBancoForm($this->oSicasEncaminhamento->dt_encaminhamento).", conforme horário oficial de Brasília, com fundamento no art. 6º, §1º, "), $semBorda, 0, 'L', false);
	    $this->linhaVazia(4);
	    $this->Cell(30, $h, utf8_decode(""), $semBorda, 0, 'L', false);
	    $this->Cell(30, $h, utf8_decode("do decreto nº 8.539, de 8 de Outubro de 2015."), $semBorda, 0, 'L', false);
	    $this->linhaVazia(4);
	    $this->Cell(30, $h, utf8_decode(""), $semBorda, 0, 'L', false);
	    $this->Cell(30, $h, utf8_decode("A autenticidade desse documento pode ser conferida no site http://www.sudam.gov.br/validaEncaminhamento/ ,"), $semBorda, 0, 'L', false);
	    $this->linhaVazia(4);
	    $this->Cell(30, $h, utf8_decode(" "), $semBorda, 0, 'L', false);
	    $this->Cell(45, $h, utf8_decode("informando o Código de Validação: "), $semBorda, 0, 'L', false);
	    $this->SetFont('Arial', 'B', 8);
	    $this->Cell(30, $h, utf8_decode(md5($_REQUEST['cd_encaminhamento'])), $semBorda, 0, 'L', false);
	    $this->SetFont('Arial', '', 8);
	    unlink($filename);
	    
	    $this->SetY(-10);
	    // Arial italic 8
	    $this->SetDrawColor(0, 0, 0);
	    $this->Line(10, 285, 205, 285);
	    $this->SetFont('Arial','',8);
	    $this->Cell(140, 4, utf8_decode('Emitido por: '.$_SESSION['usuarioAtual']['login']), 0, 0, 'L', false);
	    $this->Cell(50, 4, utf8_decode('Data da Emissão: '.date('d/m/Y H:i:s')), 0, 0, 'L', false);
	}
	
	function linhaVazia($ln){
	    $this->Cell(90, $ln, " ",  0, 0, 'L', false);
	    $this->Ln();
	}
}

$oEncaminhamento = $oController->get($_REQUEST['cd_encaminhamento']); //352
//Util::trace($oEncaminhamento);

$oControllerServidor = new ControllerSicasServidor();
$oServidor = $oControllerServidor->getByPessoa($oEncaminhamento->oSicasPessoa->cd_pessoa);
//Util::trace($oServidor);

$oPDF = new PDF($oEncaminhamento);
$oPDF->AddPage();

$hFoto = 40;
$oPDF->Image('img/moldura_report.png', 5, $hFoto, 0, 0, '', '');

// Color and font restoration
$oPDF->SetFillColor(231, 231, 231);
$oPDF->SetDrawColor(211, 211, 211);
$oPDF->SetFont('Arial', '', 8);
$oPDF->SetTextColor(0);
/*
 * $oPDF->SetFillColor(255,250,250);
 * $oPDF->SetTextColor(0);
 * $oPDF->SetFont('');
 */ 

if(!$oServidor){
    $oDependente = $oControllerDependente->getByPessoa($oEncaminhamento->oSicasPessoa->cd_pessoa);
    $oControllerServidor = new ControllerSicasServidor();
    $oServidor = $oControllerServidor->get($oDependente->oSicasServidor->cd_servidor);
    //Util::trace($oDependente); exit;
}
//Util::trace($oEncaminhamento); exit;
$h = 4;
$semBorda = 0;
$borda = 1;

$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(180, $h, utf8_decode('GUIA DE ENCAMINHAMENTO'), $semBorda, 0, 'C', false);
$oPDF->Cell(10, $h, utf8_decode(Util::formataEncaminhamento($oEncaminhamento->cd_encaminhamento)), $semBorda, 0, 'R', false);

$oPDF->linhaVazia(5);
$oPDF->SetFont('Arial', '', 8);
$oPDF->SetFillColor(255, 255, 255);
$oPDF->Cell(22, $h, utf8_decode("BENEFICIÁRIO"), $semBorda, 0, 'L', true);

$oPDF->linhaVazia(5);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, "Servidor: ", $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(69, $h, utf8_decode($oServidor->oSicasPessoa->nm_pessoa), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, utf8_decode("Matrícula: "), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(50, $h, utf8_decode($oServidor->cd_matricula), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(15, $h, utf8_decode("Idade: "), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(69, $h, utf8_decode(Util::calculaIdade($oEncaminhamento->oSicasPessoa->dt_nascimento)), $semBorda, 0, 'L', false);

if($oDependente){
    $oPDF->linhaVazia(5);
    $oPDF->SetFont('Arial', 'B', 8);
    $oPDF->Cell(20, $h, "Dependente: ", $semBorda, 0, 'L', false);
    $oPDF->SetFont('Arial', '', 8);
    $oPDF->Cell(69, $h, utf8_decode($oDependente->oSicasPessoa->nm_pessoa), $semBorda, 0, 'L', false);
    $oPDF->linhaVazia(5);
    $oPDF->SetFont('Arial', 'B', 8);
    $oPDF->Cell(20, $h, utf8_decode("Dependência: "), $semBorda, 0, 'L', false);
    $oPDF->SetFont('Arial', '', 8);
    $oPDF->Cell(69, $h, utf8_decode($oDependente->oSicasGrauParentesco->desc_grauparentesco), $semBorda, 0, 'L', false);
}
$oPDF->linhaVazia(5);

$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, "Telefone: ", $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(29, $h, utf8_decode(Util::formataTelefone($oEncaminhamento->oSicasPessoa->telefone)), $semBorda, 0, 'L', false);
$oPDF->linhaVazia(5);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, utf8_decode("Endereço:"), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(69, $h, utf8_decode($oEncaminhamento->oSicasPessoa->endereco), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, utf8_decode("CEP:"), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(87, $h, utf8_decode(Util::formataCEP($oEncaminhamento->oSicasPessoa->cep)), $semBorda, 0, 'L', false);
$oPDF->linhaVazia(5);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, utf8_decode("Bairro:"), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(69, $h, utf8_decode($oEncaminhamento->oSicasPessoa->bairro), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, utf8_decode("Cidade/UF:"), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(30, $h, utf8_decode($oEncaminhamento->oSicasPessoa->cidade)."/".$oEncaminhamento->oSicasPessoa->uf, $semBorda, 0, 'L', false);
$oPDF->linhaVazia((($oDependente) ? 15 : 25));

$hFoto = 85;
$oPDF->Image('img/moldura_report.png', 5, $hFoto, 0, 0, '', '');

$oPDF->SetFont('Arial', '', 8);
$oPDF->SetFillColor(255, 255, 255);
$oPDF->Cell(22, $h, utf8_decode("CREDENCIADO"), $semBorda, 0, 'L', true);

$oPDF->linhaVazia(6);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, utf8_decode("Credenciado:"), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(69, $h, utf8_decode($oEncaminhamento->oSicasCredenciado->nm_credenciado), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, "Telefone: ", $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(29, $h, utf8_decode(Util::formataTelefone($oEncaminhamento->oSicasCredenciado->telefone1)), $semBorda, 0, 'L', false);
$oPDF->linhaVazia(5);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, utf8_decode("Endereço:"), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(69, $h, utf8_decode($oEncaminhamento->oSicasCredenciado->endereco), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, "Telefone: ", $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(29, $h, utf8_decode(Util::formataTelefone($oEncaminhamento->oSicasCredenciado->telefone2)), $semBorda, 0, 'L', false);
$oPDF->linhaVazia(5);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, utf8_decode("Bairro:"), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(69, $h, utf8_decode($oEncaminhamento->oSicasCredenciado->bairro), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(20, $h, utf8_decode("Cidade/UF:"), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(50, $h, utf8_decode($oEncaminhamento->oSicasCredenciado->cidade)."/".$oEncaminhamento->oSicasCredenciado->uf, $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(15, $h, utf8_decode("CEP:"), $semBorda, 0, 'L', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(87, $h, utf8_decode(Util::formataCEP($oEncaminhamento->oSicasCredenciado->cep)), $semBorda, 0, 'L', false);
$oPDF->linhaVazia(30);

//$oPDF->SetFillColor(231, 231, 231);
$oPDF->SetDrawColor(200, 200, 200);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell(194, 6, utf8_decode("Procedimentos Autorizados"), $borda, 0, 'C', true);

$oControllerSicasProcedimentoAutorizado = new ControllerSicasProcedimentoAutorizado();
$aProcedimentoAutorizado = $oControllerSicasProcedimentoAutorizado->getAll(["sicas_encaminhamento.cd_encaminhamento='{$_REQUEST['cd_encaminhamento']}'"], []);
$oPDF->linhaVazia(6);
$oPDF->Cell(50, 6, utf8_decode("Quantidade"), $borda, 0, 'C', true);
$oPDF->Cell(50, 6, utf8_decode("Código"), $borda, 0, 'C', true);
$oPDF->Cell(94, 6, utf8_decode("Procedimento"), $borda, 0, 'C', true);

$h=6;
$count=0;
foreach($aProcedimentoAutorizado as $oProcedimentoAutorizado){
    $oPDF->linhaVazia($h);
    $oPDF->SetFont('Arial', '', 8);
    $oPDF->Cell(50, $h, utf8_decode($oProcedimentoAutorizado->qtd_servico_autorizado), $borda, 0, 'C', true);
    $oPDF->Cell(50, $h, Util::formataNumProcedimento($oProcedimentoAutorizado->oSicasProcedimento->num_procedimento), $borda, 0, 'C', true);
    $oPDF->Cell(94, $h, utf8_decode($oProcedimentoAutorizado->oSicasProcedimento->nm_procedimento), $borda, 0, 'C', true);
    $count++;
}

if($oEncaminhamento->observacao != ''){
    $oPDF->linhaVazia(12);
    $oPDF->SetFont('Arial', 'B', 8);
    $oPDF->Cell(30, $h, utf8_decode("Observação: "), $semBorda, 0, 'L', false);
    $oPDF->SetFont('Arial', '', 8);
    $oPDF->MultiCell(0,5,utf8_decode($oEncaminhamento->observacao));
    //$oPDF->Cell(100, $h, utf8_decode($oEncaminhamento->observacao), $semBorda, 0, 'L', false);
}

$oPDF->linhaVazia(60 + ($count)*$h);
//$semBorda = 1;
$oPDF->SetFont('Arial', '', 8);
$oPDF->Cell(30, $h, utf8_decode("Data de Expedição: "), $semBorda, 0, 'L', false);
$oPDF->Cell(100, $h, utf8_decode(Util::formataDataHoraBancoForm($oEncaminhamento->dt_encaminhamento, false)), $semBorda, 0, 'L', false);
$oPDF->linhaVazia($h);
$oPDF->Cell(30, $h, utf8_decode("Data de Validade: "), $semBorda, 0, 'L', false);
$oPDF->Cell(100, $h, utf8_decode(Util::formataDataHoraBancoForm(Util::getDataPosterior($oEncaminhamento->dt_encaminhamento,30), false)), $semBorda, 0, 'L', false);
$oPDF->linhaVazia($h);
$oPDF->Cell(30, $h, utf8_decode("Data de Atendimento: "), $semBorda, 0, 'L', false);
$oPDF->Cell(100, $h, utf8_decode("____/_____/________"), $semBorda, 0, 'L', false);

$oPDF->Output();