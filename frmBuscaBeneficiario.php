<?php
require_once("classes/autoload.php");
$oController = new Controller();
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
        <ul class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li><a href="admSicasServidor.php">Servidor</a></li>
			<li class="active">Busca Beneficiário</li>
		</ul>
<?php
if ($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
		<div class="row">
			<div class="col-md-6">
				<div class="input-group">
					<input autofocus type="text" id="nm_pessoa" name="nm_pessoa" class="form-control" autocomplete="off" placeholder="Nome do Beneficiário"  
                                                                                                    					 v-model="nm_pessoa" 
                                                                                                    					 @keydown="eventBuscaPessoa($event)"  />
					<span class="input-group-btn">
    					<button id="btnAtendimento" type="button" class="btn btn-success" data-loading-text="Carregando..." @click="goSicasAtendimento(oSicasPessoa)"><i class="glyphicon glyphicon-log-in"></i></button> 
    				</span>
				</div>
				<loading v-show="isLoading"></loading>
				<select class="form-control input-sm" name="oSicasPessoa" id="oSicasPessoa" multiple="multiple" :size="aSicasPessoaTemp.length" 
																												v-model="oSicasPessoa" 
                                                                                                        		v-show="aSicasPessoaTemp.length > 0" 
                                                                                            				  	@dblclick="goSicasAtendimento(oSicasPessoa)" 
                                                                                            				  	@keydown.enter="goSicasAtendimento(oSicasPessoa)">
					<option :value="obj" v-for="obj in aSicasPessoaTemp">{{ obj.nm_pessoa }}</option>
				</select>
			</div>
		</div>
	</div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
    <script>

   // Vue.config.devtools = true;
    
	var app = new Vue({
		el: '#app',
		data: {
			oSicasPessoa : [],
			nm_pessoa : '',
			isLoading: false,
			aSicasPessoaTemp : []
        },
        watch :{ // Comportamento disparado quando uma variável que está no escopo é alterada
        	nm_pessoa: function () {
        		this.aSicasPessoaTemp = [];
				this.debouncedgetAllBeneficiario();
	        }
       	},
        created: function () {
            this.debouncedgetAllBeneficiario = _.debounce(this.getAllBeneficiario, 500);
        },
		methods: {
			getAllBeneficiario: function(){
				this.isLoading = true;
				if(this.nm_pessoa !== ''){
    				this.$http.get('retornoJson.php?acao=consultarBeneficiario&busca='+this.nm_pessoa).then(res => {
    					this.isLoading=false;
    					//console.log(res.body);
    					if(res.body != 'false'){
    	    		    	this.aSicasPessoaTemp = res.body;
    					} else {
    						this.aSicasPessoaTemp = [];
    					}
    				}, res => {
    					this.isLoading=false;
    					console.log(res);
    				    return false;
    				});
				} else {
					this.isLoading=false;
					this.aSicasPessoaTemp = [];
				}
			},
			eventBuscaPessoa:function(event){
				//console.log(event.keyCode);
				if(event.keyCode == 40){ // Seta baixo
					$('#oSicasPessoa').focus();
					//$('#oSicasPessoa').prop("selectedIndex",0).focus();
					//$('#oSicasPessoa option:first').prop('selected', true);
				}
				if(event.keyCode == 13){ // enter
					//this.buscarPessoa();
				}
			},
			goSicasAtendimento: function(obj){
				//console.log(obj);
				if(obj.length === 0){
					alert('Selecione um beneficiário');
				} else {
					window.location = 'frmSicasAtendimento.php?cd_pessoa='+obj[0].cd_pessoa;
				}
			}
		}
	});
    </script>
</body>
</html>