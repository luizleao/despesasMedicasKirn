<?php
require_once("../classes/autoload.php");

//print $_SERVER['REQUEST_URI'];

if(preg_match("#^.*/rest/(.*?)/!/(.*?)/?$#is", $_SERVER['REQUEST_URI'], $aux)){
    $aParam['classe'] = $aux[1];
    $aParam['texto'] = $aux[2];
    $aParam['consulta'] = true;
}

elseif(preg_match("#^.*/rest/(.*?)/(\d+)/?$#is", $_SERVER['REQUEST_URI'], $aux)){
    $aParam['classe'] = $aux[1];
    $aParam['id'] = $aux[2];
}

elseif(preg_match("#^.*/rest/(.*?)/?$#is", $_SERVER['REQUEST_URI'], $aux)){
    $aParam['classe'] = $aux[1];
} else {
    die('Nenhum padrao encontrado');
}

//Util::trace($aParam);

try{
    if(class_exists('Controller'.$aParam['classe'])){
        //print "\$oController = new Controller{$aParam['classe']}();";
        eval("\$oController = new Controller{$aParam['classe']}(true);");
        $aParam['classe'] = "";
    } else {
        $oController = new Controller(true);
    }
    
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            
            if($aParam['consulta'] == true){
                $exec = "\$a = \$oController->consultar{$aParam['classe']}('".urldecode($aParam['texto'])."');\n";
                //print $exec;
            } else {
                $exec = (isset($aParam['id'])) ? "\$a = \$oController->get{$aParam['classe']}({$aParam['id']});\n" : "\$a = \$oController->getAll{$aParam['classe']}();\n";
            }
		break;
                    
        case 'POST':
            $post = json_decode(file_get_contents("php://input"), true);
            $exec = "\$a = \$oController->cadastrar{$aParam['classe']}(\$post);\n";
        break;
            
        case 'PUT':
            $post = unserialize(file_get_contents("php://input"));
            $exec = "\$a = \$oController->alterar{$aParam['classe']}(\$post);\n";
        break;
            
        case 'DELETE':
            $exec = "\$a = \$oController->excluir{$aParam['classe']}({$aParam['id']});\n";
        break;
    }
    //print "$exec";
	eval($exec);
	
} catch(Exception $e){
    $a = $e->getMessage();
}
header("content-type: application/json; charset=UTF-8");
echo json_encode($a);