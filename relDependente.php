<?php
require_once(dirname(__FILE__)."/classes/autoload.php");
$oController = new Controller();

class PDF extends FPDF {
    
	// Page header
	function Header() {
		$this->Image('img/logo_sudam_peq.jpg', 90, 5, 0, 0, '', '');
		// Colors, line width and bold font
		$this->SetFont('Arial', '', 8);
		$this->SetLineWidth(.1);
		$this->SetFont('', 'B');
		
		$this->Cell(100, 15, '', 0, 0, 'C', false);
		$this->Ln();
		
		$this->SetTextColor(0);
		$this->SetFont('Arial', '', 8);
		$this->Cell(180, 6, utf8_decode('Superintendência do Desenvolvimento da Amazônia'), 0, 0, 'C', false);
		$this->Ln();
		$this->Cell(180, 6, utf8_decode('Lista de Dependentes'), 0, 0, 'C', false);
		$this->Ln();
	
		$this->SetFillColor(231, 231, 231);
		$this->SetDrawColor(211, 211, 211);
		$this->SetFont('Arial', '', 6);
		$this->SetTextColor(0);
		
		$aHeader = ['Nome', 'Servidor', 'Parentesco', 'Idade', 'PROAS'];
		$w 	     = [60, 70, 25, 10, 10];
		
		for($i = 0; $i < count($aHeader); $i ++) {
		    $this->SetFont('Arial', 'B', 6);
		    $this->Cell($w[$i], 5, utf8_decode($aHeader[$i]), 1, 0, 'C', true);
		}
		$this->SetFont('Arial', '', 6);
		$this->Ln();
	}
	
	// Page footer
	function Footer() {
		// Position at 1.5 cm from bottom
		$this->SetY(- 15);
		// Arial italic 8
		$this->SetFont('Arial', 'I', 8);
		// Page number
		$this->Cell(0, 10, utf8_decode('Página '.$this->PageNo().'/{nb}'), 0, 0, 'C');
	}
}

$oPDF = new PDF();
$oPDF->AliasNbPages();
$oPDF->AddPage();

$totDependentesPROAS = $totDependentesNaoPROAS = 0;
$w 	     = [60, 70, 25, 10, 10];

$oControllerDependente = new ControllerSicasDependente();
$aDependente = $oControllerDependente->getAll(["sicas_dependente.status = 1",
                                              "sicas_pessoa.status = 1",
                                              "sicas_servidor.status = 1"],
										     ["sicas_pessoa.nm_pessoa"]);

if($aDependente) {
	$oPDF->SetFillColor(231, 231, 231);
	$oPDF->SetDrawColor(211, 211, 211);
	$oPDF->SetFont('Arial', '', 6);
	$oPDF->SetTextColor(0);
	foreach($aDependente as $oDependente) {
	    $oControllerServidor = new ControllerSicasServidor();
	    $oSicasServidor = $oControllerServidor->get($oDependente->oSicasServidor->cd_servidor);
		// Cell(float w[, float h[, string txt[, mixed border[, int ln[, string align[, boolean fill[, mixed link]]]]]]])
		$oPDF->Cell($w[0], 5, utf8_decode($oDependente->oSicasPessoa->nm_pessoa), 1, 0, 'L', false);
		$oPDF->Cell($w[1], 5, utf8_decode($oSicasServidor->oSicasPessoa->nm_pessoa), 1, 0, 'L', false);
		$oPDF->Cell($w[2], 5, utf8_decode($oDependente->oSicasGrauParentesco->nm_grau_parentesco), 1, 0, 'L', false);
		$oPDF->Cell($w[3], 5, Util::calculaIdade($oDependente->oSicasPessoa->dt_nascimento), 1, 0, 'L', false);
		$oPDF->Cell($w[4], 5, utf8_decode(Util::getSimNao($oDependente->dependente_proas)), 1, 0, 'C', false);
		$oPDF->Ln();
		
		($oDependente->dependente_proas == 1) ? $totDependentesPROAS++ : $totDependentesNaoPROAS++;
	}
}

$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3], 5, utf8_decode('Total de Dependentes PROAS'), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 6);
$oPDF->Cell($w[4], 5, $totDependentesPROAS, 1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 6);
$oPDF->Ln();
$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3], 5, utf8_decode('Total de Dependentes NAO PROAS'), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 6);
$oPDF->Cell($w[4], 5, $totDependentesNaoPROAS, 1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 6);
$oPDF->Ln();
$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3], 5, utf8_decode('Total de Dependentes'), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 6);
$oPDF->Cell($w[4], 5, $totDependentesPROAS+$totDependentesNaoPROAS, 1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 6);
$oPDF->Ln();

$oPDF->Output();