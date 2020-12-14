<?php
/**
 * Conjunto de rotinas de auxílio ao desenvolvimento
 * 
 * @author Luiz Leão <luizleao@gmail.com>
 * @version 2.0.0
 */
class Util {
    
    /**
     * Retorna a lista dos cargos em comissao
     *
     * @return string[]
     */
    static function getAllCargoComissao(){
        return ['-','DAS 101 6', 'DAS 101 5', 'DAS 101 4', 'DAS 101 3', 'DAS 101 2', 'DAS 101 1', 'DAS 102 6', 'DAS 102 5', 'DAS 102 4', 'DAS 102 3', 'DAS 102 2', 'DAS 102 1',
                'FG 1', 'FG 2', 'FG 3', 'FG 4', 'FG 5', 'FG 6', 'FG 7', 'FG 8', 'FG 9',
                'FCPE 101 6', 'FCPE 101 5', 'FCPE 101 4', 'FCPE 101 3', 'FCPE 101 2', 'FCPE 101 1', 'FCPE 102 6', 'FCPE 102 5', 'FCPE 102 4', 'FCPE 102 3', 'FCPE 102 2', 'FCPE 102 1',
                'FCT 1', 'FCT 2', 'FCT 3', 'FCT 4', 'FCT 5', 'FCT 6', 'FCT 7', 'FCT 8', 'FCT 9', 'FCT 10', 'FCT 11', 'FCT 12', 'FCT 13', 'FCT 14', 'FCT 15'];
    }
    
	/**
	 * Retorna a lista de estados brasileiros
	 *
	 * @return string[]
	 */
	static function getAllEstados(){
		return array ("AC","AL","AP","AM","BA","CE","DF","ES","GO","MA","MT","MS","MG","PA","PB","PR","PE","PI","RJ","RN","RS","RO","RR","SC","SP","SE","TO");
	}
	
	/**
	 * Retorna o dia da semana
	 *
	 * @param int $dia        	
	 * @param int $mes        	
	 * @param int $ano        	
	 * @return int
	 */
	static function getDiaSemana($dia, $mes, $ano){
		return date('w', mktime(0, 0, 0, $mes, $dia, $ano));
	}
	
	/**
	 * Retorna o dia da semana por extenso
	 *
	 * @param int $dia        	
	 * @param int $mes        	
	 * @param int $ano        	
	 * @return string
	 */
	static function getDiaSemanaExtenso($dia, $mes, $ano){
		$a = array ("Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado");
		return $a [Util::getDiaSemana($dia, $mes, $ano)];
	}
	
	/**
	 * Retorna o mês por extenso
	 *
	 * @param string $mes        	
	 * @return string
	 */
	static function getMesExtenso($mes){
		$regMes = Util::getAllMesExtenso ();
		return $regMes [$mes - 1];
	}
	
