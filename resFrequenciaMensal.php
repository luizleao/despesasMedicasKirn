<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasServidor();
$oPDF = new FPDF();

$aFiltro[] = "sicas_servidor.cd_categoria in (
                                                ".SicasPessoaCategoriaEnum::ATIVO_PERMANENTE.",
                                                ".SicasPessoaCategoriaEnum::REQUISITADO.",
                                                ".SicasPessoaCategoriaEnum::CARGO_EM_COMISSAO.",
                                                ".SicasPessoaCategoriaEnum::LOTACAO_PROVISORIA.",
                                                ".SicasPessoaCategoriaEnum::CONTRATO_TEMPORARIO.",
                                                ".SicasPessoaCategoriaEnum::SERVIDOR.")";
$aFiltro[] =  "sicas_servidor.status = 1";

$aFiltro[] = ($_REQUEST['cd_servidor'] != '') ? "sicas_servidor.cd_servidor={$_REQUEST['cd_servidor']}" : "sicas_lotacao.cd_lotacao={$_REQUEST['cd_lotacao']}";

//Util::trace($aFiltro);

$aServidor = $oController->getAll($aFiltro, ["sicas_pessoa.nm_pessoa"]);
// Util::trace($_REQUEST);exit;
// echo Util::getDiaSemana(15, 1, 2015);
// echo Util::getDiaSemanaExtenso(15, 1, 2015);exit;

$aMesAno = ($_REQUEST['mesano'] != "") ? explode("/", $_REQUEST['mesano']) : explode("/", date("m/Y"));
$mesExtenso = Util::getMesExtenso($aMesAno[0]);
$qtdDias = Util::getNumeroDiasMes($aMesAno[0], $aMesAno[1]);

// Lista de Feriados do mes
$aFeriado = (new ControllerRhFeriado())->getAll(["rh_feriado.data_feriado like '{$aMesAno[1]}-{$aMesAno[0]}%'"], 
										        ["data_feriado"]);

if($aFeriado) {
	foreach($aFeriado as $oFeriado) {
		$hashFeriado[$oFeriado->data_feriado] = $oFeriado->descricao_feriado;
	}
}
// Util::trace($hashFeriado); exit;
$header = ['Dia', 'Entrada', 'Saída', 'Entrada', 'Saída', 'Rubrica', 'Compensação'];
// Cabeçalho
$w = [6, 20, 20, 20, 20, 52, 52]; // 6+45+30+45+50

