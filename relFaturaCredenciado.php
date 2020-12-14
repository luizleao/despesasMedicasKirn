<?php
require_once("classes/autoload.php");

$oController = new ControllerSicasDespesa();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<?php require_once("includes/header.php");?>
</head>
<body>
	<div class="container" id="app">
		<?php require_once("includes/titulo.php");?>
		<?php require_once("includes/menu.php");?>
		<ol class="breadcrumb">
			<li><a href="home.php">Home</a></li>
			<li class="active">Relatório de Faturas por Credenciado</li>
		</ol>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
    				<label>Credenciado</label>
    				<input type="text" id="nm_credenciado" name="nm_credenciado" class="form-control" autofocus		= "autofocus" 
    																								  autocomplete 	= "off"
                                                                                                	  v-model		= "nm_credenciado" 
                                                                                                	  @keydown		= "eventBuscaCredenciado($event)" />
                                                                                                                                	   
    				<select class="form-control input-sm" name="oSicasCredenciado" id			  = "oSicasCredenciado" 
    																			   multiple		  = "multiple" 
    																			   :size		  = "aSicasCredenciadoTemp.length" 
    																			   v-model		  = "oSicasCredenciado" 
                                                                        		   v-show		  = "aSicasCredenciadoTemp.length > 0" 
                                                            				  	   @dblclick      = "getAllFaturaCredenciado(oSicasCredenciado)" 
                                                            				  	   @keydown.enter = "getAllFaturaCredenciado(oSicasCredenciado)">
    					<option :value="obj" :key="obj.cd_credenciado" v-for="obj in aSicasCredenciadoTemp">{{ obj.nm_credenciado }}</option>
    				</select>
    			</div>
			</div>
		</div>

<?php 
if($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
		<loading v-show="isLoading"></loading>
		<table class="table table-condensed table-striped" v-show="aSicasFatura.length > 0">
			<thead>
				<tr>
					<th>Credenciado</th>
					<th>Fatura</th>
					<th>Mês/Ano Lançamento</th>
					<th>Valor (R$)</th>
					<th>Detalhado</th>
					<th>Resumo</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(obj,i) in aSicasFatura" v-bind:key="obj.cd_procedimento_autorizado">
					<td>{{obj.oSicasCredenciado.nm_credenciado}}</td>
					<td>{{obj.num_fatura}}</td>
					<td>{{obj.mes_ano_lancamento | formatMesAno}}</td>
					<td>{{obj.vl_fatura | formatMoney}}</td>
					<td><a :href="urlRelatorio(obj.cd_fatura)" target="_blank" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-search"></i></a></td>
					<td><a :href="urlRelatorioResumo(obj.cd_fatura)" target="_blank" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-list"></i></a></td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="classe" id="classe" value="SicasDespesa" />
	</div>
	<?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
<script>
Vue.config.devtools = true;

var app = new Vue({
	el: '#app',
	data: {
		aSicasFatura: [],
		oSicasCredenciado : [{nm_credenciado: ''}],
		nm_credenciado : '',
		isLoading: false,
		aSicasCredenciadoTemp : [],
	    dados: {}
    },
    
    watch :{ // Comportamento disparado quando uma variável que está no escopo é alterada
    	nm_credenciado: function () {
    		this.aSicasCredenciadoTemp = [];
			this.debouncedgetAllCredenciado();
        },
       
	    deep: true
   	},
    created: function () {
        this.debouncedgetAllCredenciado = _.debounce(this.getAllCredenciado, 1500);
    },
	methods: {
		urlRelatorio: function(cd_fatura){
			return 'resRelFaturaCredenciado.php?cd_fatura='+cd_fatura; 
		},
		urlRelatorioResumo: function(cd_fatura){
			return 'resRelFaturaCredenciadoResumo.php?cd_fatura='+cd_fatura; 
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
		getAllFaturaCredenciado: function(obj){
			//this.nm_credenciado = obj[0].nm_credenciado;
			this.isLoading = true;
			this.aSicasFatura = [];
			this.aSicasCredenciadoTemp = [];
			if(obj[0].cd_credenciado) {
    			this.$http.get('retornoJson.php?acao=getAllFaturaCredenciado&cd_credenciado='+obj[0].cd_credenciado).then(res => {
    				this.isLoading = false;
    				//console.log(res.body);
    				if(res.body == 'false'){
        		    	this.aSicasFatura = [];
    		    		this.mensagem("Selecione um credenciado", 'alert');
    				} else {
    					this.aSicasFatura = res.body;
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
	  formatMesAno: function (value) {
	    if (!value) 
		    return '';
	    value = value.toString().split(" ")[0].split("-");
	    return value[1]+'/'+value[0];
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
	  }
	}
});
</script>
</body>
</html>