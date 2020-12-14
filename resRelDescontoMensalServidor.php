<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasDespesa();

class PDF extends FPDF {
    public $aColunas = [50, 50, 30, 35, 65, 12, 10, 12, 8, 10];
    // Page header
    function Header() {
        $this->Image('img/logo_sudam_peq.jpg', 140, 5, 0, 0, '', '');
        // Colors, line width and bold font
        $this->SetFont('Arial', '', 6);
        $this->SetLineWidth(.1);
        $this->SetFont('', 'B');
        
        $this->Cell(100, 15, '', 0, 0, 'C', false);
        $this->Ln();
        
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 6);
        $this->Cell(282, 6, utf8_decode('Superintendência do Desenvolvimento da Amazônia'), 0, 0, 'C', false);
        $this->Ln();
        $this->Cell(282, 6, utf8_decode('Relatório de Desconto Mensal'), 0, 0, 'C', false);
        $this->Ln();
        $this->Cell(130, 6, utf8_decode(''), 0, 0, 'C', false);
        $this->Cell(10, 6, utf8_decode('Período: '), 0, 0, 'R', false);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(20, 6, utf8_decode(Util::formataDataBancoForm($_REQUEST['mesAno'])), 0, 0, 'L', false);
        $this->SetFont('Arial', '', 6);
        $this->Ln();
        
