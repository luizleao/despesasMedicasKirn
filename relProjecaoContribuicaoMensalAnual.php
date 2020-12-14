<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasServidor();
class PDF extends FPDF {
	// Page header
	function Header() {
		$this->Image('img/logo_sudam_peq.jpg', 130, 5, 0, 0, '', '');
		// Colors, line width and bold font
		$this->SetFont('Arial', '', 8);
		$this->SetLineWidth(.1);
		$this->SetFont('', 'B');
		
		$this->Cell(100, 15, '', 0, 0, 'C', false);
		$this->Ln();
		
		$this->SetTextColor(0);
		$this->SetFont('Arial', '', 8);
		$this->Cell(260, 6, utf8_decode('Superintendência do Desenvolvimento da Amazônia'), 0, 0, 'C', false);
		$this->Ln();
		$this->Cell(260, 6, utf8_decode('PROAS - Projeção de Receita Mensal'), 0, 0, 'C', false);
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
$aServidor = $oController->getAll(["sicas_pessoa.status = 1",
                                   "sicas_servidor.status = 1",
                                   "sicas_servidor.usuario_proas = 1",
                                   "sicas_servidor.cd_categoria in (".SicasPessoaCategoriaEnum::APOSENTADO.",
                                                                    ".SicasPessoaCategoriaEnum::ATIVO_PERMANENTE.",
                                                                    ".SicasPessoaCategoriaEnum::CARGO_EM_COMISSAO.",
                                                                    ".SicasPessoaCategoriaEnum::CEDIDO.",
                                                                    ".SicasPessoaCategoriaEnum::CONTRATO_TEMPORARIO.",
                                                                    ".SicasPessoaCategoriaEnum::REQUISITADO.")"], 
								 ["sicas_pessoa.nm_pessoa"]);
// 1,3,4,30,65
//Util::trace(count($aServidor));exit;
$totServidores = $totDependentes = 0;
$total_servidor_0_38 = $total_servidor_39_58 = $total_servidor_59_ = 0;
$total_dep_0_38      = $total_dep_39_58      = $total_dep_59_      = 0;

$valor_total_serv = []; 
$valor_total_dep = [];

$aFaixa = $aFaixaDep = [];

foreach($aServidor as $oServidor) {
    $idadeServidor = Util::calculaIdade($oServidor->oSicasPessoa->dt_nascimento);
    $oControllerSalario = new ControllerSicasSalario();
    $oSalario = $oControllerSalario->getAtualByServidor($oServidor->cd_servidor);

	// ============= Avaliar faixa salarial ============
    if($oSalario->val_salario <= 1499.99){
        if($idadeServidor >=0 && $idadeServidor <= 38){
            $total_servidor_0_38++;
            $aFaixa['0-1499.99']['0-38']++;
        }
        elseif($idadeServidor >=39 && $idadeServidor <= 58){
            $total_servidor_39_58++;
            $aFaixa['0-1499.99']['39-58']++;
        }
        else{
            $total_servidor_59_++;
            $aFaixa['0-1499.99']['59+']++;
        }
    }
    elseif($oSalario->val_salario >=1500 && $oSalario->val_salario <= 1999.99){
        if($idadeServidor >=0 && $idadeServidor <= 38){
            $total_servidor_0_38++;
            $aFaixa['1500-1999.99']['0-38']++;
        }
        elseif($idadeServidor >=39 && $idadeServidor <= 58){
            $total_servidor_39_58++;
            $aFaixa['1500-1999.99']['39-58']++;
        }
        else{
            $total_servidor_59_++;
            $aFaixa['1500-1999.99']['59+']++;
        }
    }
    elseif($oSalario->val_salario >=2000 && $oSalario->val_salario <= 2499.99){
        if($idadeServidor >=0 && $idadeServidor <= 38){
            $total_servidor_0_38++;
            $aFaixa['2000-2499.99']['0-38']++;
        }
        elseif($idadeServidor >=39 && $idadeServidor <= 58){
            $total_servidor_39_58++;
            $aFaixa['2000-2499.99']['39-58']++;
        }
        else{
            $total_servidor_59_++;
            $aFaixa['2000-2499.99']['59+']++;
        }
    }
    elseif($oSalario->val_salario >=2500 && $oSalario->val_salario <= 2999.99){
        if($idadeServidor >=0 && $idadeServidor <= 38){
            $total_servidor_0_38++;
            $aFaixa['2500-2999.99']['0-38']++;
        }
        elseif($idadeServidor >=39 && $idadeServidor <= 58){
            $total_servidor_39_58++;
            $aFaixa['2500-2999.99']['39-58']++;
        }
        else{
            $total_servidor_59_++;
            $aFaixa['2500-2999.99']['59+']++;
        }
    }
    elseif($oSalario->val_salario >=3000 && $oSalario->val_salario <= 3999.99){
        if($idadeServidor >=0 && $idadeServidor <= 38){
            $total_servidor_0_38++;
            $aFaixa['3000-3999.99']['0-38']++;
        }
        elseif($idadeServidor >=39 && $idadeServidor <= 58){
            $total_servidor_39_58++;
            $aFaixa['3000-3999.99']['39-58']++;
        }
        else{
            $total_servidor_59_++;
            $aFaixa['3000-3999.99']['59+']++;
        }
    }
    elseif($oSalario->val_salario >=4000 && $oSalario->val_salario <= 5499.99){
        if($idadeServidor >=0 && $idadeServidor <= 38){
            $total_servidor_0_38++;
            $aFaixa['4000-5499.99']['0-38']++;
        }
        elseif($idadeServidor >=39 && $idadeServidor <= 58){
            $total_servidor_39_58++;
            $aFaixa['4000-5499.99']['39-58']++;
        }
        else{
            $total_servidor_59_++;
            $aFaixa['4000-5499.99']['59+']++;
        }
    }
    elseif($oSalario->val_salario >=5500 && $oSalario->val_salario <= 7499.99){
        if($idadeServidor >=0 && $idadeServidor <= 38){
            $total_servidor_0_38++;
            $aFaixa['5500-7499.99']['0-38']++;
        }
        elseif($idadeServidor >=39 && $idadeServidor <= 58){
            $total_servidor_39_58++;
            $aFaixa['5500-7499.99']['39-58']++;
        }
        else{
            $total_servidor_59_++;
            $aFaixa['5500-7499.99']['59+']++;
        }
    }
    else{
        if($idadeServidor >=0 && $idadeServidor <= 38){
            $total_servidor_0_38++;
            $aFaixa['7500+']['0-38']++;
        }
        elseif($idadeServidor >=39 && $idadeServidor <= 58){
            $total_servidor_39_58++;
            $aFaixa['7500+']['39-58']++;
        }
        else{
            $total_servidor_59_++;
            $aFaixa['7500+']['59+']++;
        }
    }
    
    $aDependente = (new ControllerSicasDependente())->getAll(["sicas_servidor.cd_servidor = {$oServidor->cd_servidor}",
                                                              "sicas_dependente.dependente_proas = 1",
                                                              "sicas_dependente.status = 1"],
        													 ["sicas_pessoa.nm_pessoa"]);
	
	if($aDependente) {
		$oPDF->SetFillColor(231, 231, 231);
		$oPDF->SetDrawColor(211, 211, 211);
		$oPDF->SetFont('Arial', '', 8);
		$oPDF->SetTextColor(0);
		foreach($aDependente as $oDependente) {
		    $idadeDep = Util::calculaIdade($oDependente->oSicasPessoa->dt_nascimento);
			$totDependentes++;
			
			// ============= Avaliar faixa salarial ============
			if($oSalario->val_salario <= 1499.99){
			    if($idadeDep >=0 && $idadeDep <= 38){
			        $total_dep_0_38++;
			        $aFaixaDep['0-1499.99']['0-38']++;
			    }
			    elseif($idadeDep >=39 && $idadeDep <= 58){
			        $total_dep_39_58++;
			        $aFaixaDep['0-1499.99']['39-58']++;
			    }
			    else{
			        $total_dep_59_++;
			        $aFaixaDep['0-1499.99']['59+']++;
			    }
			}
			elseif($oSalario->val_salario >=1500 && $oSalario->val_salario <= 1999.99){
			    if($idadeDep >=0 && $idadeDep <= 38){
			        $total_dep_0_38++;
			        $aFaixaDep['1500-1999.99']['0-38']++;
			    }
			    elseif($idadeDep >=39 && $idadeDep <= 58){
			        $total_dep_39_58++;
			        $aFaixaDep['1500-1999.99']['39-58']++;
			    }
			    else{
			        $total_dep_59_++;
			        $aFaixaDep['1500-1999.99']['59+']++;
			    }
			}
			elseif($oSalario->val_salario >=2000 && $oSalario->val_salario <= 2499.99){
			    if($idadeDep >=0 && $idadeDep <= 38){
			        $total_dep_0_38++;
			        $aFaixaDep['2000-2499.99']['0-38']++;
			    }
			    elseif($idadeDep >=39 && $idadeDep <= 58){
			        $total_dep_39_58++;
			        $aFaixaDep['2000-2499.99']['39-58']++;
			    }
			    else{
			        $total_dep_59_++;
			        $aFaixaDep['2000-2499.99']['59+']++;
			    }
			}
			elseif($oSalario->val_salario >=2500 && $oSalario->val_salario <= 2999.99){
			    if($idadeDep >=0 && $idadeDep <= 38){
			        $total_dep_0_38++;
			        $aFaixaDep['2500-2999.99']['0-38']++;
			    }
			    elseif($idadeDep >=39 && $idadeDep <= 58){
			        $total_dep_39_58++;
			        $aFaixaDep['2500-2999.99']['39-58']++;
			    }
			    else{
			        $total_dep_59_++;
			        $aFaixaDep['2500-2999.99']['59+']++;
			    }
			}
			elseif($oSalario->val_salario >=3000 && $oSalario->val_salario <= 3999.99){
			    if($idadeDep >=0 && $idadeDep <= 38){
			        $total_dep_0_38++;
			        $aFaixaDep['3000-3999.99']['0-38']++;
			    }
			    elseif($idadeDep >=39 && $idadeDep <= 58){
			        $total_dep_39_58++;
			        $aFaixaDep['3000-3999.99']['39-58']++;
			    }
			    else{
			        $total_dep_59_++;
			        $aFaixaDep['3000-3999.99']['59+']++;
			    }
			}
			elseif($oSalario->val_salario >=4000 && $oSalario->val_salario <= 5499.99){
			    if($idadeDep >=0 && $idadeDep <= 38){
			        $total_dep_0_38++;
			        $aFaixaDep['4000-5499.99']['0-38']++;
			    }
			    elseif($idadeDep >=39 && $idadeDep <= 58){
			        $total_dep_39_58++;
			        $aFaixaDep['4000-5499.99']['39-58']++;
			    }
			    else{
			        $total_dep_59_++;
			        $aFaixaDep['4000-5499.99']['59+']++;
			    }
			}
			elseif($oSalario->val_salario >=5500 && $oSalario->val_salario <= 7499.99){
			    if($idadeDep >=0 && $idadeDep <= 38){
			        $total_dep_0_38++;
			        $aFaixaDep['5500-7499.99']['0-38']++;
			    }
			    elseif($idadeDep >=39 && $idadeDep <= 58){
			        $total_dep_39_58++;
			        $aFaixaDep['5500-7499.99']['39-58']++;
			    }
			    else{
			        $total_dep_59_++;
			        $aFaixaDep['5500-7499.99']['59+']++;
			    }
			}
			else{
			    if($idadeDep >=0 && $idadeDep <= 38){
			        $total_dep_0_38++;
			        $aFaixaDep['7500+']['0-38']++;
			    }
			    elseif($idadeDep >=39 && $idadeDep <= 58){
			        $total_dep_39_58++;
			        $aFaixaDep['7500+']['39-58']++;
			    }
			    else{
			        $total_dep_59_++;
			        $aFaixaDep['7500+']['59+']++;
			    }
			}			
		}
	}
	$totServidores ++;
}

// Totalizadores

$wQtd = [35,13,17,13,13,13,13,13,17,13,13,13,13,13,17,13,13,13,15];
$altura = 5;
$oPDF->AddPage('l');
$oPDF->Ln();
$oPDF->Cell(283, $altura, utf8_decode('Quantidade de Servidores por faixa etária'), 1, 0, 'C', true);
$oPDF->Ln();
$oPDF->Cell(35, 3*$altura, utf8_decode('Remuneração Base (R$)'), 1, 0, 'C', false);
$oPDF->Cell(248, $altura, utf8_decode('Faixas Etárias'), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell(35, $altura, utf8_decode(''), 0, 0, 'C', false);
$oPDF->Cell(82, $altura, utf8_decode('Faixa 01 (0-38)'), 1, 0, 'C', false);
$oPDF->Cell(82, $altura, utf8_decode('Faixa 02 (39-58)'), 1, 0, 'C', false);
$oPDF->Cell(84, $altura, utf8_decode('Faixa 03 (59+)'), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode(''), 0, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, utf8_decode('Valor (A)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, utf8_decode('Servidor (B)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, utf8_decode('Total (C)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, utf8_decode('Dep (D)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, utf8_decode('Total (E)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, utf8_decode('Total (F)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, utf8_decode('Valor (G)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, utf8_decode('Servidor (H)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, utf8_decode('Total (I)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, utf8_decode('Dep (J)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, utf8_decode('Total (K)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, utf8_decode('Total (L)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, utf8_decode('Valor (M)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, utf8_decode('Servidor (N)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, utf8_decode('Total (O)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, utf8_decode('Dep (P)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, utf8_decode('Total (Q)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, utf8_decode('Total (R)'), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('até 1.499,99'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, Util::formataMoeda(30), 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, (int)$aFaixa['0-1499.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, Util::formataMoeda(30*$aFaixa['0-1499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, (int)$aFaixaDep['0-1499.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, Util::formataMoeda(30*(int)$aFaixaDep['0-1499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, Util::formataMoeda(30*(int)$aFaixa['0-1499.99']['0-38']+30*(int)$aFaixaDep['0-1499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, Util::formataMoeda(40), 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, (int)$aFaixa['0-1499.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, Util::formataMoeda(40*$aFaixa['0-1499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, (int)$aFaixaDep['0-1499.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, Util::formataMoeda(40*$aFaixaDep['0-1499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, Util::formataMoeda(40*$aFaixa['0-1499.99']['39-58']+40*$aFaixaDep['0-1499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, Util::formataMoeda(50), 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, (int)$aFaixa['0-1499.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, Util::formataMoeda(50*$aFaixa['0-1499.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, (int)$aFaixaDep['0-1499.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, Util::formataMoeda(50*$aFaixaDep['0-1499.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, Util::formataMoeda(50*$aFaixa['0-1499.99']['59+']+50*$aFaixaDep['0-1499.99']['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('de 1.500,00 a 1.999,99'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, Util::formataMoeda(35), 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, (int)$aFaixa['1500-1999.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, Util::formataMoeda(35*$aFaixa['1500-1999.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, (int)$aFaixaDep['1500-1999.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, Util::formataMoeda(35*$aFaixaDep['1500-1999.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, Util::formataMoeda(35*$aFaixa['1500-1999.99']['0-38']+35*$aFaixaDep['1500-1999.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, Util::formataMoeda(45), 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, (int)$aFaixa['1500-1999.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, Util::formataMoeda(45*$aFaixa['1500-1999.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, (int)$aFaixaDep['1500-1999.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, Util::formataMoeda(45*$aFaixaDep['1500-1999.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, Util::formataMoeda(45*$aFaixa['1500-1999.99']['39-58']+45*$aFaixaDep['1500-1999.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, Util::formataMoeda(55), 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, (int)$aFaixa['1500-1999.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, Util::formataMoeda(55*$aFaixa['1500-1999.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, (int)$aFaixaDep['1500-1999.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, Util::formataMoeda(55*$aFaixaDep['1500-1999.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, Util::formataMoeda(55*$aFaixa['1500-1999.99']['59+']+55*$aFaixaDep['1500-1999.99']['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('de 2.000,00 a 2.499,99'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, Util::formataMoeda(40), 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, (int)$aFaixa['2000-2499.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, Util::formataMoeda(40*$aFaixa['2000-2499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, (int)$aFaixaDep['2000-2499.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, Util::formataMoeda(40*$aFaixaDep['2000-2499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, Util::formataMoeda(40*$aFaixa['2000-2499.99']['0-38']+40*$aFaixaDep['2000-2499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, Util::formataMoeda(50), 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, (int)$aFaixa['2000-2499.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, Util::formataMoeda(50*$aFaixa['2000-2499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, (int)$aFaixaDep['2000-2499.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, Util::formataMoeda(50*$aFaixaDep['2000-2499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, Util::formataMoeda(50*$aFaixa['2000-2499.99']['39-58']+50*$aFaixaDep['2000-2499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, Util::formataMoeda(60), 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, (int)$aFaixa['2000-2499.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, Util::formataMoeda(60*$aFaixa['2000-2499.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, (int)$aFaixaDep['2000-2499.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, Util::formataMoeda(60*$aFaixaDep['2000-2499.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, Util::formataMoeda(60*$aFaixa['2000-2499.99']['59+']+60*$aFaixaDep['2000-2499.99']['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('de 2.500,00 a 2.999,99'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, Util::formataMoeda(45), 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, (int)$aFaixa['2500-2999.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, Util::formataMoeda(45*$aFaixa['2500-2999.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, (int)$aFaixaDep['2500-2999.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, Util::formataMoeda(45*$aFaixaDep['2500-2999.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, Util::formataMoeda(45*$aFaixa['2500-2999.99']['0-38']+45*$aFaixaDep['2500-2999.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, Util::formataMoeda(55), 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, (int)$aFaixa['2500-2999.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, Util::formataMoeda(55*$aFaixa['2500-2999.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, (int)$aFaixaDep['2500-2999.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, Util::formataMoeda(55*$aFaixaDep['2500-2999.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, Util::formataMoeda(55*$aFaixa['2500-2999.99']['39-58']+55*$aFaixaDep['2500-2999.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, Util::formataMoeda(65), 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, (int)$aFaixa['2500-2999.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, Util::formataMoeda(65*$aFaixa['2500-2999.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, (int)$aFaixaDep['2500-2999.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, Util::formataMoeda(65*$aFaixaDep['2500-2999.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, Util::formataMoeda(65*$aFaixa['2500-2999.99']['59+']+65*$aFaixaDep['2500-2999.99']['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('de 3.000,00 a 3.999,99'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, Util::formataMoeda(50), 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, (int)$aFaixa['3000-3999.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, Util::formataMoeda(50*$aFaixa['3000-3999.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, (int)$aFaixaDep['3000-3999.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, Util::formataMoeda(50*$aFaixaDep['3000-3999.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, Util::formataMoeda(50*$aFaixa['3000-3999.99']['0-38']+50*$aFaixaDep['3000-3999.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, Util::formataMoeda(60), 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, (int)$aFaixa['3000-3999.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, Util::formataMoeda(60*$aFaixa['3000-3999.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, (int)$aFaixaDep['3000-3999.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, Util::formataMoeda(60*$aFaixaDep['3000-3999.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, Util::formataMoeda(60*$aFaixa['3000-3999.99']['39-58']+60*$aFaixaDep['3000-3999.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, Util::formataMoeda(70), 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, (int)$aFaixa['3000-3999.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, Util::formataMoeda(70*$aFaixa['3000-3999.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, (int)$aFaixaDep['3000-3999.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, Util::formataMoeda(70*$aFaixaDep['3000-3999.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, Util::formataMoeda(70*$aFaixa['3000-3999.99']['59+']+70*$aFaixaDep['3000-3999.99']['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('de 4.000,00 a 5.499,99'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, Util::formataMoeda(55), 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, (int)$aFaixa['4000-5499.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, Util::formataMoeda(55*$aFaixa['4000-5499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, (int)$aFaixaDep['4000-5499.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, Util::formataMoeda(55*$aFaixaDep['4000-5499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, Util::formataMoeda(55*$aFaixa['4000-5499.99']['0-38']+55*$aFaixaDep['4000-5499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, Util::formataMoeda(65), 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, (int)$aFaixa['4000-5499.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, Util::formataMoeda(65*$aFaixa['4000-5499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, (int)$aFaixaDep['4000-5499.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, Util::formataMoeda(65*$aFaixaDep['4000-5499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, Util::formataMoeda(65*$aFaixa['4000-5499.99']['39-58']+65*$aFaixaDep['4000-5499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, Util::formataMoeda(75), 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, (int)$aFaixa['4000-5499.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, Util::formataMoeda(75*$aFaixa['4000-5499.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, (int)$aFaixaDep['4000-5499.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, Util::formataMoeda(75*$aFaixaDep['4000-5499.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, Util::formataMoeda(75*$aFaixa['4000-5499.99']['59+']+75*$aFaixaDep['4000-5499.99']['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('de 5.500,00 a 7.499,99'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, Util::formataMoeda(65), 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, (int)$aFaixa['5500-7499.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, Util::formataMoeda(65*$aFaixa['5500-7499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, (int)$aFaixaDep['5500-7499.99']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, Util::formataMoeda(65*$aFaixaDep['5500-7499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, Util::formataMoeda(65*$aFaixa['5500-7499.99']['0-38']+65*$aFaixaDep['5500-7499.99']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, Util::formataMoeda(75), 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, (int)$aFaixa['5500-7499.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, Util::formataMoeda(75*$aFaixa['5500-7499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, (int)$aFaixaDep['5500-7499.99']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, Util::formataMoeda(75*$aFaixaDep['5500-7499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, Util::formataMoeda(75*$aFaixa['5500-7499.99']['39-58']+75*$aFaixaDep['5500-7499.99']['39-58']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, Util::formataMoeda(85), 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, (int)$aFaixa['5500-7499.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, Util::formataMoeda(85*$aFaixa['5500-7499.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, (int)$aFaixaDep['5500-7499.99']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, Util::formataMoeda(85*$aFaixaDep['5500-7499.99']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, Util::formataMoeda(85*$aFaixa['5500-7499.99']['59+']+85*$aFaixaDep['5500-7499.99']['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('7.500 ou mais'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, Util::formataMoeda(75), 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, (int)$aFaixa['7500+']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, Util::formataMoeda(75*$aFaixa['7500+']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, (int)$aFaixaDep['7500+']['0-38'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, Util::formataMoeda(75*$aFaixaDep['7500+']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, Util::formataMoeda(75*$aFaixa['7500+']['0-38']+75*$aFaixaDep['7500+']['0-38']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, Util::formataMoeda(85), 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, (int)$aFaixa['7500+']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, 85*$aFaixa['7500+']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, (int)$aFaixaDep['7500+']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, 85*$aFaixaDep['7500+']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, 85*$aFaixa['7500+']['39-58']+85*$aFaixaDep['7500+']['39-58'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, Util::formataMoeda(100), 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, (int)$aFaixa['7500+']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, Util::formataMoeda(100*$aFaixa['7500+']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, (int)$aFaixaDep['7500+']['59+'], 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, Util::formataMoeda(100*$aFaixaDep['7500+']['59+']), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, Util::formataMoeda(100*$aFaixa['7500+']['59+']+100*$aFaixaDep['7500+']['59+']), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->SetFont('Arial', 'B', 8);

$valor_total_serv[0] = 30*$aFaixa['0-1499.99']['0-38'] + 
                    35*$aFaixa['1500-1999.99']['0-38'] + 
                    40*$aFaixa['2000-2499.99']['0-38'] + 
                    45*$aFaixa['2500-2999.99']['0-38'] + 
                    50*$aFaixa['3000-3999.99']['0-38'] +
                    55*$aFaixa['4000-5499.99']['0-38'] +
                    65*$aFaixa['5500-7499.99']['0-38'] + 
                    75*$aFaixa['7500+']['0-38'];

$valor_total_serv[1] = 40*$aFaixa['0-1499.99']['39-58'] +
                    45*$aFaixa['1500-1999.99']['39-58'] +
                    50*$aFaixa['2000-2499.99']['39-58'] +
                    55*$aFaixa['2500-2999.99']['39-58'] +
                    60*$aFaixa['3000-3999.99']['39-58'] +
                    65*$aFaixa['4000-5499.99']['39-58'] +
                    75*$aFaixa['5500-7499.99']['39-58'] +
                    85*$aFaixa['7500+']['39-58'];

$valor_total_serv[2] = 50*$aFaixa['0-1499.99']['59+'] +
                    55*$aFaixa['1500-1999.99']['59+'] +
                    60*$aFaixa['2000-2499.99']['59+'] +
                    65*$aFaixa['2500-2999.99']['59+'] +
                    70*$aFaixa['3000-3999.99']['59+'] +
                    75*$aFaixa['4000-5499.99']['59+'] +
                    85*$aFaixa['5500-7499.99']['59+'] +
                    100*$aFaixa['7500+']['59+'];

$valor_total_dep[0] = 30*$aFaixaDep['0-1499.99']['0-38'] + 
                    35*$aFaixaDep['1500-1999.99']['0-38'] + 
                    40*$aFaixaDep['2000-2499.99']['0-38'] + 
                    45*$aFaixaDep['2500-2999.99']['0-38'] + 
                    50*$aFaixaDep['3000-3999.99']['0-38'] +
                    55*$aFaixaDep['4000-5499.99']['0-38'] +
                    65*$aFaixaDep['5500-7499.99']['0-38'] + 
                    75*$aFaixaDep['7500+']['0-38'];

$valor_total_dep[1] = 40*$aFaixaDep['0-1499.99']['39-58'] +
                    45*$aFaixaDep['1500-1999.99']['39-58'] +
                    50*$aFaixaDep['2000-2499.99']['39-58'] +
                    55*$aFaixaDep['2500-2999.99']['39-58'] +
                    60*$aFaixaDep['3000-3999.99']['39-58'] +
                    65*$aFaixaDep['4000-5499.99']['39-58'] +
                    75*$aFaixaDep['5500-7499.99']['39-58'] +
                    85*$aFaixaDep['7500+']['39-58'];

$valor_total_dep[2] = 50*$aFaixaDep['0-1499.99']['59+'] +
                    55*$aFaixaDep['1500-1999.99']['59+'] +
                    60*$aFaixaDep['2000-2499.99']['59+'] +
                    65*$aFaixaDep['2500-2999.99']['59+'] +
                    70*$aFaixaDep['3000-3999.99']['59+'] +
                    75*$aFaixaDep['4000-5499.99']['59+'] +
                    85*$aFaixaDep['5500-7499.99']['59+'] +
                    100*$aFaixaDep['7500+']['59+'];

$total_servidores = $total_servidor_0_38 + $total_servidor_39_58 + $total_servidor_59_;
$total_dependentes = $total_dep_0_38 + $total_dep_39_58 + $total_dep_59_;
$total_pessoas = $total_servidores  + $total_dependentes;

$oPDF->Cell($wQtd[0], $altura, utf8_decode('Subtotal'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1], $altura, '-', 1, 0, 'C', false);
$oPDF->Cell($wQtd[2], $altura, $total_servidor_0_38, 1, 0, 'C', false);
$oPDF->Cell($wQtd[3], $altura, Util::formataMoeda($valor_total_serv[0]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[4], $altura, $total_dep_0_38, 1, 0, 'C', false);
$oPDF->Cell($wQtd[5], $altura, Util::formataMoeda($valor_total_dep[0]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[6], $altura, Util::formataMoeda($valor_total_serv[0] + $valor_total_dep[0]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7], $altura, '-', 1, 0, 'C', false);
$oPDF->Cell($wQtd[8], $altura, $total_servidor_39_58, 1, 0, 'C', false);
$oPDF->Cell($wQtd[9], $altura, Util::formataMoeda($valor_total_serv[1]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[10], $altura, $total_dep_39_58, 1, 0, 'C', false);
$oPDF->Cell($wQtd[11], $altura, Util::formataMoeda($valor_total_dep[1]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[12], $altura, Util::formataMoeda($valor_total_serv[1] + $valor_total_dep[1]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13], $altura, '-', 1, 0, 'C', false);
$oPDF->Cell($wQtd[14], $altura, $total_servidor_59_, 1, 0, 'C', false);
$oPDF->Cell($wQtd[15], $altura, Util::formataMoeda($valor_total_serv[2]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[16], $altura, $total_dep_59_, 1, 0, 'C', false);
$oPDF->Cell($wQtd[17], $altura, Util::formataMoeda($valor_total_dep[2]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[18], $altura, Util::formataMoeda($valor_total_serv[2] + $valor_total_dep[2]), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('Subtotal por Faixa (R$)'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1]+$wQtd[2]+$wQtd[3]+$wQtd[4]+$wQtd[5]+$wQtd[6], $altura, Util::formataMoeda($valor_total_serv[0] + $valor_total_dep[0]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[7]+$wQtd[8]+$wQtd[9]+$wQtd[10]+$wQtd[11]+$wQtd[12], $altura, Util::formataMoeda($valor_total_serv[1] + $valor_total_dep[1]), 1, 0, 'C', false);
$oPDF->Cell($wQtd[13]+$wQtd[14]+$wQtd[15]+$wQtd[16]+$wQtd[17]+$wQtd[18], $altura, Util::formataMoeda($valor_total_serv[2] + $valor_total_dep[2]), 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('Beneficários por Faixa'), 1, 0, 'C', false);
$oPDF->Cell($wQtd[1]+$wQtd[2]+$wQtd[3]+$wQtd[4]+$wQtd[5]+$wQtd[6], $altura, $total_servidor_0_38 + $total_dep_0_38, 1, 0, 'C', false);
$oPDF->Cell($wQtd[7]+$wQtd[8]+$wQtd[9]+$wQtd[10]+$wQtd[11]+$wQtd[12], $altura, $total_servidor_39_38 + $total_dep_39_58, 1, 0, 'C', false);
$oPDF->Cell($wQtd[13]+$wQtd[14]+$wQtd[15]+$wQtd[16]+$wQtd[17]+$wQtd[18], $altura, $total_servidor_59_ + $total_dep_59_, 1, 0, 'C', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('Total de Servidores'), 1, 0, 'C', false);
$oPDF->Cell(array_sum($wQtd)-$wQtd[0], $altura, $total_servidores, 1, 0, 'R', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('Total de Dependentes'), 1, 0, 'C', false);
$oPDF->Cell(array_sum($wQtd)-$wQtd[0], $altura, $total_dependentes, 1, 0, 'R', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('Total de Vidas'), 1, 0, 'C', false);
$oPDF->Cell(array_sum($wQtd)-$wQtd[0], $altura, $total_pessoas, 1, 0, 'R', false);
$oPDF->Ln();
$oPDF->Cell($wQtd[0], $altura, utf8_decode('Valor Total (R$)'), 1, 0, 'C', false);
$oPDF->Cell(array_sum($wQtd)-$wQtd[0], $altura, Util::formataMoeda(array_sum($valor_total_serv)+array_sum($valor_total_dep)), 1, 0, 'R', false);
$oPDF->Ln();
$oPDF->Output();