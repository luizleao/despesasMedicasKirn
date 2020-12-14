<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasServidor();
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
		$this->Cell(180, 6, utf8_decode('Lista de Servidores/Dependentes PROAS'), 0, 0, 'C', false);
		$this->Ln();
		
		$header = ['Nome', 'Matrícula', 'Lotação', 'Cargo'];
		$w 		= [80, 20, 25, 70];
		
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
$w = [80, 20, 25, 70];

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

$aServidor = $oController->getAll(["sicas_servidor.usuario_proas = 1",
                                    "sicas_pessoa.status = 1",
                                    "sicas_servidor.status = 1",
                                    "sicas_servidor.cd_categoria in (".SicasPessoaCategoriaEnum::APOSENTADO.",
                                                                    ".SicasPessoaCategoriaEnum::ABONO_PERMANENCIA.",
                                                                    ".SicasPessoaCategoriaEnum::ATIVO_PERMANENTE.",
                                                                    ".SicasPessoaCategoriaEnum::CARGO_EM_COMISSAO.",
                                                                    ".SicasPessoaCategoriaEnum::CEDIDO.",
                                                                    ".SicasPessoaCategoriaEnum::COLABORADOR_EVENTUAL.",
                                                                    ".SicasPessoaCategoriaEnum::INATIVO_INSS.",
                                                                    ".SicasPessoaCategoriaEnum::REQUISITADO.",
                                                                    ".SicasPessoaCategoriaEnum::CONTRATO_TEMPORARIO.",
                                                                    ".SicasPessoaCategoriaEnum::SERVIDOR.")"],
                                    ["sicas_pessoa.nm_pessoa"]);
// 1,3,4,30,65
// Util::trace($aServidor);exit;
$totServidores = $totDependentes = 0;
foreach($aServidor as $oServidor) {
	// Cell(float w[, float h[, string txt[, mixed border[, int ln[, string align[, boolean fill[, mixed link]]]]]]])
	$oPDF->Cell($w[0], 6, utf8_decode($oServidor->oSicasPessoa->nm_pessoa), 0, 0, 'L', false);
	$oPDF->Cell($w[1], 6, utf8_decode($oServidor->cd_matricula), 0, 0, 'L', false);
	$oPDF->Cell($w[2], 6, utf8_decode($oServidor->oSicasLotacao->sigla), 0, 0, 'L', false);
	$oPDF->Cell($w[3], 6, utf8_decode($oServidor->oRhCargo->descricao_cargo_abrev), 0, 0, 'L', false);
	
	$oPDF->Ln();
	
	$aDependente = (new ControllerSicasDependente())->getAll(["sicas_dependente.status = 1",
        	                                                  "sicas_dependente.dependente_proas = 1",
        													  "sicas_servidor.cd_servidor = {$oServidor->cd_servidor}"],
        													 ["sicas_pessoa.nm_pessoa"]);
	
	if($aDependente) {
		$aHeaderDepend = ['Nome', 'Parentesco', 'Data Nascimento'];
		$wDepend 	   = [80, 50, 65];
		
		$oPDF->SetFillColor(211, 211, 211);
		$oPDF->SetDrawColor(211, 211, 211);
		$oPDF->SetFont('Arial', '', 8);
		$oPDF->SetTextColor(0);
		
		$oPDF->Cell(195, 6, utf8_decode('Dependentes'), 1, 0, 'C', false);
		$oPDF->Ln();
		
		for($i = 0; $i < count($aHeaderDepend); $i ++) {
			$oPDF->Cell($wDepend[$i], 7, utf8_decode($aHeaderDepend[$i]), 1, 0, 'C', false);
		}
		$oPDF->Ln();
		$oPDF->SetFillColor(231, 231, 231);
		$oPDF->SetDrawColor(211, 211, 211);
		$oPDF->SetFont('Arial', '', 8);
		$oPDF->SetTextColor(0);
		foreach($aDependente as $oDependente) {
			// Cell(float w[, float h[, string txt[, mixed border[, int ln[, string align[, boolean fill[, mixed link]]]]]]])
			$oPDF->Cell($wDepend[0], 6, utf8_decode($oDependente->oSicasPessoa->nm_pessoa), 1, 0, 'L', false);
			$oPDF->Cell($wDepend[1], 6, utf8_decode($oDependente->oSicasGrauParentesco->desc_grauparentesco), 1, 0, 'L', false);
			$oPDF->Cell($wDepend[2], 6, Util::formataDataBancoForm($oDependente->oSicasPessoa->dt_nascimento), 1, 0, 'L', false);
			$oPDF->Ln();
			$totDependentes ++;
		}
		$oPDF->Ln();
	}
	$totServidores ++;
}

// Totalizadores
$oPDF->Ln();
$oPDF->Cell(180, 5, utf8_decode('Total de Servidores Ativos: '.$totServidores), 0, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell(180, 5, utf8_decode('Total de Dependentes: '.$totDependentes), 0, 0, 'C', false);
$oPDF->Ln();

$oPDF->Output();