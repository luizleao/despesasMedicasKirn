<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasServidor();
$oControllerDep = new ControllerSicasDependente();

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
		$this->Cell(280, 6, utf8_decode('PROAS - Cobrança Mensal'), 0, 0, 'C', false);
		$this->Ln();
		
		$header = ['Nome', 'Matrícula', 'Lotação', 'Cargo', 'Categoria', 'Dep.PROAS', 'Salário (R$)', 'A pagar (R$)'];
		$w 		= [80, 20, 25, 50, 40, 20, 20, 20];
		
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
$oPDF->AddPage('L');
$w = [80, 20, 25, 50, 40, 20, 20, 20];

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

$aServidor = $oController->getAll(["sicas_pessoa.status = 1",
                                   "sicas_servidor.status = 1",
                                   "sicas_servidor.usuario_proas = 1",
                                   "sicas_servidor.cd_categoria in (".SicasPessoaCategoriaEnum::APOSENTADO.",
                                                                    ".SicasPessoaCategoriaEnum::ATIVO_PERMANENTE.", 
                                                                    ".SicasPessoaCategoriaEnum::CARGO_EM_COMISSAO.",
                                                                    ".SicasPessoaCategoriaEnum::CEDIDO.", 
                                                                    ".SicasPessoaCategoriaEnum::CONTRATO_TEMPORARIO.",
                                                                    ".SicasPessoaCategoriaEnum::REQUISITADO.")"], //1,3,4,30,65
								 ["sicas_pessoa.nm_pessoa", "sicas_lotacao.nm_lotacao"]);
//Util::trace(count($aServidor));exit;
$totServidores = $totDependentes = $vlDependentes = $vlTotal = 0 ;
foreach($aServidor as $oServidor) {
    $oSalario = (new ControllerSicasSalario())->getAtualByServidor($oServidor->cd_servidor);
    //Util::trace($oServidor->cd_servidor);
    //Util::trace($oSalario);
    
    if($oSalario){
        $vlServidor = Calculadora::getValorProasServidor($oSalario);
        
        $aDependente = $oControllerDep->getAll(["sicas_servidor.cd_servidor = {$oServidor->cd_servidor}",
                                                "sicas_dependente.dependente_proas = 1",
                                                "sicas_dependente.status = 1"]);
        $qtdDependentes = ($aDependente) ? count($aDependente) : 0;
        $totDependentes += $qtdDependentes;
        
        if($aDependente){
            foreach($aDependente as $oDependente){
                $vlDependentes += Calculadora::getValorProasDependente($oDependente);
            }
        }
        $vlMensal = $vlServidor + $vlDependentes;
        $vlTotal += $vlMensal;
    }

    $oPDF->Cell($w[0], 6, utf8_decode($oServidor->oSicasPessoa->nm_pessoa), 		      1, 0, 'L', false);
	$oPDF->Cell($w[1], 6, utf8_decode($oServidor->cd_matricula), 					      1, 0, 'L', false);
	$oPDF->Cell($w[2], 6, utf8_decode($oServidor->oSicasLotacao->sigla), 			      1, 0, 'L', false);
	$oPDF->Cell($w[3], 6, utf8_decode($oServidor->oRhCargo->descricao_cargo_abrev),       1, 0, 'L', false);
	$oPDF->Cell($w[4], 6, utf8_decode($oServidor->oSicasPessoaCategoria->desc_categoria), 1, 0, 'L', false);
	$oPDF->Cell($w[5], 6, $qtdDependentes,                                              1, 0, 'C', false);
	$oPDF->Cell($w[6], 6, Util::formataMoeda($oSalario->val_salario),                     1, 0, 'R', false);
	$oPDF->Cell($w[7], 6, Util::formataMoeda($vlMensal),                                  1, 0, 'R', false);
	$oPDF->Ln();

	$qtdDependentes = 0;
	$vlMensal = 0;
	$vlDependentes = 0;
	$totServidores++;
}
$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6], 6, utf8_decode('Total a Pagar (R$)'), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell($w[7], 6, Util::formataMoeda($vlTotal),                                    1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 8);
// Totalizadores
$oPDF->Ln();
$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6], 6, utf8_decode('Total de Servidores'), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell($w[7], 6, $totServidores, 1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Ln();
$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6], 6, utf8_decode('Total de Dependentes'), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell($w[7], 6, $totDependentes, 1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 8);
$oPDF->Ln();
$oPDF->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6], 6, utf8_decode('Total de Vidas'), 1, 0, 'L', false);
$oPDF->SetFont('Arial', 'B', 8);
$oPDF->Cell($w[7], 6, $totServidores + $totDependentes, 1, 0, 'R', false);
$oPDF->SetFont('Arial', '', 8);

$oPDF->Output();