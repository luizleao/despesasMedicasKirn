<?php
class SicasServidorMAP{
    static function getMetaData($alias='sicas_servidor'){
        return array_merge([$alias => ['cd_servidor', 'cd_pessoa', 'cd_matricula', 
                                       'cd_lotacao', 'status', 'serv_efetivo', 'cd_cargo',
                                       'ramal1', 'ramal2', 'ramal3', 'cd_categoria', 
                                       'foto', 'descricao_perfil', 'usuario_proas', 'vl_saldo_odonto']],
                            SicasPessoaMAP::getMetaData(),
                            SicasLotacaoMAP::getMetaData(),
                            RhCargoMAP::getMetaData(),
                            SicasPessoaCategoriaMAP::getMetaData('categoria_servidor'));
    }
   
    static function dataToSelect(){
        foreach(self::getMetaData() as $tabela => $aCampo){
            foreach($aCampo as $sCampo){
                $aux[] = "$tabela.$sCampo as $tabela"."_$sCampo";
            }
        }
        
        return implode(",\n", $aux);
    }
    
    static function filterLike($valor){
        foreach(self::getMetaData() as $tabela => $aCampo){
            foreach($aCampo as $sCampo){
                $aux[] = "$tabela.$sCampo like '$valor'";
            }
        }
        
        return implode("\nor ", $aux);
    }
    
    static function objToRs($oSicasServidor){
        $reg['cd_servidor']      = $oSicasServidor->cd_servidor;
        $reg['cd_pessoa']        = $oSicasServidor->oSicasPessoa->cd_pessoa;
        $reg['cd_matricula']     = $oSicasServidor->cd_matricula;
        $reg['cd_lotacao']       = $oSicasServidor->oSicasLotacao->cd_lotacao;
        $reg['status']           = $oSicasServidor->status;
        $reg['serv_efetivo']     = $oSicasServidor->serv_efetivo;
        $reg['cd_cargo']         = $oSicasServidor->oRhCargo->cd_cargo;
        $reg['ramal1']           = $oSicasServidor->ramal1;
        $reg['ramal2']           = $oSicasServidor->ramal2;
        $reg['ramal3']           = $oSicasServidor->ramal3;
        $reg['cd_categoria']     = $oSicasServidor->oSicasPessoaCategoria->cd_categoria;
        $reg['foto']             = $oSicasServidor->foto;
        $reg['descricao_perfil'] = $oSicasServidor->descricao_perfil;
        $reg['usuario_proas']    = $oSicasServidor->usuario_proas;
        $reg['vl_saldo_odonto']  = $oSicasServidor->vl_saldo_odonto;
        
        return $reg;
    }
    
    static function objToRsInsert($oSicasServidor){
        $reg['cd_pessoa']        = $oSicasServidor->oSicasPessoa->cd_pessoa;
        $reg['cd_matricula']     = $oSicasServidor->cd_matricula;
        $reg['cd_lotacao']       = $oSicasServidor->oSicasLotacao->cd_lotacao;
        $reg['status']           = $oSicasServidor->status;
        $reg['serv_efetivo']     = $oSicasServidor->serv_efetivo;
        $reg['cd_cargo']         = $oSicasServidor->oRhCargo->cd_cargo;
        $reg['ramal1']           = $oSicasServidor->ramal1;
        $reg['ramal2']           = $oSicasServidor->ramal2;
        $reg['ramal3']           = $oSicasServidor->ramal3;
        $reg['cd_categoria']     = $oSicasServidor->oSicasPessoaCategoria->cd_categoria;
        $reg['foto']             = $oSicasServidor->foto;
        $reg['descricao_perfil'] = $oSicasServidor->descricao_perfil;
        $reg['usuario_proas']    = $oSicasServidor->usuario_proas;
        $reg['vl_saldo_odonto']  = $oSicasServidor->vl_saldo_odonto;
        
        return $reg;
    }
    
