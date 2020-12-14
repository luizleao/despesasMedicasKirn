<?php
require_once("classes/autoload.php");

class PDF extends FPDF {
    public $aColunas = [60, 50, 30, 12, 15, 15, 15];
    public $oSicasFatura;
    
    function __construct(SicasFatura $oSicasFatura=NULL){
        $this->oSicasFatura = $oSicasFatura;
        parent::__construct();
    }
    
    // Page header
    function Header() {
        $this->Image('img/logo_sudam_peq.jpg', 100, 5, 0, 0, '', '');
        // Colors, line width and bold font
        $this->SetFont('Arial', '', 6);
        $this->SetLineWidth(.1);
        $this->SetFont('', 'B');
        
        $this->Cell(100, 15, '', 0, 0, 'C', false);
        $this->Ln();
        
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 6);
        $this->Cell(202, 6, utf8_decode('Superintendência do Desenvolvimento da Amazônia'), 0, 0, 'C', false);
        $this->Ln();
        $this->Cell(202, 6, utf8_decode('Fatura do Credenciado'), 0, 0, 'C', false);
        $this->Ln();
        $this->Cell(60, 6, utf8_decode('Credenciado:'), 0, 0, 'R', false);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(60, 6, utf8_decode($this->oSicasFatura->oSicasCredenciado->nm_credenciado), 0, 0, 'L', false);
        $this->SetFont('Arial', '', 6);
        $this->Cell(10, 6, utf8_decode('Nº Fatura: '), 0, 0, 'R', false);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(20, 6, utf8_decode($this->oSicasFatura->num_fatura), 0, 0, 'L', false);
        $this->SetFont('Arial', '', 6);
        $this->Ln();
        
        $header = ['Servidor', 'Beneficiário', 'Guia', 'Data', 'Quantidade', 'Vl. Unitario', 'Subtotal'];
        
        $this->SetFillColor(231, 231, 231);
        $this->SetDrawColor(211, 211, 211);
        $this->SetFont('Arial', 'B', 6);
        $this->SetTextColor(0);
        for($i = 0; $i < count($header); $i ++) {
            $this->Cell($this->aColunas[$i], 4, utf8_decode($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();
    }
    
    // Page footer
    function Footer() {
        $this->SetFont('Arial', '', 6);
        // Position at 1.5 cm from bottom
        $this->SetY(- 15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 6);
        // Page number
        $this->Cell(0, 10, utf8_decode('Página '.$this->PageNo().'/{nb}'), 0, 0, 'C');
    }
}

$oControllerFatura = new ControllerSicasFatura();
$oControllerDespesa = new ControllerSicasDespesa();

$oFatura = $oControllerFatura->get($_REQUEST['cd_fatura']);
$oPDF = new PDF($oFatura);
$oPDF->AliasNbPages();
$oPDF->AddPage('P');

// Color and font restoration
$oPDF->SetFillColor(231, 231, 231);
$oPDF->SetDrawColor(211, 211, 211);
$oPDF->SetFont('Arial', '', 6);
$oPDF->SetTextColor(0);

// Data
//$oPDF->Output(); //exit;

$aDespesa = $oControllerDespesa->getAll(["sicas_fatura.cd_fatura = {$_REQUEST['cd_fatura']}"], ['sicas_pessoa.nm_pessoa']);
//Util::trace($aDespesa);exit;

$oControllerProcedimentoAutorizado = new ControllerSicasProcedimentoAutorizado();
$oControllerSalario               = new ControllerSicasSalario();

$totalFatura = 0;

foreach($aDespesa as $oDespesa) {
    $oProcedimentoAutorizado = $oControllerProcedimentoAutorizado->get($oDespesa->oSicasProcedimentoAutorizado->cd_procedimento_autorizado);
    $oSalario                = $oControllerSalario->get($oDespesa->oSicasSalario->cd_salario);
    
    //Util::trace($oSalario); exit;
    
    if($oProcedimentoAutorizado->oSicasEncaminhamento->oSicasPessoa->cd_pessoa == $oSalario->oSicasServidor->oSicasPessoa->cd_pessoa){
        $nm_beneficiario = '-';
    } else {
        $nm_beneficiario = $oProcedimentoAutorizado->oSicasEncaminhamento->oSicasPessoa->nm_pessoa;
    }
    
    
    $oPDF->Cell($oPDF->aColunas[0], 4, utf8_decode($oSalario->oSicasServidor->oSicasPessoa->nm_pessoa),                                                       1, 0, 'L', false);
    $oPDF->Cell($oPDF->aColunas[1], 4, utf8_decode($nm_beneficiario), 					                                                                      1, 0, 'L', false);
    $oPDF->Cell($oPDF->aColunas[2], 4, utf8_decode(Util::formataEncaminhamento($oProcedimentoAutorizado->oSicasEncaminhamento->cd_encaminhamento)),           1, 0, 'L', false);
    $oPDF->Cell($oPDF->aColunas[3], 4, utf8_decode(Util::formataDataHoraBancoForm($oProcedimentoAutorizado->oSicasEncaminhamento->dt_encaminhamento, false)), 1, 0, 'L', false);
    $oPDF->Cell($oPDF->aColunas[4], 4, utf8_decode($oDespesa->qtd_servico_realizado),                                                                         1, 0, 'L', false);
    $oPDF->Cell($oPDF->aColunas[5], 4, utf8_decode(Util::formataMoeda($oDespesa->val_servico_realizado)), 					                                  1, 0, 'R', false);
    $oPDF->Cell($oPDF->aColunas[6], 4, utf8_decode(Util::formataMoeda($oDespesa->qtd_servico_realizado * $oDespesa->val_servico_realizado)),                  1, 0, 'R', false);
    
    $oPDF->Ln();
    
    $totalFatura += $oDespesa->qtd_servico_realizado * $oDespesa->val_servico_realizado;
}

//impressao da ultima linha de total computada
$oPDF->SetFont('Arial', 'B', 6);
$oPDF->Cell($oPDF->aColunas[0], 4, utf8_decode("Total da Fatura"),  1, 0, 'L', false);
//$oPDF->Cell($oPDF->aColunas[1]+$oPDF->aColunas[2]+$oPDF->aColunas[3]+$oPDF->aColunas[4]+$oPDF->aColunas[5], 4, utf8_decode(Util::formataMoeda($oFatura->vl_fatura)), 1, 0, 'R', false);
//$oPDF->Ln();
//$oPDF->Cell($oPDF->aColunas[0], 4, utf8_decode("Total da Soma dos Procedimentos"),  1, 0, 'L', false);
$oPDF->Cell($oPDF->aColunas[1]+$oPDF->aColunas[2]+$oPDF->aColunas[3]+$oPDF->aColunas[4]+$oPDF->aColunas[5]+$oPDF->aColunas[6], 4, utf8_decode(Util::formataMoeda($totalFatura)), 1, 0, 'R', false);
$oPDF->Ln();

$oPDF->Output();