	/**
	 * Retorna a lista dos meses do ano por extenso
	 *
	 * @return string[]
	 */
	static function getAllMesExtenso(){
		return array ("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
	}
	
	/**
	 * Verifica se o e-mail é válido
	 *
	 * @param string $email        	
	 * @return boolean
	 */
	static function validaEmail($email){
		// Create the syntactical validation regular expression
		$regexp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
		// Presume that the email is invalid
		$valid = 0;
		// Validate the syntax
		return (eregi($regexp, $email)) ? true : false;
	}
	
	/**
	 * Verifica se o login é válido
	 *
	 * @param string $x        	
	 * @return boolean
	 */
	static function validaLogin($x){
		return ereg("^([A-Z])([A-Z_0-9]){1,23}([A-Z0-9])$", $x);
	}
	
	/**
	 * Calcula a idade formato aaaa-mm-dd
	 *
	 * @param string $date        	
	 * @return int
	 */
	static function calculaIdade($date){
		list($birth_year, $birth_month, $birth_day) = explode("-", $date);
		
		$datestamp = date("d.m.Y", time());
		$t_arr = explode(".", $datestamp);
		
		$year_dif = $t_arr [2] - $birth_year;
		
		$age = (($birth_month > $t_arr [1]) || ($birth_month == $t_arr [1] && $t_arr [0] < $birth_day)) ? $year_dif - 1 : $year_dif;
		
		return $age;
	}
	
	/**
	 * Verifica se a data é válida
	 *
	 * @param string $data        	
	 * @param string $sep        	
	 * @return boolean
	 */
	static function validaData($data, $sep = "/"){
		list($dia, $mes, $ano) = explode($sep, $data);
		return checkdate (( int) $mes,(int) $dia,(int) $ano);
	}
	
	/**
	 * Elimina a tag selecionada
	 *
	 * @param string $tag        	
	 * @param string $text        	
	 * @return string
	 */
	static function drop_tag($tag, $text){
		$text = strtolower($text);
		$tag = strtolower($tag);
		$text = str_replace("<$tag/>", "", $text);
		$text = str_replace("<$tag>", "", $text);
		$text = str_replace("</$tag>", "", $text);
		$text = ereg_replace("<$tag .*>", "", $text);
		return $text;
	}
	
    
	/**
	 * Converte a data do Formulario para o formato do SGBD
	 *
	 * @param string $data        	
	 * @return string
	 */
	static function formataDataFormBanco($data){
		return implode("-", array_reverse(explode("/", $data)));
	}
	
	/**
	 * Converte a data do SGBD para o formato do Formulario
	 *
	 * @param string $data        	
	 * @return string
	 */
	static function formataDataBancoForm($data){
		return implode("/", array_reverse(explode("-", $data)));
	}
	
	/**
	 * Converte a data/hora do SGBD para o formato do Formulario
	 *
	 * @param string $dataHora        	
	 * @return string|null
	 */
	static function formataDataHoraBancoForm($dataHora, $flagHora=true){
		if ($dataHora != ''){
			$aDataHora = explode(" ", $dataHora);
			$aData = explode("-", $aDataHora [0]);
			
			if(preg_match("#^(\d{2}):(\d{2}):(\d{2})\.(\d{3})$#", $aDataHora[1], $aux)){
			    $hora = $aux[1].":".$aux[2].":".$aux[3];
			} else {
			    $hora = $aDataHora[1];
			}
			
			return ($flagHora) ? "{$aData[2]}/{$aData[1]}/{$aData[0]} $hora" : "{$aData[2]}/{$aData[1]}/{$aData[0]}";
		} else
			return "";
	}
	
	/**
	 * Converte a data/hora do Formulario para o formato do SGBD
	 *
	 * @param string $dataHora        	
	 * @return string|null
	 */
	static function formataDataHoraFormBanco($dataHora){
		// 2007-11-23 14:43:06
		if ($dataHora != ''){
			$aDataHora = explode(" ", $dataHora);
			$aData = explode("/", $aDataHora [0]);
			
			return "{$aData[2]}-{$aData[1]}-{$aData[0]} {$aDataHora[1]}";
		}
		return null;
	}
	
	/**
	 * Formata o valor em moeda
	 *
	 * @param string $valor        	
	 * @return float
	 */
	static function formataMoeda($valor){
		return number_format($valor, 2, ",", ".");
	}
	
	/**
	 * Formata o valor em moeda
	 *
	 * @param string $valor
	 * @return float
	 */
	static function formataMoedaBanco($valor){
	    $valor = str_replace(".", "", $valor);
	    $valor = str_replace(",", ".", $valor);
	    return $valor;
	}
	
	/**
	 * Formata CPF
	 *
	 * @param int $cpf        	
	 * @return string
	 */
	static function formataCPF($cpf){
        //51825716234
        if(preg_match("#\d{11}#is", $cpf))
            return substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, 9, 2);
		else
            return "-";
	}
	
