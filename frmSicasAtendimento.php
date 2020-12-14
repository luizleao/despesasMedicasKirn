<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasAtendimento();

$oSicasPessoa = (new ControllerSicasPessoa())->get($_REQUEST['cd_pessoa']);
$oSicasServidor = unserialize(serialize($_SESSION['usuarioAtual']['oSicasServidor']));
//Util::trace($oSicasServidor); exit;
$oSicasMedico = (new ControllerSicasMedico())->getByServidor(18); //Doris
//$oSicasMedico = (new ControllerSicasMedico())->getByServidor($oSicasServidor->cd_servidor);


if(!$oSicasMedico){
    //Util::trace($oSicasMedico); exit;
    print "<script>
                alert('Você não tem credenciais para efetuar atendimento médico');
                window.location = 'principal.php';
            </script>";
}
// ================= Cadastrar SicasAtendimento =========================
$post = json_decode(file_get_contents("php://input"), true);

if(isset($post)){
    //Util::trace($post);
    $cd_encaminhamento = $oController->transacaoSicasAtendimento($post);
    print (!$cd_encaminhamento) ? $oController->msg : $cd_encaminhamento; exit;
}
//Util::trace($_SESSION['usuarioAtual']);
//Util::trace($oSicasMedico);
//$aSicasCid = $oController->getAllSicasCid();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <?php require_once("includes/modals.php");?>
    <div id="app" class="container">
        <?php
		require_once("includes/titulo.php");
		require_once("includes/menu.php");
		?>
        <ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li><a href="frmBuscaBeneficiario.php">Atendimento</a></li>
			<li class="active">Cadastrar</li>
		</ol>
		
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label for="beneficiario">Beneficiário</label>
					<input id="beneficiario" class="form-control" value="<?=$oSicasPessoa->nm_pessoa?>" disabled />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="atendente">Atendente</label>
					<input id="atendente" class="form-control" value="<?=$_SESSION['usuarioAtual']['login']?>" disabled />
				</div> 
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="dt_ini_atendimento">Data de Atendimento:</label>
					<input type="date" class="form-control" name="dt_ini_atendimento" id="dt_ini_atendimento" v-model="oSicasAtendimento.oSicasConsultaMedica.dt_ini_atendimento" />
                </div>
			</div>
		</div>	

        <div class="panel panel-default">
            <div class="panel-heading">
            	<h3 class="panel-title">CID</h3>
            </div>
            <div class="panel-body">
                <div class="row">
        			<div class="col-md-10">
						<div class="input-group">
							<input type="text" id="textoConsultaCid" class="form-control input-sm" placeholder="Consultar CID" 
                                                							 v-model="textoConsultaCid" 
                                                							 @keydown="eventBuscaCid($event)" autofocus />
							
							<span class="input-group-btn">
        						<button id="btnConsultarCid" type="button" class="btn btn-primary btn-sm" data-loading-text="Carregando..." @click="buscarCid()"><i class="glyphicon glyphicon-search"></i></button>
        						<button type="button" class="btn btn-success btn-sm" @click="addSicasCid(oSicasCid)"><i class="glyphicon glyphicon-plus"></i></button><
        					</span>
						</div> 
						<select class="form-control input-sm" name="oSicasCid" id="oSicasCid" multiple="multiple" size="10" v-model="oSicasCid" 
                                                                                                    						v-show="aSicasCidTemp.length > 0" 
                                                                                                    						@dblclick="addSicasCid(oSicasCid)"
                                                                                                    						@keydown.enter="addSicasCid(oSicasCid)">
							<option :value="obj" v-for="obj in aSicasCidTemp">{{ obj.cd_cid }} - {{ obj.desc_cid }}</option>
						</select>
					</div>
				</div>
				<table class="table table-condensed table-striped" v-show="oSicasAtendimento.aSicasCid.length > 0">
					<thead>
						<tr>
							<th>CID</th>
							<th>Descrição</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(obj,i) in oSicasAtendimento.aSicasCid">
							<td>{{ obj.cd_cid }}</td>
							<td>{{ obj.desc_cid }}</td>
							<td><button type="button" class="btn btn-danger btn-sm" @click="delSicasCid(i)"><i class="glyphicon glyphicon-trash"></i></button></td>
						</tr>
					</tbody>
				</table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
            	<h3 class="panel-title">Encaminhamento</h3>
            </div>
            <div class="panel-body">
            	<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="oSicasCredenciado">Credenciado</label>
    						<select class="form-control" name="oSicasCredenciado" id="oSicasCredenciado" v-model="oSicasAtendimento.oSicasEncaminhamento.oSicasCredenciado">
    							<option value="" disabled="disabled">Selecione</option>
    							<option :value="obj" v-for="obj in aSicasCredenciadoTemp">{{ obj.nm_credenciado}}</option>
    						</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="tipo_guia">Tipo de Guia</label>
    						<select class="form-control" name="tipo_guia" id="tipo_guia" v-model="oSicasAtendimento.oSicasEncaminhamento.tipo_guia">
    							<option value="" disabled="disabled">Selecione</option>
    							<option v-for="oTipoGuia in aTipoGuia">{{ oTipoGuia }}</option>
    						</select>
    					</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="oSicasTipoDespesa">Tipo de Despesa</label>
    						<select class="form-control" name="oSicasTipoDespesa" id="oSicasTipoDespesa" v-model="oSicasAtendimento.oSicasEncaminhamento.oSicasTipoDespesa">
    							<option value="" disabled="disabled">Selecione</option>
    							<option :value="obj" v-for="obj in aSicasTipoDespesaTemp">{{ obj.nm_despesa}}</option>
    						</select>
    					</div>
					</div>
				</div>
            </div>
        </div>
		<div class="panel panel-default">
            <div class="panel-heading">
            	<h3 class="panel-title">Procedimentos</h3>
            </div>
            <div class="panel-body">
				<div class="row">
					<div class="col-md-2 col-xs-2">
						<input type="number" id="quantidade" name="quantidade" class="form-control input-sm" placeholder="Quantidade" v-model.number="quantidade" size="20" />
					</div>
        			<div class="col-md-10 col-xs-10">
						<div class="input-group">
							<input type="text" id="procedimento" name="procedimento" class="form-control input-sm" placeholder="Procedimento" 
                                                                                        							v-model="textoConsultaProcedimento" 
                                                                                        							@keydown="eventBuscaProcedimento($event)" />
							<span class="input-group-btn">
        						<button id="btnConsultarProcedimento" type="button" class="btn btn-primary btn-sm" data-loading-text="Carregando..." @click="buscarProcedimento()"><i class="glyphicon glyphicon-search"></i></button>
        						<button type="button" class="btn btn-success btn-sm" @click="addSicasProcedimento(oSicasProcedimento, quantidade)"><i class="glyphicon glyphicon-plus"></i></button>
        					</span>
						</div>
						<select class="form-control input-sm" name="oSicasProcedimento" id="oSicasProcedimento" multiple="multiple" size="10" v-model="oSicasProcedimento" 
                                                                                                                    						  v-show="aSicasProcedimentoTemp.length > 0" 
                                                                                                                    						  @dblclick="addSicasProcedimento(oSicasProcedimento, quantidade)"
                                                                                                                    						  @keydown.enter="addSicasProcedimento(oSicasProcedimento, quantidade)">
							<option v-bind:value="obj" v-for="obj in aSicasProcedimentoTemp">{{ obj.num_procedimento }}-{{ obj.nm_procedimento }}</option>
						</select>
					</div>
				</div>
				<table class="table table-condensed table-striped" v-show="oSicasAtendimento.aSicasProcedimentoAutorizado.length > 0">
					<thead>
						<tr>
							<th>Código</th>
							<th>Procedimento</th>
							<th>Quantidade</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(obj,i) in oSicasAtendimento.aSicasProcedimentoAutorizado">
							<td>{{ obj.num_procedimento }}</td>
							<td>{{ obj.nm_procedimento }}</td>
							<td>{{ obj.quantidade }}</td>
							<td><button type="button" class="btn btn-danger btn-sm" @click="delSicasProcedimento(i)"><i class="glyphicon glyphicon-trash"></i></button></td>
						</tr>
					</tbody>
				</table>
            </div>
        </div>
		<div class="panel panel-default">
            <div class="panel-heading">
            	<h3 class="panel-title">Observação</h3>
            </div>
            <div class="panel-body">
            	<textarea class="form-control" name="observacao" id="observacao" rows="10" cols="100" v-model="oSicasAtendimento.oSicasEncaminhamento.observacao"></textarea>
            </div>
        </div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<button id="btnCadAtendimento" data-loading-text="Carregando..." type="button" class="btn btn-primary" @click="cadSicasAtendimento()">Salvar</button>
					<a class="btn btn-default" href="frmBuscaBeneficiario.php">Voltar</a>
					<input type="hidden" name="classe" id="classe" value="SicasAtendimento" />
				</div>
			</div>
		</div>
	</div>
    <?php require_once("includes/footer.php")?>
    <script>
   // Vue.config.devtools = true;
	var app = new Vue({
		el: '#app',
		data: {
			oSicasAtendimento : {
				oSicasPessoa: {}, 
				oSicasMedico: {}, 
				oSicasConsultaMedica: {
					oSicasTipoAtendimento: {}
				}, 
				aSicasCid : [], 
				oSicasEncaminhamento: {
					oSicasCredenciado : {}, 
					tipo_guia: '', 
					oSicasTipoDespesa: {},
					observacao: ''
				}, 
				aSicasProcedimentoAutorizado : []
			},
			
            textoConsultaCid : '',
            textoConsultaProcedimento : '',

            oSicasCid: [],
			oSicasProcedimento: [],
			
			tipo_guia: '',
			quantidade: 1,

            aSicasCidTemp: [],
            aSicasCredenciadoTemp: [],
            aSicasProcedimentoTemp: [],
            aSicasTipoDespesaTemp: [],

            aTipoGuia: ['EXAME', 'CONSULTA', 'URGENCIA', 'INTERNACAO'],
            errors : []
        },
		created(){
    		this.getDate();
    		this.oSicasAtendimento.oSicasPessoa.cd_pessoa = <?=$_REQUEST['cd_pessoa']?>;
    		this.oSicasAtendimento.oSicasMedico.cd_medico = <?=$oSicasMedico->cd_medico?>;
    		this.oSicasAtendimento.oSicasConsultaMedica.oSicasTipoAtendimento.cd_tipo_atendimento = 1; //Cons. Ambulat.
    		
        	this.$http.get('rest/SicasCredenciado').then(res => {
    		    this.aSicasCredenciadoTemp = res.body;
			}, res => {
				console.log(res);
			    return false;
			});

        	this.$http.get('rest/SicasTipoDespesa').then(res => {
    		    this.aSicasTipoDespesaTemp = res.body;
    		    this.aSicasTipoDespesaTemp = this.aSicasTipoDespesaTemp.filter(obj => obj.credenciado == 1);
			}, res => {
				console.log(res);
			    return false;
			});
        },
		methods: {
			checkForm (){
				this.errors = [];
				
                if(this.oSicasAtendimento.aSicasCid.length == 0 || !this.oSicasAtendimento.aSicasCid){
                	this.errors.push('Escolha ao menos um CID');
                }
                
                if(Object.keys(this.oSicasAtendimento.oSicasEncaminhamento.oSicasCredenciado).length === 0) {
                	this.errors.push('Selecione um Credenciado');
                }

                if(!this.oSicasAtendimento.oSicasEncaminhamento.tipo_guia) {
                	this.errors.push('Selecione um Tipo de Guia');
                }

                if(Object.keys(this.oSicasAtendimento.oSicasEncaminhamento.oSicasTipoDespesa).length === 0) {
                	this.errors.push('Selecione um Tipo de Despesa');
                }

                if(this.oSicasAtendimento.aSicasProcedimentoAutorizado.length == 0 || !this.oSicasAtendimento.aSicasProcedimentoAutorizado) {
                	this.errors.push('Escolha ao menos um Procedimento');
                }

                if(this.errors.length > 0){
                    var img='<img src="img/ico_alert.png" />';

					var msg = img + '<strong>Corrigir os seguintes erros:</strong><ul>';
					for(i in this.errors)
						msg += '<li>'+this.errors[i]+'</li>'; 
                    msg += '</ul>';

                    //console.log(msg);
                    $('#modalResposta').find('.modal-body').addClass("alert alert-warning");
                	$('#modalResposta').find('.modal-body').html(msg);
                	$('#modalResposta').modal('show');
                	$('#modalResposta').on('shown.bs.modal', function (){
                        $('#modalResposta').find('#btnFechar').focus();
                    });
					return false;
                }

                this.errors = [];
                return true;
            },
			    
			getDate:function() {
                var today = new Date();
                var dd 	  = today.getDate();
                var mm 	  = today.getMonth()+1; //January is 0!
                var yyyy  = today.getFullYear();
                
                today = yyyy + '-' + ((mm<10) ? '0'+mm : mm) + '-' + ((dd<10) ? '0'+dd : dd);
                
                //console.log(today);
                this.oSicasAtendimento.oSicasConsultaMedica.dt_ini_atendimento = today;
		    },
			eventBuscaCid:function(event){
				//console.log(event.keyCode);
				if(event.keyCode == 40){ // Seta baixo
					//$('#oSicasCid').prop("selectedIndex",0).focus();
					$('#oSicasCid').focus();
				}
				if(event.keyCode == 13){ // enter
					this.buscarCid();
				}
			},
			eventBuscaProcedimento:function(event){
				//console.log(event.keyCode);
				if(event.keyCode == 40){ // Seta baixo
					//$('#oSicasProcedimento').prop("selectedIndex",0).focus();
					$('#oSicasProcedimento').focus();
				}
				if(event.keyCode == 13){ // enter
					this.buscarProcedimento();
				}
			},
			buscarCid:function() {
				$('#btnConsultarCid').button('loading');
				this.$http.get('rest/SicasCid/!/'+this.textoConsultaCid).then(res => {
					$('#btnConsultarCid').button('reset');
	    		    this.aSicasCidTemp = res.body;
				}, res => {
					$('#btnConsultarCid').button('reset');
					console.log(res);
				    return false;
				});
			},
			buscarProcedimento:function() {
				$('#btnConsultarProcedimento').button('loading');
				this.$http.get('rest/SicasProcedimento/!/'+this.textoConsultaProcedimento).then(res => {
					$('#btnConsultarProcedimento').button('reset');
	    		    this.aSicasProcedimentoTemp = res.body;
				}, res => {
					$('#btnConsultarProcedimento').button('reset');
					console.log(res);
				    return false;
				});
			},
			addSicasCid:function(obj) {
				this.oSicasAtendimento.aSicasCid.push(obj[0]);
				this.aSicasCidTemp = [];
				this.textoConsultaCid = '';
			},
			addSicasProcedimento:function(obj, quantidade) {
				obj[0].quantidade = (quantidade == '' || quantidade == 0) ? 1 : quantidade;
				this.oSicasAtendimento.aSicasProcedimentoAutorizado.push(obj[0]);
				this.aSicasProcedimentoTemp = [];
				this.textoConsultaProcedimento = '';
			},
			delSicasCid:function(index) {
				//this.aSicasCidTemp = this.aSicasCidTemp.filter(i => i.cd_cid !== obj.cd_cid);
				this.oSicasAtendimento.aSicasCid.splice(index, 1);
			},
			delSicasEncaminhamento:function() {
				this.oSicasAtendimento.oSicasEncaminhamento = {oSicasCredenciado : {}, tipo_guia: '', oSicasTipoDespesa: {}};
			}
			,
			delSicasProcedimento:function(index) {
				//this.aSicasProcedimentoTemp = this.aSicasProcedimentoTemp.filter(i => i.cd_procedimento !== obj.cd_procedimento);
				this.oSicasAtendimento.aSicasProcedimentoAutorizado.splice(index, 1);
			},
			checkForm (){
				this.errors = [];
				
                if(this.dtInicio){
                	this.errors.push('Escolha ao menos um CID');
                }
                
                if(Object.keys(this.oSicasAtendimento.oSicasEncaminhamento.oSicasCredenciado).length === 0) {
                	this.errors.push('Selecione um Credenciado');
                }

                if(!this.oSicasAtendimento.oSicasEncaminhamento.tipo_guia) {
                	this.errors.push('Selecione um Tipo de Guia');
                }

                if(Object.keys(this.oSicasAtendimento.oSicasEncaminhamento.oSicasTipoDespesa).length === 0) {
                	this.errors.push('Selecione um Tipo de Despesa');
                }

                if(this.oSicasAtendimento.aSicasProcedimentoAutorizado.length == 0 || !this.oSicasAtendimento.aSicasProcedimentoAutorizado) {
                	this.errors.push('Escolha ao menos um Procedimento');
                }

                if(this.errors.length > 0){
                    var img='<img src="img/ico_alert.png" />';

					var msg = img + '<strong>Corrigir os seguintes erros:</strong><ul>';
					for(i in this.errors)
						msg += '<li>'+this.errors[i]+'</li>'; 
                    msg += '</ul>';

                    //console.log(msg);
                    $('#modalResposta').find('.modal-body').addClass("alert alert-warning");
                	$('#modalResposta').find('.modal-body').html(msg);
                	$('#modalResposta').modal('show');
                	$('#modalResposta').on('shown.bs.modal', function (){
                        $('#modalResposta').find('#btnFechar').focus();
                    });
					return false;
                }

                this.errors = [];
                return true;
            },
			cadSicasAtendimento:function(){
				if(this.checkForm()){
    				$('#btnCadAtendimento').button('loading');
    				
    				this.$http.post('frmSicasAtendimento.php', this.oSicasAtendimento).then(res => {
    					console.log(res);
    					$('#btnCadAtendimento').button('reset');
    
    					var pattern = /^\d+$/;
    					var result = pattern.test(res.body);
    						
    					$('#modalResposta').find('.modal-body').html((result) ? '<img src="img/ico_success.png" /> Cadastrado com sucesso' : '<img src="img/ico_error.png" /> '+res.body);
                    	$('#modalResposta').modal('show');
    
                    	if(result){
                        	$('#modalResposta').on('hide.bs.modal', function () {
                        		window.open('frmEncaminhamento.php?cd_encaminhamento='+res.body, '_blank');
        	                    window.location = 'frmBuscaBeneficiario.php';
        	                });
                    	}
    	    		    return true;
    				}, res => {
    					$('#btnCadAtendimento').button('reset');
    					$('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> '+res.body);
                    	$('#modalResposta').modal('show');
    				    return false;
    				});
				}
			}
		},
	});
    </script>
</body>
</html>