    static function rsToObj($reg){
        foreach($reg as $campo => $valor){
            $reg[$campo] = $valor;
        }
        $oSicasServidor = new SicasServidor();
        $oSicasServidor->cd_servidor 	  = $reg['sicas_servidor_cd_servidor'];
        $oSicasServidor->cd_matricula 	  = $reg['sicas_servidor_cd_matricula'];
        $oSicasServidor->status 		  = $reg['sicas_servidor_status'];
        $oSicasServidor->serv_efetivo 	  = $reg['sicas_servidor_serv_efetivo'];
        $oSicasServidor->ramal1 		  = $reg['sicas_servidor_ramal1'];
        $oSicasServidor->ramal2 		  = $reg['sicas_servidor_ramal2'];
        $oSicasServidor->ramal3 		  = $reg['sicas_servidor_ramal3'];
        $oSicasServidor->foto 			  = $reg['sicas_servidor_foto'];
        $oSicasServidor->descricao_perfil = $reg['sicas_servidor_descricao_perfil'];
        $oSicasServidor->usuario_proas	  = $reg['sicas_servidor_usuario_proas'];
        $oSicasServidor->vl_saldo_odonto  = $reg['sicas_servidor_vl_saldo_odonto'];
        
        $oSicasPessoa = new SicasPessoa();
        $oSicasPessoa->cd_pessoa          = $reg['sicas_pessoa_cd_pessoa'];
        $oSicasPessoa->nm_pessoa          = $reg['sicas_pessoa_nm_pessoa'];
        $oSicasPessoa->email              = $reg['sicas_pessoa_email'];
        $oSicasPessoa->dt_nascimento      = $reg['sicas_pessoa_dt_nascimento'];
        $oSicasPessoa->genero             = $reg['sicas_pessoa_genero'];
        $oSicasPessoa->identidade         = $reg['sicas_pessoa_identidade'];
        $oSicasPessoa->nm_orgao_emissor   = $reg['sicas_pessoa_nm_orgao_emissor'];
        $oSicasPessoa->dt_emissao         = $reg['sicas_pessoa_dt_emissao'];
        $oSicasPessoa->cpf                = $reg['sicas_pessoa_cpf'];
        $oSicasPessoa->endereco           = $reg['sicas_pessoa_endereco'];
        $oSicasPessoa->complemento        = $reg['sicas_pessoa_complemento'];
        $oSicasPessoa->bairro             = $reg['sicas_pessoa_bairro'];
        $oSicasPessoa->cidade             = $reg['sicas_pessoa_cidade'];
        $oSicasPessoa->uf                 = $reg['sicas_pessoa_uf'];
        $oSicasPessoa->cep                = $reg['sicas_pessoa_cep'];
        $oSicasPessoa->telefone           = $reg['sicas_pessoa_telefone'];
        $oSicasPessoa->grupo_sanguineo    = $reg['sicas_pessoa_grupo_sanguineo'];
        $oSicasPessoa->tipo_beneficiario  = $reg['sicas_pessoa_tipo_beneficiario'];
        $oSicasPessoa->status             = $reg['sicas_pessoa_status'];
        $oSicasPessoa->foto               = $reg['sicas_pessoa_foto'];
        $oSicasPessoa->uf_identidade = $reg['sicas_pessoa_uf_identidade'];
        
        $oSicasEstadoCivil = new SicasEstadoCivil();
        $oSicasEstadoCivil->cd_estado_civil = $reg['sicas_estado_civil_cd_estado_civil'];
        $oSicasEstadoCivil->nm_estado_civil = $reg['sicas_estado_civil_nm_estado_civil'];
        $oSicasEstadoCivil->status          = $reg['sicas_estado_civil_status'];
        $oSicasPessoa->oSicasEstadoCivil = $oSicasEstadoCivil;
        
        $oSicasPessoaCategoria = new SicasPessoaCategoria();
        $oSicasPessoaCategoria->cd_categoria         = $reg['sicas_pessoa_categoria_cd_categoria'];
        $oSicasPessoaCategoria->desc_categoria       = $reg['sicas_pessoa_categoria_desc_categoria'];
        $oSicasPessoaCategoria->desc_categoria_abrev = $reg['sicas_pessoa_categoria_desc_categoria_abrev'];
        
        $oSicasPessoa->oSicasPessoaCategoria = $oSicasPessoaCategoria;
        
        $oSicasServidor->oSicasPessoa = $oSicasPessoa;
        
        $oSicasLotacao = new SicasLotacao();
        $oSicasLotacao->cd_lotacao     = $reg['sicas_lotacao_cd_lotacao'];
        $oSicasLotacao->sigla          = $reg['sicas_lotacao_sigla'];
        $oSicasLotacao->cd_siged       = $reg['sicas_lotacao_cd_siged'];
        $oSicasLotacao->nm_lotacao     = $reg['sicas_lotacao_nm_lotacao'];
        $oSicasLotacao->status         = $reg['sicas_lotacao_status'];
        $oSicasServidor->oSicasLotacao = $oSicasLotacao;
        
        $oRhCargo = new RhCargo();
        $oRhCargo->cd_cargo              = $reg['rh_cargo_cd_cargo'];
        $oRhCargo->descricao_cargo       = $reg['rh_cargo_descricao_cargo'];
        $oRhCargo->descricao_cargo_abrev = $reg['rh_cargo_descricao_cargo_abrev'];
        $oRhCargo->num_siape_cargo       = $reg['rh_cargo_num_siape_cargo'];
        $oRhCargo->status                = $reg['rh_cargo_status'];
        $oSicasServidor->oRhCargo = $oRhCargo;
        
        $oCategoriaServidor = new SicasPessoaCategoria();
        $oCategoriaServidor->cd_categoria         = $reg['categoria_servidor_cd_categoria'];
        $oCategoriaServidor->desc_categoria       = $reg['categoria_servidor_desc_categoria'];
        $oCategoriaServidor->desc_categoria_abrev = $reg['categoria_servidor_desc_categoria_abrev'];
        
        $oSicasServidor->oSicasPessoaCategoria = $oCategoriaServidor;

        return $oSicasServidor;
    }
    
