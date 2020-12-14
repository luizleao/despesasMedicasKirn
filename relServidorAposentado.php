<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasServidor();
class PDF extends FPDF {
	// Page header
	function Header() {
		$this->Image('img/logo_sudam_peq.jpg', 140, 5, 0, 0, '', '');
		// Colors, line width and bold font
		$this->SetFont('Arial', '', 8);
		$this->SetLineWidth(.1);
		$this->SetFont('', 'B');
		
		$this->Cell(100, 15, '', 0, 0, 'C', false);
		$this->Ln();
		
		$this->SetTextColor(0);
		$this->SetFont('Arial', '', 8);
		$this->Cell(280, 6, utf8_decode('Superintendência do Desenvolvimento da Amazônia'), 0, 0, 'C', false);
		$this->Ln();
		$this->Cell(280, 6, utf8_decode('Relação de Servidores - Aposentados'), 0, 0, 'C', false);
		$this->Ln();
		
		$header = ['Nome', 'Matrícula', 'Cargo', 'PROAS', 'E-mail', 'Telefone'];
		$w 		= [75, 20, 50, 15, 55, 70];
		
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

$oPDF = new PDF('L');
$oPDF->AliasNbPages();
$oPDF->AddPage();
$w = [75, 20, 50, 15, 55, 70];

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

$aServidor = $oController->getAll(["sicas_pessoa_categoria.cd_categoria in (".SicasPessoaCategoriaEnum::APOSENTADO.", 
                                                                            ".SicasPessoaCategoriaEnum::ABONO_PERMANENCIA.")",
                                   "sicas_servidor.cd_categoria in (".SicasPessoaCategoriaEnum::ATIVO_PERMANENTE.",
                                                                    ".SicasPessoaCategoriaEnum::APOSENTADO.",
                                                                    ".SicasPessoaCategoriaEnum::ABONO_PERMANENCIA.")"
], //1,3,4,30,65
								  ["sicas_pessoa.nm_pessoa", "sicas_lotacao.nm_lotacao"]);
// Util::trace($aServidor);exit;
$totServidores = $totProas = $totNaoProas = 0;
foreach($aServidor as $oServidor) {
	// Cell(float w[, float h[, string txt[, mixed border[, int ln[, string align[, boolean fill[, mixed link]]]]]]])
	$oPDF->Cell($w[0], 6, utf8_decode($oServidor->oSicasPessoa->nm_pessoa), 		1, 0, 'L', false);
	$oPDF->Cell($w[1], 6, utf8_decode($oServidor->cd_matricula), 					1, 0, 'L', false);
	$oPDF->Cell($w[2], 6, utf8_decode($oServidor->oRhCargo->descricao_cargo_abrev), 1, 0, 'L', false);
	$oPDF->Cell($w[3], 6, utf8_decode(Util::getSimNao($oServidor->usuario_proas)), 1, 0, 'L', false);
	$oPDF->Cell($w[4], 6, utf8_decode($oServidor->oSicasPessoa->email), 1, 0, 'L', false);
	$oPDF->Cell($w[5], 6, utf8_decode($oServidor->oSicasPessoa->telefone), 1, 0, 'L', false);
	
	$oPDF->Ln();
	($oServidor->usuario_proas == 1) ? $totProas++ : $totNaoProas++ ;
}

$totServidores = $totProas + $totNaoProas;
// Totalizadores
$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4], 6, utf8_decode('Servidores PROAS'), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell($w[5], 6, utf8_decode($totProas), 1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Ln();
$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4], 6, utf8_decode('Servidores NAO PROAS'), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell($w[5], 6, utf8_decode($totNaoProas), 1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Ln();
$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4], 6, utf8_decode('Total de Servidores '), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell($w[5], 6, utf8_decode($totServidores), 1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Ln();

$oPDF->Output();