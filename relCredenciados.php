<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasCredenciado();
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
		$this->Cell(180, 6, utf8_decode('Relação de Credenciados SAMS'), 0, 0, 'C', false);
		$this->Ln();
		
		$header = ['Credenciado', 'Especialidade'];
		$w 		= [100, 95];
		
		$this->SetFillColor(231, 231, 231);
		$this->SetDrawColor(211, 211, 211);
		$this->SetFont('Arial', '', 8);
		$this->SetTextColor(0);
		for($i = 0; $i < count($header); $i ++) {
			$this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
		}
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
$w = [100, 95];

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
// Data

$aCredenciado = $oController->getAll(["sicas_credenciado.status = 1", "sicas_credenciado.cd_credenciado not in (0)"], ["sicas_credenciado.nm_credenciado"]);
//Util::trace($aCredenciado);exit;
$totCredenciados = 0;
foreach($aCredenciado as $oCredenciado) {
    $aux = (new ControllerSicasEspecialidadeMedicaCredenciado())->getAll(["sicas_credenciado.cd_credenciado = ".$oCredenciado->cd_credenciado]);
    //$aux->oSicasEspecialidadeMedica->nm_especialidade
	// Cell(float w[, float h[, string txt[, mixed border[, int ln[, string align[, boolean fill[, mixed link]]]]]]])
    $oPDF->Cell($w[0], 6, utf8_decode($oCredenciado->nm_credenciado), 1, 0, 'L', false);
	$oPDF->Cell($w[1], 6, utf8_decode($oCredenciado->nm_servicos),    1, 0, 'L', false);
	//$oPDF->Cell($w[3], 6, utf8_decode(""), 1, 0, 'L', false);
	
	$oPDF->Ln();
	$totCredenciados ++;
}

// Totalizadores
$oPDF->Ln();
$oPDF->Cell(180, 5, utf8_decode('Total de Credenciados Ativos: '.$totCredenciados), 0, 0, 'C', false);
$oPDF->Ln();

$oPDF->Output();