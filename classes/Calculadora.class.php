<?php 
class Calculadora {
    static function getDescontoServidor($cd_pessoa, $flagInternacao) {
        $oControllerDependente    = new ControllerSicasDependente();
        $oControllerSalarioMinimo = new ControllerSicasSalarioMinimo();
        $oControllerSalario       = new ControllerSicasSalario();
        $oControllerServidor      = new ControllerSicasServidor();
        
        
        $oDependente = $oControllerDependente->getByPessoa($cd_pessoa);
        //Util::trace($oDependente);
        $oServidor = ($oDependente) ? $oDependente->oSicasServidor : $oControllerServidor->getByPessoa($cd_pessoa);
        //Util::trace($oServidor);
        if($oServidor){
            $oSalario = $oControllerSalario->getAtualByServidor($oServidor->cd_servidor);
            //Util::trace($oSalario);
        } else {
            $oServidor = $oControllerServidor->getByDependente($cd_pessoa);
            if($oServidor){
                $oSalario = $oControllerSalario->getAtualByServidor($oServidor->cd_servidor);
            }
        }
        
        if($oSalario){
            $salarioServidor = $oSalario->val_salario;
        } else{
            //print "salario não encontrado";
        }
        
        $salarioMinimoAtual = $oControllerSalarioMinimo->getSalarioMinimoAtual();
        $razao = $salarioServidor/$salarioMinimoAtual;
        
        //Util::trace($oSalario);
        if(!in_array($oSalario->oSicasServidor->oSicasPessoaCategoria->cd_categoria, [SicasPessoaCategoriaEnum::CARGO_EM_COMISSAO])){
            if($razao >= 2.0 && $razao < 7.0){
                $desconto = 5.0;
            } elseif ($razao >= 7.0 && $razao < 12.0){
                $desconto = 10.0;
            } elseif ($razao >= 12.0 && $razao < 15.0){
                $desconto = 15.0;
            } elseif($razao >= 15.0){
                $desconto = 20.0;
            }

            if(in_array($oDependente->oSicasGrauParentesco->cd_grau_parentesco, 
                [SicasGrauParentescoEnum::MADRASTA, 
                SicasGrauParentescoEnum::MAE,
                SicasGrauParentescoEnum::MAE_VIUVA,
                SicasGrauParentescoEnum::PAI,
                SicasGrauParentescoEnum::PAI_INVALIDO,
                SicasGrauParentescoEnum::PADRASTO,
                ])){
                    $desconto = 100.0;
            }
            
            if($flagInternacao){
                $desconto = 5.0;
            }
            
        } else {
            $desconto = 30.0;
        }
        
        return $desconto;
    }
    
    static function getValorProasServidor(SicasSalario $oSalario){
        $idade = Util::calculaIdade($oSalario->oSicasServidor->oSicasPessoa->dt_nascimento);
        
        if($oSalario->val_salario <= 1499.99){
            if($idade >=0 && $idade <= 38) return 30; 
            elseif($idade >=39 && $idade <= 58) return 40; 
            else return 50; 
        }
        elseif($oSalario->val_salario >=1500 && $oSalario->val_salario <= 1999.99){
            if($idade >=0 && $idade <= 38) return 35; 
            elseif($idade >=39 && $idade <= 58) return 45; 
            else return 55; 
        }
        elseif($oSalario->val_salario >=2000 && $oSalario->val_salario <= 2499.99){
            if($idade >=0 && $idade <= 38) return 40; 
            elseif($idade >=39 && $idade <= 58) return 50; 
            else return 60;
        }
        elseif($oSalario->val_salario >=2500 && $oSalario->val_salario <= 2999.99){
            if($idade >=0 && $idade <= 38) return 45;
            elseif($idade >=39 && $idade <= 58) return 55; 
            else return 65; 
        }
        elseif($oSalario->val_salario >=3000 && $oSalario->val_salario <= 3999.99){
            if($idade >=0 && $idade <= 38) return 50; 
            elseif($idade >=39 && $idade <= 58) return 60; 
            else return 70; 
        }
        elseif($oSalario->val_salario >=4000 && $oSalario->val_salario <= 5499.99){
            if($idade >=0 && $idade <= 38) return 55;
            elseif($idade >=39 && $idade <= 58) return 65; 
            else return 75;
        }
        elseif($oSalario->val_salario >=5500 && $oSalario->val_salario <= 7499.99){
            if($idade >=0 && $idade <= 38) return 65;
            elseif($idade >=39 && $idade <= 58) return 75;
            else return 85;
        }
        else{
            if($idade >=0 && $idade <= 38) return 75;
            elseif($idade >=39 && $idade <= 58) return 85;
            else return 100;
        }
    }
    
    static function getValorProasDependente(SicasDependente $oSicasDependente){
        $oControllerSalario = new ControllerSicasSalario();
        $idade = Util::calculaIdade($oSicasDependente->oSicasPessoa->dt_nascimento);
        $oSalario = $oControllerSalario->getAtualByPessoaDependente($oSicasDependente->oSicasPessoa->cd_pessoa);
        
        if($oSalario->val_salario <= 1499.99){
            if($idade >=0 && $idade <= 38) return 30;
            elseif($idade >=39 && $idade <= 58) return 40;
            else return 50;
        }
        elseif($oSalario->val_salario >=1500 && $oSalario->val_salario <= 1999.99){
            if($idade >=0 && $idade <= 38) return 35;
            elseif($idade >=39 && $idade <= 58) return 45;
            else return 55;
        }
        elseif($oSalario->val_salario >=2000 && $oSalario->val_salario <= 2499.99){
            if($idade >=0 && $idade <= 38) return 40;
            elseif($idade >=39 && $idade <= 58) return 50;
            else return 60;
        }
        elseif($oSalario->val_salario >=2500 && $oSalario->val_salario <= 2999.99){
            if($idade >=0 && $idade <= 38) return 45;
            elseif($idade >=39 && $idade <= 58) return 55;
            else return 65;
        }
        elseif($oSalario->val_salario >=3000 && $oSalario->val_salario <= 3999.99){
            if($idade >=0 && $idade <= 38) return 50;
            elseif($idade >=39 && $idade <= 58) return 60;
            else return 70;
        }
        elseif($oSalario->val_salario >=4000 && $oSalario->val_salario <= 5499.99){
            if($idade >=0 && $idade <= 38) return 55;
            elseif($idade >=39 && $idade <= 58) return 65;
            else return 75;
        }
        elseif($oSalario->val_salario >=5500 && $oSalario->val_salario <= 7499.99){
            if($idade >=0 && $idade <= 38) return 65;
            elseif($idade >=39 && $idade <= 58) return 75;
            else return 85;
        }
        else{
            if($idade >=0 && $idade <= 38) return 75;
            elseif($idade >=39 && $idade <= 58) return 85;
            else return 100;
        }
    }
}
