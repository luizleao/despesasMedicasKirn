<?php 
require_once '../classes/autoload.php';

$oController = new ControllerSicasServidor();
$file = fopen('../doc/bd/carga_saldo.csv', 'r');

$i=1;
while (($line = fgets($file, 4096)) !== false) {
    $aDados = explode(';', $line);
    
    //Util::trace($aDados);
    
    $oServidor = $oController->getByMatricula($aDados[0]);
    
    if($oServidor){
        $oServidor->vl_saldo_odonto = (float) str_replace(",", ".", $aDados[1]);
        
        if(!$oController->alterar($oServidor)){
            //Util::trace($oServidor);
            echo "Falha de processamento .................. {$aDados[0]} - {$aDados[1]}: $oController->msg</br>";
        } else {
            //echo "Linha $i ................................ {$aDados[0]}: Ok</br>";
        }
    } else {
        echo "Linha $i ................................ {$aDados[0]}: Servidor não encontrado</br>";
    }
    $i++;
}
    
fclose($file);