	/**
	 * Formata CNPJ
	 *
	 * @param int $cnpj        	
	 * @return string
	 */
	static function formataCNPJ($cnpj){
		// 08.583.284/0001-06
		// 08583284000106
	    if(preg_match("#\d{14}#is", $cnpj))
            return substr($cnpj, 0, 2) . "." . substr($cnpj, 2, 3) . "." . substr($cnpj, 5, 3) . "/" . substr($cnpj, 8, 4) . "-" . substr($cnpj, 12, 2);
	    else 
	        return "-";
	}
	
	/**
	 * Formata CEP
	 *
	 * @param int $cep
	 * @return string
	 */
	static function formataCEP($cep){
        //limpar dados
	    $cep = preg_replace("#\D#is", "", $cep);
	    
	    if(preg_match("#^(\d{5})(\d{3})$#is", $cep, $result)){
	        //Util::trace($result);
	        return "{$result[1]}-{$result[2]}";
	    }
	    return $cep;
	}
	
	/**
	 * Formata Telefone
	 *
	 * @param int $telefone
	 * @return string
	 */
	static function formataTelefone($telefone){
	    //limpar dados
	    $telefone = preg_replace("#\D#is", "", $telefone);
	    
	    if(strlen($telefone) == 10){
    	    if(preg_match("#^(\d{2})(\d{4})(\d{4})$#is", $telefone, $result)){
    	        //Util::trace($result);
    	        $telefone = "({$result[1]}) {$result[2]}-{$result[3]}";
    	    }
	    } else {
	        if(preg_match("#^(\d{2})(\d{3})(\d{4})$#is", $telefone, $result)){
	            //Util::trace($result);
	            $telefone = "({$result[1]}) {$result[2]}-{$result[3]}";
	        }
	    }
	    return $telefone;
	}
	
	/**
	 * Formatar encaminhamento
	 *
	 * @param string $encaminhamento
	 * @return string
	 */
	static function formataEncaminhamento($encaminhamento){
	    //0000677395-003/122019.008
	    //0000677395-003/122019.008
	    if(preg_match("#^(\d{10})(\d{3})(\d{6})(\d{3})$#is", $encaminhamento, $result)){
	        //Util::trace($result);
	        $encaminhamento = "{$result[1]}-{$result[2]}/{$result[3]}.{$result[4]}";
	    }
	    
	    return $encaminhamento;
	}

	/**
	 * Formatar numero do procedimento
	 *
	 * @param string $encaminhamento
	 * @return string
	 */
	static function formataNumProcedimento($numProcedimento){
	    //0.00.10.01.4
	    if(preg_match("#^(\d{1})(\d{2})(\d{2})(\d{2})(\d{1})$#is", $numProcedimento, $result)){
	        //Util::trace($result);
	        $numProcedimento = "{$result[1]}.{$result[2]}.{$result[3]}.{$result[4]}.{$result[5]}";
	    }
	    
	    return $numProcedimento;
	}
	
	/**
	 * Recupera tipo pessoa (fisica ou juridica)
	 *
	 * @param string $pessoa
	 * @return string
	 */
	static function getTipoPessoa($pessoa){
	    //51825716234
	    if(preg_match("#^P?F$#is", $pessoa))
	        return "Física";
        elseif(preg_match("#^P?J$#is", $pessoa))
            return "Jurídica";
        else
            return "-";
	}
	
	/**
	 * Recupera o número de dias do mês
	 *
	 * @param int $mes        	
	 * @param int $ano        	
	 * @return int
	 */
	static function getNumeroDiasMes($mes, $ano){
		return date('t', strtotime("$ano-$mes-01"));
	}
	
	/**
	 * Total de dias uteis do Mês
	 *
	 * @param int $ano        	
	 * @param int $mes        	
	 * @param int $dia        	
	 * @return int
	 */
	static function totalDiasUteisMes($ano, $mes, $dia = 1){
		$total = 0;
		for($i = $dia; $i <= date('t', strtotime("$ano-$mes-01")); $i ++){
			$diaSemana = date('l', mktime(0, 0, 0, $mes, $i, $ano));
			if ($diaSemana == "Saturday" || $diaSemana == "Sunday")
				continue;
			$total ++;
		}
		return $total;
	}
	
