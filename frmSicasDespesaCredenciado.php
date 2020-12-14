<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasDespesa();

$post = json_decode(file_get_contents("php://input"), true);

if(isset($post)){
    //Util::trace($post); exit;
	$cd_encaminhamento = $oController->transacaoSicasDespesa($post);
    print (!$cd_encaminhamento) ? $oController->msg : $cd_encaminhamento; exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <div id="app" class="container">
        <?php 
        require_once("includes/titulo.php"); 
        require_once("includes/menu.php"); 
        ?>
        <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li><a href="admSicasDespesa.php">Despesa Credenciado</a></li>
            <li class="active">Despesa Médica por Credenciado</li>
        </ol>
<?php 
if($oController->msg != "")
    $oController->componenteMsg($oController->msg, "erro");
?>
    	<div class="row">
    		<div class="col-md-4">
    			<div class="form-group">
    				<label>Data Início</label>
					<input type="date" v-model="dataInicio" class="form-control" placeholder="Data Início" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
    				<label>Data Fim</label>
					<input type="date" v-model="dataFim" class="form-control" placeholder="Data Fim" />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
    				<label>Credenciado</label>
    				<input type="text" id="nm_credenciado" name="nm_credenciado" class="form-control" autocomplete 	= "off"
                                                                                                	  v-model		= "nm_credenciado" 
                                                                                                	  @keydown		= "eventBuscaCredenciado($event)" />
                                                                                                                                	   
    				<select class="form-control input-sm" name="oSicasCredenciado" id			  = "oSicasCredenciado" 
    																			   multiple		  = "multiple" 
    																			   :size		  = "aSicasCredenciadoTemp.length" 
    																			   v-model		  = "oSicasCredenciado" 
                                                                        		   v-show		  = "aSicasCredenciadoTemp.length > 0" 
                                                            				  	   @dblclick      = "getAllProcedimentoPendenteCredenciado(oSicasCredenciado)" 
                                                            				  	   @keydown.enter = "getAllProcedimentoPendenteCredenciado(oSicasCredenciado)">
    					<option :value="obj" :key="obj.cd_credenciado" v-for="obj in aSicasCredenciadoTemp">{{ obj.nm_credenciado }}</option>
    				</select>
    			</div>
			</div>
		</div>
		<div class="row" v-if="aSicasProcedimentoAutorizado.length > 0">
    		<div class="col-md-4">
    			<div class="form-group">
    				<label>Valor da Fatura (R$)</label>
    				<input type="text" class="form-control" v-model="valorFatura" />
    			</div>
    		</div>
    		<div class="col-md-4">
    			<div class="form-group">
    				<label>Nº Fatura</label>
    				<input type="text" class="form-control" v-model="numeroFatura" />
    			</div>
    		</div>
    		<div class="col-md-4">
    			<div class="form-group">
    				<label>Mês/Ano Desconto em Folha</label>
    				<input type="month" class="form-control" v-model="mesAnoDescFolha" />
    			</div>
    		</div>
    	</div>
		<div style="overflow: auto; width: 99%; margin: 5px 5px 5px 5px; padding: 5px 5px 5px 5px" >
			<loading v-show="isLoading"></loading>  
    		<table class="table table-condensed table-striped" v-show="aSicasProcedimentoAutorizado.length > 0">
    			<thead>
    				<tr>
    					<th>
    						<button id="btnCadDespesa" data-loading-text="Carregando..." type="submit" class="btn btn-primary" @click="cadastrar">Salvar</button>
    					</th>
    				</tr>
    				<tr v-if="oSicasCredenciado[0].nm_credenciado != null">
    					<td colspan="9"><strong>Credenciado:</strong> {{ nm_credenciado }}</td>
    				</tr>
    				<tr>
    					<th><input type="checkbox" v-model="allSelected" /></th>
    					<th>Guia</th>
						<th>Paciente</th>
            			<th>Categoria</th>
            			<th>Procedimento</th>
            			<th>Data</th>
            			<th>Qtde</th>
            			<th>Servico (R$)</th>
            			<th>Desconto (%)</th>
            			<th>À Descontar (R$)</th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr v-for="(obj,i) in aSicasProcedimentoAutorizado" v-bind:key="obj.cd_procedimento_autorizado">
    					<td><input type="checkbox" :value="obj" v-model="aProcedimento" /></td>
    					<td>{{ obj.oSicasEncaminhamento.cd_encaminhamento | formatGuide }}</td>
    					<td>{{ obj.oSicasEncaminhamento.oSicasPessoa.nm_pessoa }}</td>
						<td>{{ obj.oSicasEncaminhamento.oSicasPessoa.oSicasPessoaCategoria.desc_categoria }}</td>
    					<td>{{ obj.oSicasProcedimento.nm_procedimento }}</td>
    					<td>{{ obj.oSicasEncaminhamento.dt_encaminhamento | formatDate }}</td>
    					<td><input type="text" class="form-control input-sm" v-model.number="obj.qtd_servico_autorizado" @keyup="updateProcedimento(obj)" size="4" /></td>
    					<td><input type="text" class="form-control input-sm" v-model.number="obj.oSicasProcedimento.num_custo_operacional" @keyup="updateProcedimento(obj)" size="8" /></td>
                		<td><input type="text" class="form-control input-sm" v-model.number="obj.percentualDesconto" size="4" @keyup="updateProcedimento(obj)" /></td>
                		<td>{{ (obj.qtd_servico_autorizado * obj.oSicasProcedimento.num_custo_operacional * obj.percentualDesconto/100).toFixed(2) }}</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
        <div class="row" v-if="aSicasProcedimentoAutorizado.length > 0">
            <div class="col-md-4">
                <button id="btnCadDespesa" data-loading-text="Carregando..." type="submit" class="btn btn-primary" @click="cadastrar">Salvar</button>
                <button id="btnReset" type="reset" class="btn btn-default">Restaurar</button>
                <input type="hidden" name="classe" id="classe" value="SicasDespesa" />
                <input type="hidden" name="status" id="status" value="1" />
                <input type="hidden" name="dt_cadastro" id="dt_cadastro" value="<?=date('Y-m-d')?>" />
            </div>
        </div>
    </div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
<script>
Vue.config.devtools = true;

var app = new Vue({
	el: '#app',
	data: {
	    allSelected: false,
		aProcedimento: [],
		
		dataInicio: '',
		dataFim: '',
		mesAnoDescFolha: '',
		oSicasCredenciado : [{nm_credenciado: ''}],
		nm_credenciado : '',
		isLoading: false,
		aSicasProcedimentoAutorizado : [],
		aSicasCredenciadoTemp : [],
		
		valorFatura: 0.00,
		numeroFatura: '',
		errors: [],
		
	    dados: {}
	
    },
    
    watch :{ // Comportamento disparado quando uma variável que está no escopo é alterada
    	allSelected: function(check){
			//this.allSelected = (this.allSelected) ? true : false;
			this.aProcedimento = [];
            if (check) {
                for (oProcedimento in this.aSicasProcedimentoAutorizado) {
                    this.aProcedimento.push(this.aSicasProcedimentoAutorizado[oProcedimento]);
                }
            }
        },
    	nm_credenciado: function () {
    		this.aSicasCredenciadoTemp = [];
			this.debouncedgetAllCredenciado();
        },
        aProcedimento : function (list){
        	//console.log(list.length);
        	this.recalcFatura(list);
		},
	    deep: true
   	},
    created: function () {
        this.debouncedgetAllCredenciado = _.debounce(this.getAllCredenciado, 1500);
        this.setDate();
    },
	methods: {
		recalcFatura(list){
        	this.valorFatura = 0.0;
        	for(var i=0; i<list.length; i++){
				this.valorFatura += parseFloat(list[i].oSicasProcedimento.num_custo_operacional) * list[i].qtd_servico_autorizado;
            }
		},
		selectAll: function() {
            this.aProcedimento = [];
            if (this.allSelected) {
                for (oProcedimento in this.aSicasProcedimentoAutorizado) {
                    this.aProcedimento.push(this.aSicasProcedimentoAutorizado[oProcedimento]);
                }
            }
        },
        updateProcedimento(obj){
            var flagAchou = false;
        	this.aProcedimento.filter(function (element){
            	if(element.cd_procedimento_autorizado == obj.cd_procedimento_autorizado){
            		flagAchou = true;
                } 	
            });
            if(!flagAchou)
            	this.aProcedimento.push(obj);
            this.recalcFatura(this.aProcedimento);
        }, 
		setDate() {
            var today = new Date();
            var dd 	  = today.getDate();
            var mm 	  = today.getMonth()+1; //January is 0!
            var yyyy  = today.getFullYear();
            
            today = yyyy + '-' + ((mm<10) ? '0'+mm : mm) + '-' + ((dd<10) ? '0'+dd : dd);
            firstDay = yyyy + '-' + ((mm<10) ? '0'+mm : mm) + '-' + '01';
            
            //console.log(today);
            this.dataInicio = firstDay;
            this.dataFim = today; 
	    },
	    
		getAllCredenciado: function(){
			this.isLoading = true;
			this.aSicasCredenciadoTemp = [];
			if(this.nm_credenciado !== ''){
				this.$http.get('retornoJson.php?acao=consultarCredenciadoAtivo&busca='+this.nm_credenciado).then(res => {
		        	this.valorFatura = 0;
					this.isLoading=false;
					//console.log(res.body);
	    		    this.aSicasCredenciadoTemp = (res.body != 'false') ? res.body : [];
				}, res => {
					this.isLoading=false;
					console.log(res);
				    return false;
				});
			} else {
				this.isLoading=false;
				this.aSicasCredenciadoTemp = [];
			}
		},
		getAllProcedimentoPendenteCredenciado: function(obj){
			this.isLoading = true;
		    this.nm_credenciado = this.oSicasCredenciado[0].nm_credenciado;
			this.aSicasProcedimentoAutorizado = [];
			this.aSicasCredenciadoTemp = [];
			if(this.dataInicio != ''&& this.dataFim != '') {
    			this.$http.get('retornoJson.php?acao=getAllProcedimentoPendenteCredenciado&cd_credenciado='+obj[0].cd_credenciado+'&dataInicio='+this.dataInicio+'&dataFim='+this.dataFim).then(res => {
    				this.isLoading = false;
    				//console.log(res.body);
    				if(res.body == 'false'){
        		    	this.aSicasProcedimentoAutorizado = [];
    		    		this.mensagem("Nenhum procedimento encontrado para esse período", 'alert');
    				} else {
    					this.aSicasProcedimentoAutorizado = res.body;
        			}
    			}, res => {
    				this.isLoading=false;
    				console.log(res);
    			    return false;
    			});
			} else {
				this.isLoading=false;
				$('#modalResposta').find('.modal-body').addClass("alert alert-warning");
            	$('#modalResposta').find('.modal-body').html('<img src="img/ico_alert.png" /> Preencha o intervao de tempo corretamente');
            	$('#modalResposta').modal('show');
            	$('#modalResposta').on('shown.bs.modal', function (){
                    $('#modalResposta').find('#btnFechar').focus();
                });
			}
		},
		eventBuscaCredenciado:function(event){
			//console.log(event.keyCode);
			if(event.keyCode == 40){ // Seta baixo
				$('#oSicasCredenciado').focus();
				//$('#oSicasCredenciado').prop("selectedIndex",0).focus();
				//$('#oSicasCredenciado option:first').prop('selected', true);
			}
// 			if(event.keyCode == 13){ // enter
// 				this.buscarPessoa();
// 			}
		},
		checkForm (){
			this.errors = [];
			
            if(this.numeroFatura === ''){
            	this.errors.push('Informe o Número da Fatura');
            }

            if(this.valorFatura <= 0){
            	this.errors.push('Valor da Fatura vazio');
            }

            if(this.mesAnoDescFolha === ''){
            	this.errors.push('Selecione Mês/Ano para desconto em folha');
            }
            
            if(Object.keys(this.aProcedimento).length === 0) {
            	this.errors.push('Selecione ao menos um Procedimento Autorizado');
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
		cadastrar(){
			if(this.checkForm()){
				$('#btnCadDespesa').button('loading');
				
				this.dados = {oSicasCredenciado : this.oSicasCredenciado, 
							  aProcedimento: this.aProcedimento,
							  valorFatura: this.valorFatura,
							  numeroFatura: this.numeroFatura,
							  mesAnoDescFolha: this.mesAnoDescFolha};

				this.$http.post('frmSicasDespesaCredenciado.php', this.dados).then(res => {
					//console.log(res);
					$('#btnCadDespesa').button('reset');
					this.allSelected = false;
					
					var pattern = /^\d+$/;
					var result = pattern.test(res.body);

					if(result){
						msg = '<img src="img/ico_success.png" /> Cadastrado com sucesso';
						$('#modalResposta').find('.modal-body').html(msg);
	                	$('#modalResposta').modal('show');
						this.aProcedimento = [];
						this.getAllProcedimentoPendenteCredenciado(this.oSicasCredenciado);
					} else {
						msg = '<img src="img/ico_error.png" /> '+res.body;
						$('#modalResposta').find('.modal-body').html(msg);
	                	$('#modalResposta').modal('show');
					}

                	if(result){
                    	$('#modalResposta').on('hide.bs.modal', function () {
                    		//window.open('frmEncaminhamento.php?cd_encaminhamento='+res.body, '_blank');
    	                    //window.location = 'frmBuscaBeneficiario.php';
    	                });
                	}
	    		    return true;
				}, res => {
					$('#btnCadDespesa').button('reset');
					$('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> <pre>'+res.body+'</pre>');
                	$('#modalResposta').modal('show');
				    return false;
				});
			}
		},
		mensagem(msg, tipo){
    		$('#modalResposta').find('.modal-body').html('<img src="img/ico_'+tipo+'.png" /> '+msg);
        	$('#modalResposta').modal('show');
		}
	},
	filters: {
	  capitalize: function (value) {
	    if (!value) 
		    return ''
	    value = value.toString()
	    return value.charAt(0).toUpperCase() + value.slice(1)
	  },
	  formatDate: function (value) {
	    if (!value) 
		    return '';
	    value = value.toString().split(" ")[0].split("-");
	    return value[2]+'/'+value[1]+'/'+value[0];
		//console.log(value);
	  },
	  formatMoney: function (value) {
		//console.log(value);
		//console.log(parseInt(value));
	    if (isNaN(parseInt(value))){ 
		    return '0.00';
	    }
	    value = value.toString().split(".");
	    return value[0]+'.'+((parseInt(value[1]) == 0) ? '00' : value[1].substr(0,2));
		//console.log(value);
	  },
	  formatGuide: function (value) {
		  //0000677395-003/122019.008
		  //0000677395003122019008
		    return value.substr(0,10)+'-'+value.substr(10,3)+'/'+value.substr(13,6)+'.'+value.substr(19,3);
	  }
	}
});
</script>
</body>
</html>