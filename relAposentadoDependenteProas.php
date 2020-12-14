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
		$this->Cell(180, 6, utf8_decode('Aposentados/Dependentes PROAS - Faixa Etária'), 0, 0, 'C', false);
		$this->Ln();
		
		$header = ['Nome', 'Matrícula', 'Lotação', 'Cargo', 'Idade'];
		$w 		= [80, 20, 25, 50, 20];
		
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
$w = [80, 20, 25, 50, 20];

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
/*
 * "sicas_servidor.status = 1",
   "sicas_pessoa.status = 1",
 */
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
$aFaixaServidor = $aFaixaDependente = [];

$aFaixaServidor['19-23']   = $aFaixaServidor['24-28']   = $aFaixaServidor['29-33']   = $aFaixaServidor['34-38']   = $aFaixaServidor['39-43']   = $aFaixaServidor['44-48']   = $aFaixaServidor['49-53']   = $aFaixaServidor['54-58']   = $aFaixaServidor['59+']   = 0;
$aFaixaDependente['19-23'] = $aFaixaDependente['24-28'] = $aFaixaDependente['29-33'] = $aFaixaDependente['34-38'] = $aFaixaDependente['39-43'] = $aFaixaDependente['44-48'] = $aFaixaDependente['49-53'] = $aFaixaDependente['54-58'] = $aFaixaDependente['59+'] = 0;

foreach($aServidor as $oServidor) {
    $idadeServidor = Util::calculaIdade($oServidor->oSicasPessoa->dt_nascimento);
    
	// Cell(float w[, float h[, string txt[, mixed border[, int ln[, string align[, boolean fill[, mixed link]]]]]]])
	$oPDF->Cell($w[0], 6, utf8_decode($oServidor->oSicasPessoa->nm_pessoa), 0, 0, 'L', false);
	$oPDF->Cell($w[1], 6, utf8_decode($oServidor->cd_matricula), 0, 0, 'L', false);
	$oPDF->Cell($w[2], 6, utf8_decode($oServidor->oSicasLotacao->sigla), 0, 0, 'L', false);
	$oPDF->Cell($w[3], 6, utf8_decode($oServidor->oRhCargo->descricao_cargo_abrev), 0, 0, 'L', false);
	$oPDF->Cell($w[4], 6, $idadeServidor, 0, 0, 'L', false);
       
	if($idadeServidor >=19 && $idadeServidor <= 23)
	    $aFaixaServidor['19-23']++;
	elseif($idadeServidor >=24 && $idadeServidor <= 28)
	    $aFaixaServidor['24-28']++;
	elseif($idadeServidor >=29 && $idadeServidor <= 33)
	    $aFaixaServidor['29-33']++;
	elseif($idadeServidor >=34 && $idadeServidor <= 38)
	    $aFaixaServidor['34-38']++;
	elseif($idadeServidor >=39 && $idadeServidor <= 43)
	    $aFaixaServidor['39-43']++;
	elseif($idadeServidor >=44 && $idadeServidor <= 48)
	    $aFaixaServidor['44-48']++;
	elseif($idadeServidor >=49 && $idadeServidor <= 53)
	    $aFaixaServidor['49-53']++;
	elseif($idadeServidor >=54 && $idadeServidor <= 58)
	    $aFaixaServidor['54-58']++;
	else
	   $aFaixaServidor['59+']++;
	
	$oPDF->Ln();
	
	$aDependente = (new ControllerSicasDependente())->getAll(["sicas_dependente.status = 1",
        	                                                  "sicas_dependente.dependente_proas = 1",
        													  "sicas_servidor.cd_servidor = {$oServidor->cd_servidor}"],
        													 ["sicas_pessoa.nm_pessoa"]);
	
	if($aDependente) {
	    $aHeaderDepend = ['Nome', 'Parentesco', 'Dt. Nasc.', 'Idade'];
		$wDepend 	   = [80, 50, 35, 30];
		
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
		    $idade = Util::calculaIdade($oDependente->oSicasPessoa->dt_nascimento);
		    
			// Cell(float w[, float h[, string txt[, mixed border[, int ln[, string align[, boolean fill[, mixed link]]]]]]])
			$oPDF->Cell($wDepend[0], 6, utf8_decode($oDependente->oSicasPessoa->nm_pessoa), 1, 0, 'L', false);
			$oPDF->Cell($wDepend[1], 6, utf8_decode($oDependente->oSicasGrauParentesco->nm_grau_parentesco), 1, 0, 'L', false);
			$oPDF->Cell($wDepend[2], 6, Util::formataDataBancoForm($oDependente->oSicasPessoa->dt_nascimento), 1, 0, 'L', false);
			$oPDF->Cell($wDepend[3], 6, $idade, 1, 0, 'L', false);
			$oPDF->Ln();
			$totDependentes++;
			
            if($idade >=0 && $idade <=18)
                $aFaixaDependente['0-18']++;
            elseif($idade >=19 && $idade <= 23)
                $aFaixaDependente['19-23']++;
            elseif($idade >=24 && $idade <= 28)
                $aFaixaDependente['24-28']++;
            elseif($idade >=29 && $idade <= 33)
                $aFaixaDependente['29-33']++;
            elseif($idade >=34 && $idade <= 38)
                $aFaixaDependente['34-38']++;
            elseif($idade >=39 && $idade <= 43)
                $aFaixaDependente['39-43']++;
            elseif($idade >=44 && $idade <= 48)
                $aFaixaDependente['44-48']++;
            elseif($idade >=49 && $idade <= 53)
                $aFaixaDependente['49-53']++;
            elseif($idade >=54 && $idade <= 58)
                $aFaixaDependente['54-58']++;
            else
                $aFaixaDependente['59+']++;
		}
		$oPDF->Ln();
	}
	$totServidores ++;
}

// Totalizadores

$wFaixa = [100, 80];

$oPDF->AddPage('p');
$oPDF->Ln();
$oPDF->Cell(180, 5, utf8_decode('Quantidade de Servidores por faixa etária'), 1, 0, 'C', true);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 19-23'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaServidor['19-23']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 24-28'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaServidor['24-28']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 29-33'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaServidor['29-33']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 34-38'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaServidor['34-38']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 39-43'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaServidor['39-43']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 44-48'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaServidor['44-48']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 49-53'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaServidor['49-53']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 54-58'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaServidor['54-58']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 59+'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaServidor['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell(180, 5, utf8_decode('Total de Servidores Ativos/Inativos: '.$totServidores), 0, 0, 'C', false);
$oPDF->Ln();
$oPDF->Ln();

$oPDF->Cell(180, 5, utf8_decode('Quantidade de Dependentes por faixa etária'), 1, 0, 'C', true);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 0-18'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['0-18']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 19-23'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['19-23']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 24-28'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['24-28']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 29-33'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['29-33']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 34-38'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['34-38']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 39-43'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['39-43']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 44-48'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['44-48']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 49-53'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['49-53']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 54-58'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['54-58']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wFaixa[0], 5, utf8_decode('Faixa Etária 59+'), 1, 0, 'C', false);
$oPDF->Cell($wFaixa[1], 5, utf8_decode($aFaixaDependente['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell(180, 5, utf8_decode('Total de Dependentes: '.$totDependentes), 0, 0, 'C', false);
$oPDF->Ln();
$oPDF->Output();