    static function wsToObj($obj){
        $oSicasServidor = new SicasServidor();
        $oSicasServidor->cd_servidor       = $obj->cd_servidor;
        $oSicasServidor->cd_matricula      = $obj->cd_matricula;
        $oSicasServidor->status            = $obj->status;
        $oSicasServidor->serv_efetivo      = $obj->serv_efetivo;
        $oSicasServidor->ramal1 		   = $obj->ramal1;
        $oSicasServidor->ramal2 		   = $obj->ramal2;
        $oSicasServidor->ramal3 		   = $obj->ramal3;
        $oSicasServidor->foto 			   = $obj->foto;
        $oSicasServidor->descricao_perfil  = $obj->descricao_perfil;
        $oSicasServidor->usuario_proas	   = $obj->usuario_proas;
        $oSicasServidor->vl_saldo_odonto   = $obj->vl_saldo_odonto;

        $oSicasPessoa 				 = new SicasPessoa();
        $oSicasPessoa->cd_pessoa 	 = $obj->oSicasPessoa->cd_pessoa;
        $oSicasPessoa->nm_pessoa 	 = $obj->oSicasPessoa->nm_pessoa;
        $oSicasPessoa->email 		 = $obj->oSicasPessoa->email;
        $oSicasPessoa->dt_nascimento = $obj->oSicasPessoa->dt_nascimento;
        $oSicasPessoa->genero 		 = $obj->oSicasPessoa->genero;
        
        $oSicasEstadoCivil 					= new SicasEstadoCivil();
        $oSicasEstadoCivil->cd_estado_civil = $obj->oSicasEstadoCivil->cd_estado_civil;
        $oSicasEstadoCivil->nm_estado_civil = $obj->oSicasEstadoCivil->nm_estado_civil;
        $oSicasEstadoCivil->status 			= $obj->oSicasEstadoCivil->status;
        $oSicasPessoa->oSicasEstadoCivil 	= $oSicasEstadoCivil;
        $oSicasPessoa->identidade 			= $obj->oSicasPessoa->identidade;
        $oSicasPessoa->nm_orgao_emissor 	= $obj->oSicasPessoa->nm_orgao_emissor;
        $oSicasPessoa->dt_emissao 			= $obj->oSicasPessoa->dt_emissao;
        $oSicasPessoa->cpf 					= $obj->oSicasPessoa->cpf;
        $oSicasPessoa->endereco 			= $obj->oSicasPessoa->endereco;
        $oSicasPessoa->complemento 			= $obj->oSicasPessoa->complemento;
        $oSicasPessoa->bairro 				= $obj->oSicasPessoa->bairro;
        $oSicasPessoa->cidade 				= $obj->oSicasPessoa->cidade;
        $oSicasPessoa->uf 					= $obj->oSicasPessoa->uf;
        $oSicasPessoa->cep 					= $obj->oSicasPessoa->cep;
        $oSicasPessoa->telefone 			= $obj->oSicasPessoa->telefone;
        $oSicasPessoa->grupo_sanguineo 	 	= $obj->oSicasPessoa->grupo_sanguineo;
        $oSicasPessoa->tipo_beneficiario 	= $obj->oSicasPessoa->tipo_beneficiario;
        $oSicasPessoa->status 			 	= $obj->oSicasPessoa->status;
        $oSicasPessoa->foto 			 	= $obj->oSicasPessoa->foto;
        
        $oSicasPessoaCategoria = new SicasPessoaCategoria();
        $oSicasPessoaCategoria->cd_categoria 		 = $obj->oSicasPessoa->categoria_cd_categoria;
        $oSicasPessoaCategoria->desc_categoria 		 = $obj->oSicasPessoa->categoria_desc_categoria;
        $oSicasPessoaCategoria->desc_categoria_abrev = $obj->oSicasPessoa->categoria_desc_categoria_abrev;
        $oSicasPessoa->oSicasPessoaCategoria 		 = $oSicasPessoaCategoria;
        $oSicasPessoa->uf_identidade 				 = $obj->oSicasPessoa->uf_identidade;
        
        $oSicasServidor->oSicasPessoa = $oSicasPessoa;
        
        $oSicasLotacao = new SicasLotacao();
        $oSicasLotacao->cd_lotacao 	= $obj->oSicasLotacao->cd_lotacao;
        $oSicasLotacao->sigla 		= $obj->oSicasLotacao->sigla;
        $oSicasLotacao->cd_siged 	= $obj->oSicasLotacao->cd_siged;
        $oSicasLotacao->nm_lotacao 	= $obj->oSicasLotacao->nm_lotacao;
        $oSicasLotacao->status 		= $obj->oSicasLotacao->status;
        
        $oSicasServidor->oSicasLotacao = $oSicasLotacao;
        
        $oRhCargo = new RhCargo();
        $oRhCargo->cd_cargo 			 = $obj->oRhCargo->cd_cargo;
        $oRhCargo->descricao_cargo 		 = $obj->oRhCargo->descricao_cargo;
        $oRhCargo->descricao_cargo_abrev = $obj->oRhCargo->descricao_cargo_abrev;
        $oRhCargo->num_siape_cargo 		 = $obj->oRhCargo->num_siape_cargo;
        $oRhCargo->status 				 = $obj->oRhCargo->status;
        
        $oSicasServidor->oRhCargo = $oRhCargo;
        
        $oCategoriaServidor = new SicasPessoaCategoria();
        $oCategoriaServidor->cd_categoria         = $obj->oSicasPessoaCategoria->cd_categoria;
        $oCategoriaServidor->desc_categoria       = $obj->oSicasPessoaCategoria->desc_categoria;
        $oCategoriaServidor->desc_categoria_abrev = $obj->oSicasPessoaCategoria->desc_categoria_abrev;
        
        $oSicasServidor->oSicasPessoaCategoria = $oCategoriaServidor;
        
        return $oSicasServidor;
    }
}
