<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasDespesa();

class PDF extends FPDF {
    public $aColunas = [105, 20, 12, 8, 20, 20];
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
        $this->Cell(200, 6, utf8_decode('Superintendência do Desenvolvimento da Amazônia'), 0, 0, 'C', false);
        $this->Ln();
        $this->Cell(200, 6, utf8_decode('Relatório de Desconto Mensal'), 0, 0, 'C', false);
        $this->Ln();
        $this->Cell(90, 6, utf8_decode(''), 0, 0, 'C', false);
        $this->Cell(10, 6, utf8_decode('Período: '), 0, 0, 'R', false);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(20, 6, utf8_decode(Util::formataDataBancoForm($_REQUEST['mesAno'])), 0, 0, 'L', false);
        $this->SetFont('Arial', '', 6);
        $this->Ln();
        
        $header = ['Servidor', 'Matrícula', 'Salário', '%', 'Total Despesa', 'Desconto'];
        //$header = ['Servidor', 'Beneficiário', 'Guia', 'Credenciado', 'Procedimento', 'Data', 'Valor', 'Salário', '%', 'Desconto'];
        
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
$oPDF->AddPage('P');

// Color and font restoration
$oPDF->SetFillColor(231, 231, 231);
$oPDF->SetDrawColor(211, 211, 211);
$oPDF->SetFont('Arial', '', 6);
$oPDF->SetTextColor(0);

$aDespesa = $oController->getAll(["sicas_despesa.mes_ano_desconto = '{$_REQUEST['mesAno']}-01'"], ['sicas_pessoa.nm_pessoa']);
//Util::trace($aDespesa);exit;

$oControllerServidor = new ControllerSicasServidor();

$servidorAtual = NULL;
$totalDesconto = $totalGeralDesconto = $totalDespesa = $somaTotalDespesa = 0;
foreach($aDespesa as $oDespesa) {
    $oServidor = $oControllerServidor->get($oDespesa->oSicasSalario->oSicasServidor->cd_servidor);
    
    if($servidorAtual != NULL && $servidorAtual != $oDespesa->oSicasSalario->oSicasServidor->cd_servidor){
        $oPDF->Cell($oPDF->aColunas[0], 4, utf8_decode($nomeAtual), 1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[1], 4, utf8_decode($matriculaAtual), 1, 0, 'L', false);
        $oPDF->Cell($oPDF->aColunas[2], 4, utf8_decode(Util::formataMoeda($valorSalario)), 1, 0, 'R', false);
        $oPDF->Cell($oPDF->aColunas[3], 4, utf8_decode($descontoAtual), 1, 0, 'R', false);
        $oPDF->Cell($oPDF->aColunas[4], 4, utf8_decode(Util::formataMoeda($totalDespesa)), 1, 0, 'R', false);
        $oPDF->Cell($oPDF->aColunas[5], 4, utf8_decode(Util::formataMoeda($totalDesconto)),1, 0, 'R', false);
        $oPDF->Ln();
        $totalDesconto = 0;
        $totalDespesa = 0;
    }
    
    $servidorAtual = $oDespesa->oSicasSalario->oSicasServidor->cd_servidor;
    $nomeAtual = $oServidor->oSicasPessoa->nm_pessoa;
    $matriculaAtual = $oServidor->cd_matricula;
     
    $descontoAtual = $oDespesa->desconto_servidor;
    $valorSalario = $oDespesa->oSicasSalario->val_salario;
    
    $totalDespesa += $oDespesa->val_servico_realizado * $oDespesa->oSicasProcedimentoAutorizado->qtd_servico_autorizado;
    $totalDesconto += ($oDespesa->val_servico_realizado * $oDespesa->oSicasProcedimentoAutorizado->qtd_servico_autorizado) * $oDespesa->desconto_servidor/100;
    $somaTotalDespesa += $totalDespesa;
    
    $totalGeralDesconto += $totalDesconto;
}

$oPDF->Cell($oPDF->aColunas[0], 4, utf8_decode($nomeAtual), 1, 0, 'L', false);
$oPDF->Cell($oPDF->aColunas[1], 4, utf8_decode($matriculaAtual), 1, 0, 'L', false);
$oPDF->Cell($oPDF->aColunas[2], 4, utf8_decode(Util::formataMoeda($valorSalario)), 1, 0, 'R', false);
$oPDF->Cell($oPDF->aColunas[3], 4, utf8_decode($oDespesa->desconto_servidor), 1, 0, 'R', false);
$oPDF->Cell($oPDF->aColunas[4], 4, utf8_decode($totalDespesa), 1, 0, 'R', false);
$oPDF->Cell($oPDF->aColunas[5], 4, utf8_decode(Util::formataMoeda($totalDesconto)),1, 0, 'R', false);
$oPDF->Ln();
//impressao da ultima linha de total computada
// Totalizadores
$oPDF->SetFont('Arial', 'B', 6);
$oPDF->Cell($oPDF->aColunas[0]+$oPDF->aColunas[1]+$oPDF->aColunas[2]+$oPDF->aColunas[3], 4, utf8_decode("Total de Desconto Geral"),  1, 0, 'L', false);
$oPDF->Cell($oPDF->aColunas[4], 4, utf8_decode(Util::formataMoeda($somaTotalDespesa)), 1, 0, 'R', false);
$oPDF->Cell($oPDF->aColunas[5], 4, utf8_decode(Util::formataMoeda($totalGeralDesconto)), 1, 0, 'R', false);
$oPDF->Ln();

$oPDF->Output();