        $header = ['Servidor', 'Beneficiário', 'Guia', 'Credenciado', 'Procedimento', 'Data', 'Valor', 'Salário', '%', 'Desconto'];
        
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

$oPDF = new PDF();
$oPDF->AliasNbPages();
$oPDF->AddPage('L');

// Color and font restoration
$oPDF->SetFillColor(231, 231, 231);
$oPDF->SetDrawColor(211, 211, 211);
$oPDF->SetFont('Arial', '', 6);
$oPDF->SetTextColor(0);
/*
 * $oPDF->SetFillColor(255,250,250);
 * $oPDF->SetTextColor(0);
 * $oPDF->SetFont('');
 */
// Data
$aFiltro[] = "sicas_despesa.mes_ano_desconto = '{$_REQUEST['mesAno']}-01'";

if($_REQUEST['cd_servidor'] != '')
    $aFiltro[] = "sicas_servidor.cd_servidor = {$_REQUEST['cd_servidor']}";

$aDespesa = $oController->getAll($aFiltro, ['sicas_pessoa.nm_pessoa']);
//Util::trace($aDespesa);exit;

$oControllerProcedimentoAutorizado = new ControllerSicasProcedimentoAutorizado();
$oControllerServidor               = new ControllerSicasServidor();
$oControllerEncaminhamento         = new ControllerSicasEncaminhamento();

$servidorAtual = NULL;
$totalDesconto = 0;
$totalGeralDesconto = 0;

if($aDespesa){
    foreach($aDespesa as $oDespesa) {
        $oProcedimentoAutorizado = $oControllerProcedimentoAutorizado->get($oDespesa->oSicasProcedimentoAutorizado->cd_procedimento_autorizado);
        $oServidor               = $oControllerServidor->get($oDespesa->oSicasSalario->oSicasServidor->cd_servidor);
        $oEncaminhamento         = $oControllerEncaminhamento->get($oProcedimentoAutorizado->oSicasEncaminhamento->cd_encaminhamento);
    //     if($servidorAtual == NULL) {
    //         $servidorAtual = $oDespesa->oSicasSalario->oSicasServidor->cd_servidor;
    //     } elseif($servidorAtual = $oDespesa->oSicasSalario->oSicasServidor->cd_servidor) 
        
        //Util::trace($oProcedimentoAutorizado); exit;
        
        
        if($oProcedimentoAutorizado->oSicasEncaminhamento->oSicasPessoa->cd_pessoa == $oServidor->oSicasPessoa->cd_pessoa){
            $nm_beneficiario = '-';  
        } else {
            $nm_beneficiario = $oProcedimentoAutorizado->oSicasEncaminhamento->oSicasPessoa->nm_pessoa;
        }
    
        if($servidorAtual != NULL && $servidorAtual != $oDespesa->oSicasSalario->oSicasServidor->cd_servidor){
            $oPDF->SetFont('Arial', 'B', 6);
            $oPDF->Cell($oPDF->aColunas[0], 4, utf8_decode("Total de Desconto"),  1, 0, 'L', false);
            $oPDF->Cell($oPDF->aColunas[1]+$oPDF->aColunas[2]+$oPDF->aColunas[3]+$oPDF->aColunas[4]+$oPDF->aColunas[5]+$oPDF->aColunas[6]+$oPDF->aColunas[7]+$oPDF->aColunas[8]+$oPDF->aColunas[9], 4, utf8_decode(Util::formataMoeda($totalDesconto)), 1, 0, 'R', false);
            $oPDF->SetFont('Arial', '', 6);
            $oPDF->Ln();
            $totalDesconto = 0;
        }
        
        $oPDF->Cell($oPDF->aColunas[0], 4, utf8_decode($oServidor->oSicasPessoa->nm_pessoa),                                                                        1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[1], 4, utf8_decode($nm_beneficiario), 					                                                                        1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[2], 4, utf8_decode(Util::formataEncaminhamento($oProcedimentoAutorizado->oSicasEncaminhamento->cd_encaminhamento)),             1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[3], 4, substr(utf8_decode($oEncaminhamento->oSicasCredenciado->nm_credenciado),0,26), 					                        1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[4], 4, utf8_decode($oProcedimentoAutorizado->oSicasProcedimento->nm_procedimento),                                              1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[5], 4, utf8_decode(Util::formataDataHoraBancoForm($oProcedimentoAutorizado->oSicasEncaminhamento->dt_encaminhamento, false)),   1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[6], 4, utf8_decode(Util::formataMoeda($oDespesa->val_servico_realizado)),                                                                          1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[7], 4, utf8_decode(Util::formataMoeda($oDespesa->oSicasSalario->val_salario)), 					                                1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[8], 4, utf8_decode($oDespesa->desconto_servidor),                                                                               1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[9], 4, utf8_decode(Util::formataMoeda(($oDespesa->val_servico_realizado * $oDespesa->oSicasProcedimentoAutorizado->qtd_servico_autorizado) * $oDespesa->desconto_servidor/100)), 					1, 0, 'L', false);
        $oPDF->Ln();
        
        $servidorAtual = $oDespesa->oSicasSalario->oSicasServidor->cd_servidor;
        $totalDesconto += ($oDespesa->val_servico_realizado * $oDespesa->oSicasProcedimentoAutorizado->qtd_servico_autorizado) * $oDespesa->desconto_servidor/100;
        $totalGeralDesconto += $totalDesconto;
    }
    
    //impressao da ultima linha de total computada
    $oPDF->SetFont('Arial', 'B', 6);
    $oPDF->Cell($oPDF->aColunas[0], 4, utf8_decode("Total de Desconto"),  1, 0, 'L', false);
    $oPDF->Cell($oPDF->aColunas[1]+$oPDF->aColunas[2]+$oPDF->aColunas[3]+$oPDF->aColunas[4]+$oPDF->aColunas[5]+$oPDF->aColunas[6]+$oPDF->aColunas[7]+$oPDF->aColunas[8]+$oPDF->aColunas[9], 4, utf8_decode(Util::formataMoeda($totalDesconto)), 1, 0, 'R', false);
    $oPDF->Ln();
    
    if($_REQUEST['cd_servidor'] == ''){
        // Totalizadores
        $oPDF->SetFont('Arial', 'B', 6);
        $oPDF->Cell($oPDF->aColunas[0], 4, utf8_decode("Total de Desconto Geral"),  1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[1]+$oPDF->aColunas[2]+$oPDF->aColunas[3]+$oPDF->aColunas[4]+$oPDF->aColunas[5]+$oPDF->aColunas[6]+$oPDF->aColunas[7]+$oPDF->aColunas[8]+$oPDF->aColunas[9], 4, utf8_decode(Util::formataMoeda($totalGeralDesconto)), 1, 0, 'R', false);
        $oPDF->Ln();
    }
}
$oPDF->Output();