	/**
	 * Recupera a data posterior em dias a mais
	 *
	 * @param int $data
	 * @param int $dias
	 * @return Date
	 */
	static function getDataPosterior($data, $dias){
	    return date('Y-m-d', strtotime("$data +$dias days"));
	}
	
	/**
	 * Carrega lista de arquivos de um diretório
	 *
	 * @param string $diretorio        	
	 * @return string[]
	 */
	static function carregarColcaoArquivosDiretorio($diretorio){
		$arquivos = array ();
		// $dir = dirname(__FILE__)."/../xml/";
		// $dh = opendir($dir);
		$dh = opendir($diretorio);
		while (($file = readdir($dh)) !== false){
			if ($file != ".." && $file != "." && $file != ".svn"){
				$arquivos [] = $file;
			}
		}
		return $arquivos;
	}
	
	/**
	 * Copia diretório para destino
	 *
	 * @param string $alvo        	
	 * @param string $destino        	
	 * @return boolean
	 */
	static function copydir($alvo, $destino){
		if (! is_dir($destino)){
			// echo "Arquivo: $destino\n";
			mkdir($destino);
		}
		if ($handle = opendir($alvo)){
			while(false !== ($file = readdir($handle))){
				if ($file != "." && $file != ".."){
					if (is_dir("$alvo/$file")){
						if (! is_dir("$destino/$file")){
							mkdir("$destino/$file");
						}
						Util::copydir("$alvo/$file", "$destino/$file");
					} else {
						copy("$alvo/$file", "$destino/$file");
					}
				}
			}
			closedir($handle);
		}
		return true;
	}
	
	/**
	 * Formata os parametros da estrutura 'like' do SQL para que possa receber vários tokens
	 *
	 * @param string $valor        	
	 * @return string
	 */
	static function formataConsultaLike($valor){
		return "%".join("%", explode(" ", trim($valor))) . "%";
	}
	
	/**
	 * Função uppercase completa
	 *
	 * @param string $str        	
	 * @return string
	 */
	static function fullUpper($str){
		// convert to entities
		$subject = htmlentities($str, ENT_QUOTES);
		$pattern = '/&([a-z])(uml|acute|circ';
		$pattern .= '|tilde|ring|elig|grave|slash|horn|cedil|th);/e';
		$replace = "'&'.strtoupper('\\1').'\\2'.';'";
		$result = preg_replace($pattern, $replace, $subject);
		// convert from entities back to characters
		$htmltable = get_html_translation_table(HTML_ENTITIES);
		foreach($htmltable as $key => $value){
			$result = ereg_replace(addslashes($value), $key, $result);
		}
		return (strtoupper($result));
	}
	
	/**
	 * Substitui as letras acentuadas por letras sem acento
	 *
	 * @access public
	 * @param string $subject        	
	 * @return void
	 */
	static function tiraAcento($subject){
		$subject = preg_replace(utf8_decode("#[áàãâä]#i"), "a", $subject);
		$subject = preg_replace(utf8_decode("#[ÁÀÃÂÄ]#i"), "A", $subject);
		
		$subject = preg_replace(utf8_decode("#[éèêë]#"), "e", $subject);
		$subject = preg_replace(utf8_decode("#[ÉÈÊË]#"), "E", $subject);
		
		$subject = preg_replace(utf8_decode("#[íìîĩï]#"), "i", $subject);
		$subject = preg_replace(utf8_decode("#[ÍÌÎĨÏ]#"), "I", $subject);
		
		$subject = preg_replace(utf8_decode("#[óòõôö]#"), "o", $subject);
		$subject = preg_replace(utf8_decode("#[ÓÒÕÔÖ]#"), "O", $subject);
		
		$subject = preg_replace(utf8_decode("#[úùũûü]#"), "u", $subject);
		$subject = preg_replace(utf8_decode("#[ÚÙŨÛÜ]#"), "U", $subject);
		
		$subject = preg_replace(utf8_decode("#[ç]#"), "c", $subject);
		$subject = preg_replace(utf8_decode("#[Ç]#"), "C", $subject);
		return $subject;
	}
	