foreach($aServidor as $oServidor) {
	$oPDF->AddPage();
	$oPDF->Image('img/logo_sudam_peq.jpg', 90, 5, 0, 0, '', '');
	
	// Colors, line width and bold font
	$oPDF->SetFont('Arial', '', 8);
	$oPDF->SetLineWidth(.1);
	$oPDF->SetFont('', 'B');
	
	$oPDF->Cell(100, 15, '', 0, 0, 'C', false);
	$oPDF->Ln();
	
	$oPDF->SetTextColor(0);
	$oPDF->SetFont('Arial', '', 8);
	$oPDF->Cell(180, 6, utf8_decode('Superintendência do Desenvolvimento da Amazônia'), 0, 0, 'C', false);
	$oPDF->Ln();
	$oPDF->Cell(180, 6, utf8_decode('Frequência Mensal'), 0, 0, 'C', false);
	$oPDF->Ln();
	$oPDF->Cell(172, 6, 'MES/ANO:', 0, 0, 'R', false);
	$oPDF->Cell(20, 6, utf8_decode($mesExtenso).'/'.$aMesAno[1], 0, 0, 'R', false);
	$oPDF->Ln();
	$oPDF->Cell(12, 6, 'Servidor: ', 0, 0, 'L', false);
	$oPDF->Cell(80, 6, utf8_decode($oServidor->oSicasPessoa->nm_pessoa), 0, 0, 'L', false);
	$oPDF->Cell(20, 6, 'Mat. SIAPE:', 0, 0, 'L', false);
	$oPDF->Cell(20, 6, $oServidor->cd_matricula, 0, 0, 'L', false);
	$oPDF->Cell(60, 6, $oServidor->oSicasPessoa->oSicasPessoaCategoria->desc_categoria, 0, 0, 'R', false);
	$oPDF->Ln();
	$oPDF->Cell(12, 6, utf8_decode('Unidade: '), 0, 0, 'L', false);
	$oPDF->Cell(25, 6, $oServidor->oSicasLotacao->sigla, 0, 0, 'L', false);
	$oPDF->Cell(10, 6, 'Cargo: ', 0, 0, 'L', false);
	$oPDF->Cell(59, 6, $oServidor->oRhCargo->num_siape_cargo.' - '.$oServidor->oRhCargo->descricao_cargo_abrev, 0, 0, 'L', false);
	$oPDF->Cell(46, 6, 'Carga Horaria: ________', 0, 0, 'L', false);
	$oPDF->Cell(10, 6, 'Horas Semanais: _________', 0, 0, 'L', false);
	$oPDF->Ln();
	
	$oPDF->SetFillColor(231,231,231); // Cor de Preenchimento
	$oPDF->SetDrawColor(0,0,0); // Cor de Contorno
	                              // $oPDF->SetDrawColor(211, 211, 211); //Cor de Contorno
	$oPDF->SetFont('Arial', '', 8);
	$oPDF->SetTextColor(0);
	
	for($i=0; $i < count($header); $i++) {
		$oPDF->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
	}
	
	$oPDF->Ln();
	
	// Color and font restoration
	$oPDF->SetFillColor(255,250,250);
	$oPDF->SetTextColor(0);
	$oPDF->SetFont('');
	// Data
	$fill = false;
	for($i = 1; $i <= $qtdDias; $i ++){
		$diaFolga = $hashFeriado[$aMesAno[1].'-'.$aMesAno[0].'-'.((strlen($i) == 1) ? "0$i" : $i)];
		if($diaFolga == '')
			$diaFolga = utf8_decode(Util::getDiaSemana($i, $aMesAno[0], $aMesAno[1]) == 6 || Util::getDiaSemana($i, $aMesAno[0], $aMesAno[1]) == 0) ? Util::getDiaSemanaExtenso($i, $aMesAno[0], $aMesAno[1]) : "";
			
			// Cell(float w[, float h[, string txt[, mixed border[, int ln[, string align[, boolean fill[, mixed link]]]]]]])
		if(utf8_decode($diaFolga) != '') {
			$oPDF->Cell($w[0], 6, $i, 1, 0, 'L', $fill);
			$oPDF->Cell(array_sum($w) - $w[0], 6, utf8_decode($diaFolga), 1, 0, 'L', $fill);
		} else {
			$oPDF->Cell($w[0], 6, $i, 1, 0, 'L', $fill);
			$oPDF->Cell($w[1], 6, utf8_decode($diaFolga), 1, 0, 'L', $fill);
			$oPDF->Cell($w[2], 6, '', 1, 0, 'R', $fill);
			$oPDF->Cell($w[3], 6, '', 1, 0, 'R', $fill);
			$oPDF->Cell($w[4], 6, '', 1, 0, 'R', $fill);
			$oPDF->Cell($w[5], 6, '', 1, 0, 'R', $fill);
			$oPDF->Cell($w[6], 6, '', 1, 0, 'R', $fill);
			$oPDF->Cell($w[7], 6, '', 1, 0, 'R', $fill);
			$oPDF->Cell($w[8], 6, '', 1, 0, 'R', $fill);
			$oPDF->Cell($w[9], 6, '', 1, 0, 'R', $fill);
			$oPDF->Cell($w[10], 6, '', 1, 0, 'R', $fill);
		}
		
		$oPDF->Ln();
		// $fill = !$fill;
	}
	// Closing line
	$oPDF->Cell(array_sum($w), 0, '', 'T');
	
	$oPDF->Ln();
	$oPDF->Cell(0, 10, '', 0, 0, 'L', false);
	$oPDF->Ln();
	$oPDF->Cell(120, 6, '________________________________', 0, 0, 'C', false);
	$oPDF->Cell(10,  6, '________________________________', 0, 0, 'C', false);
	$oPDF->Ln();
	$oPDF->Cell(20, 6, '', 0, 0, 'L', false);
	$oPDF->Cell(80, 6, 'Assinatura do Servidor', 0, 0, 'C', false);
	$oPDF->Cell(50, 6, 'Assinatura do Chefe Imediato', 0, 0, 'C', false);
	$oPDF->Ln();
}

$oPDF->Output();