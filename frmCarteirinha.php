<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasServidor();

class PDF extends FPDF {
	// Page header
	function Header() {
		
	}
	
	// Page footer
	function Footer() {
		
	}
}

$oPDF = new PDF();
$oPDF->AddPage();

$hFoto = 6;
$oPDF->Image('img/bgCarteirinhaServidor.png', 10, $hFoto, 0, 0, '', '');

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
$oServidor = $oController->get($_REQUEST['cd_servidor']); //352

if($oServidor->foto != "")
    $oPDF->Image('fotos/'.$oServidor->foto, 11, 9, 20, 20, '', '');
// Util::trace($aServidor);exit;

// Cell(float w[, float h[, string txt[, mixed border[, int ln[, string align[, boolean fill[, mixed link]]]]]]])
$h = 4;
$borda = 0;

function linhaVazia($oPDF, $ln){
    $oPDF->Cell(90, $ln, " ",  0, 0, 'L', false);
    $oPDF->Ln();
}

linhaVazia($oPDF, 16);
$oPDF->Cell(21, $h, " ", $borda, 0, 'L', false);
$oPDF->Cell(69, $h, utf8_decode($oServidor->oSicasPessoa->nm_pessoa), $borda, 0, 'L', false);
$oPDF->Ln();
linhaVazia($oPDF, 3);
$oPDF->Cell(3, $h, " ", $borda, 0, 'L', false);
$oPDF->Cell(87, $h, utf8_decode($oServidor->oSicasPessoa->endereco), $borda, 0, 'L', false);
$oPDF->Ln();
linhaVazia($oPDF, 3);
$oPDF->Cell(3, $h, " ", $borda, 0, 'L', false);
$oPDF->Cell(29, $h, utf8_decode($oServidor->oSicasPessoa->telefone), $borda, 0, 'L', false);
$oPDF->Cell(28, $h, utf8_decode(Util::formataDataBancoForm($oServidor->oSicasPessoa->dt_nascimento)), $borda, 0, 'L', false);
$oPDF->Cell(30, $h, utf8_decode(Util::formataDataBancoForm($oServidor->oSicasPessoaCategoria->desc_categoria_abrev)), $borda, 0, 'L', false);
$oPDF->Ln();
linhaVazia($oPDF, 3);
$oPDF->Cell(3, $h, " ", $borda, 0, 'L', false);
$oPDF->Cell(29, $h, utf8_decode($oServidor->oSicasLotacao->sigla), $borda, 0, 'L', false);
$oPDF->Cell(58, $h, utf8_decode($oServidor->oSicasPessoa->grupo_sanguineo), $borda, 0, 'L', false);
$oPDF->Ln();
linhaVazia($oPDF, 3);
$oPDF->Cell(3, $h, " ", $borda, 0, 'L', false);
$oPDF->Cell(57, $h, utf8_decode($oServidor->oSicasPessoa->nm_pessoa), $borda, 0, 'L', false);
$oPDF->Cell(30, $h, utf8_decode($oServidor->cd_matricula), $borda, 0, 'L', false);
$oPDF->Ln();
linhaVazia($oPDF, 3);
$oPDF->Cell(20, $h, " ", $borda, 0, 'L', false);
$oPDF->Cell(70, $h, utf8_decode("Jeanne Maria Lima de Aragão"), $borda, 0, 'L', false);
$oPDF->Ln();

$oControllerDependente = new ControllerSicasDependente();
$aDependente = $oControllerDependente->getAll(["sicas_servidor.cd_servidor = ".$oServidor->cd_servidor, "sicas_dependente.status=1"]);

if($aDependente){
    $oPDF->AddPage();
    $yDepend = 9;
    $wRecuo = 4;
    $hFirstLine = 19;
    
    $countDepend = 1;
    foreach($aDependente as $oDependente){
        $oPDF->Image('img/bgCarteirinhaDependente.png', 11, $yDepend, 0, 0, '', '');
        
        linhaVazia($oPDF, $hFirstLine);
        $oPDF->Cell(22, $h, " ", $borda, 0, 'L', false);
        $oPDF->Cell(68, $h, utf8_decode($oDependente->oSicasPessoa->nm_pessoa), $borda, 0, 'L', false);
        $oPDF->Ln();
        linhaVazia($oPDF, 3);
        $oPDF->Cell($wRecuo, $h, " ", $borda, 0, 'L', false);
        $oPDF->Cell(86, $h, utf8_decode($oDependente->oSicasPessoa->endereco), $borda, 0, 'L', false);
        $oPDF->Ln();
        linhaVazia($oPDF, 3);
        $oPDF->Cell($wRecuo, $h, " ", $borda, 0, 'L', false);
        $oPDF->Cell(29, $h, utf8_decode($oDependente->oSicasPessoa->telefone), $borda, 0, 'L', false);
        $oPDF->Cell(28, $h, utf8_decode(Util::formataDataBancoForm($oDependente->oSicasPessoa->dt_nascimento)), $borda, 0, 'L', false);
        $oPDF->Cell(29, $h, utf8_decode($oDependente->oSicasPessoa->oSicasPessoaCategoria->desc_categoria_abrev), $borda, 0, 'L', false);
        $oPDF->Ln();
        linhaVazia($oPDF, 3);
        $oPDF->Cell($wRecuo, $h, " ", $borda, 0, 'L', false);
        $oPDF->Cell(29, $h, utf8_decode($oServidor->oSicasLotacao->sigla), $borda, 0, 'L', false);
        $oPDF->Cell(28, $h, utf8_decode($oDependente->oSicasPessoa->grupo_sanguineo), $borda, 0, 'L', false);
        $oPDF->Cell(29, $h, utf8_decode($oDependente->oSicasGrauParentesco->desc_grauparentesco), $borda, 0, 'L', false);
        $oPDF->Ln();
        linhaVazia($oPDF, 3);
        $oPDF->Cell($wRecuo, $h, " ", $borda, 0, 'L', false);
        $oPDF->Cell(57, $h, utf8_decode($oServidor->oSicasPessoa->nm_pessoa), $borda, 0, 'L', false);
        $oPDF->Cell(29, $h, utf8_decode($oServidor->cd_matricula), $borda, 0, 'L', false);
        $oPDF->Ln();
        linhaVazia($oPDF, 3);
        $oPDF->Cell(20, $h, " ", $borda, 0, 'L', false);
        $oPDF->Cell(70, $h, utf8_decode("Jeanne Maria Lima de Aragão"), $borda, 0, 'L', false);
        $oPDF->Ln();
        linhaVazia($oPDF, 12);
        $yDepend += 70;
        $countDepend++;
        
        if($countDepend == 4){
            $oPDF->AddPage();
            $countDepend = 1;
            $yDepend = 9;
        }
        
    }
}
$oPDF->Output();