	/**
	 * Excluir tags selecionadas
	 *
	 * @param string $text        	
	 * @param string $tags        	
	 * @return string
	 */
	static function strip_selected_tags($text, $tags = array()){
		$args = func_get_args ();
		$text = array_shift($args);
		$tags = func_num_args () > 2 ? array_diff ($args, array ($text)) : (array) $tags;
		
		foreach($tags as $tag){
			if(preg_match_all('/<' . $tag . '[^>]*>(.*)<\/' . $tag . '>/iU', $text, $found)){
				$text = str_replace($found [0], $found [1], $text);
			}
		}
		return $text;
	}
	
	/**
	 * Valida CPF
	 *
	 * @param string $cpf        	
	 * @return boolean
	 */
	static function validaCPF($cpf){
		$c = substr("$cpf", 0, 9);
		$dv = substr("$cpf", 9, 2);
		$d1 = 0;
		for($i = 0; $i < 9; $i ++){
			$d1 += $c [$i] * (10 - $i);
		}
		if ($d1 == 0){
			return false;
		}
		$d1 = 11 - ($d1 % 11);
		if ($d1 > 9){
			$d1 = 0;
		}
		if ($dv [0] != $d1){
			return false;
		}
		$d1 *= 2;
		for($i = 0; $i < 9; $i ++){
			$d1 += $c [$i] * (11 - $i);
		}
		$d1 = 11 - ($d1 % 11);
		if ($d1 > 9){
			$d1 = 0;
		}
		if ($dv [1] != $d1){
			return false;
		}
		return true;
	}
	
	/**
	 * Valida CNPJ
	 *
	 * @param string $cnpj        	
	 * @return boolean
	 */
	static function validaCNPJ($cnpj){
		if (strlen($cnpj) != 14)
			return false;
		$soma1 = ($cnpj [0] * 5) + ($cnpj [1] * 4) + ($cnpj [2] * 3) + ($cnpj [3] * 2) + ($cnpj [4] * 9) + ($cnpj [5] * 8) + ($cnpj [6] * 7) + ($cnpj [7] * 6) + ($cnpj [8] * 5) + ($cnpj [9] * 4) + ($cnpj [10] * 3) + ($cnpj [11] * 2);
		
		$resto = $soma1 % 11;
		$digito1 = $resto < 2 ? 0 : 11 - $resto;
		$soma2 = ($cnpj [0] * 6) + ($cnpj [1] * 5) + ($cnpj [2] * 4) + ($cnpj [3] * 3) + ($cnpj [4] * 2) + ($cnpj [5] * 9) + ($cnpj [6] * 8) + ($cnpj [7] * 7) + ($cnpj [8] * 6) + ($cnpj [9] * 5) + ($cnpj [10] * 4) + ($cnpj [11] * 3) + ($cnpj [12] * 2);
		$resto = $soma2 % 11;
		$digito2 = $resto < 2 ? 0 : 11 - $resto;
		return (($cnpj [12] == $digito1) && ($cnpj [13] == $digito2));
	}
	
	/**
	 * Exibe a coleção de dados, de maneira formatada
	 *
	 * @param string[] $var        	
	 * @return void
	 */
	static function trace($var){
		print "<pre>";print_r($var);print "</pre>";
	}
	
	/**
	 * Elimina caracteres nao alfabeticos e numericos
	 * 
	 * @param string $campo
	 * @return mixed
	 */	
	static function limpaCampo($campo){
		return preg_replace("#[\.\-\(\)\s]#", "", $campo);
	}
	
	/**
	 * Retorna o status por extenso
	 * 
	 * @param int $status
	 * @return string
	 */
	static function getStatus($status){
	   return ($status==1) ? "Ativo" : "Inativo";
	}
	
	/**
	 * Retorna o Sim/Não por extenso
	 *
	 * @param int $status
	 * @return string
	 */
	static function getSimNao($texto){
	    return ($texto==1) ? "Sim" : "Não";
	}
}