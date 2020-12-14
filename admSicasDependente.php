<?php
require_once("classes/autoload.php");
$oController = new ControllerSicasDependente(); 

if($_REQUEST['acao'] == 'excluir'){
	print($oController->excluir($_REQUEST['cd_dependente']))? "" : $oController->msg; exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
</head>
<body>
    <?php require_once("includes/modals.php");?>
    <div id="app" class="container">
        <?php require_once("includes/titulo.php");?>
        <?php require_once("includes/menu.php");?>
        <ol class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li class="active">Administrar Dependente</li>
		</ol>
		<div class="row">
			<div class="col-md-6">
				<div class="input-group">
				<input autofocus type="text" name="txtConsulta" id="txtConsulta" class="form-control input-sm" placeholder="Pesquisar Dependente" v-model="txtBusca" @keydown="eventBusca($event)" />
				<span class="input-group-btn">
					<button id="btnConsultar" class="btn btn-primary btn-sm" type="button" data-loading-text="Carregando..." @click="consultarSicasDependente"><span class="glyphicon glyphicon-search"></span></button>
					<a href="frmSicasDependente.php" class="btn btn-success btn-sm" title="Cadastrar Dependente"><i class="glyphicon glyphicon-plus"></i></a>
				</span>
				</div>
			</div>
		</div>
		
		<loading v-show="isLoading"></loading>

        <table class="table table-striped table-condensed" v-if="aSicasDependente.length > 0">
            <thead>
				<tr>
					<th>Dependente</th>
					<th>Servidor</th>
					<th>Grau Parentesco</th>
					<th>Escolaridade</th>
					<th>Data de Inclusão</th>
					<th>Data de Manutenção</th>
					<th>Dependente Financeiro</th>
					<th>Dependente PROAS</th>
					<th></th>
                    <th></th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
                <tr v-for="obj in aSicasDependente">
					<td>{{ obj.oSicasPessoa.nm_pessoa }}</td>
					<td>{{ obj.oSicasServidor.oSicasPessoa.nm_pessoa }}</td>
					<td>{{ obj.oSicasGrauParentesco.desc_grauparentesco }}</td>
					<td>{{ obj.oSicasEscolaridade.nm_escolaridade }}</td>
					<td>{{ obj.dt_inclusao | formataData }}</td>
					<td>{{ obj.dt_manutencao | formataData }}</td>
					<td>{{ obj.dependente_financ == "1" ? "Sim" : "Não" }}</td>
					<td>{{ obj.dependente_proas == "1" ? "Sim" : "Não" }}</td>
					<td><button class="btn btn-info btn-xs" @click="goDetalhes(obj)"><i class="glyphicon glyphicon-search"></i></button></td>
					<td><button class="btn btn-success btn-xs" @click="goEdit(obj)"><i class="glyphicon glyphicon-edit"></i></button></td>
					<td><button class="btn btn-danger btn-xs" @click="excluir(obj)"><i class="glyphicon glyphicon-trash"></i></button></td>
				</tr>
            </tbody>
		</table>
		<div v-show="isAlerta">
			<br />
    		<div class="alert alert-warning alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
                <h5 class="alert-heading"><img src="img/ico_alert.png" /> {{ msg }} </h5>
            </div>
        </div>
	</div>
    <?php require_once("includes/footer.php")?>
    <script>
	var app = new Vue({
		el: '#app',
		data: {
			msg : '',
			aSicasDependente : [],
			oSicasPessoa: {},
			txtBusca : '',
			isLoading: false,
			isAlerta: false 
				
        },
		methods: {
			eventBusca:function(event){
				//console.log(event.keyCode);
				if(event.keyCode == 13){ // enter
					this.consultarSicasDependente();
				}
			},
			consultarSicasDependente:function() {
				$('#btnConsultar').button('loading');
				this.isLoading = true;
				this.isAlerta = false;
				this.aSicasDependente = [];
				this.$http.get('rest/SicasDependente/!/'+this.txtBusca).then(res => {
					$('#btnConsultar').button('reset');
					this.isLoading = false;
					if(res.body.length > 0){
	    		    	this.aSicasDependente = res.body;
					} else {
						this.isAlerta = true;
						this.msg = 'Nenhum registro encontrado';
					}
	    		    //console.log(this.aSicasDependente);
				}, res => {
					$('#btnConsultar').button('reset');
					this.isLoading = false;
					console.log(res);
				    return false;
				});
			},

			excluir:function(obj) {
				this.isLoading = true;
				this.$http.delete('rest/SicasDependente/'+obj.cd_dependente).then(res => {
					this.isLoading = false;
	    		    return true;
				}, res => {
					this.isLoading = false;
					console.log(res);
				    return false;
				});
			},

			goEdit:function(obj){
				window.location = 'frmSicasDependente.php?cd_dependente='+obj.cd_dependente;
			},

			goDetalhes:function(obj){
				$('#modalRemote').find('.modal-body').load('detailSicasDependente.php?id='+obj.cd_dependente);
			    $('#modalRemote').modal('show');
			}
		},
		filters: {
			formataData:function(value){
				if(value !== null){
					aDate = value.split('-');
    				date = new Date(aDate[0], aDate[1], aDate[2]);
    
    				let dd 	  = date.getDate();
    				let mm 	  = date.getMonth();
    				let yyyy  = date.getFullYear();
                    
                    dd = (dd<10) ? '0'+dd : dd
                    mm = (mm<10) ? '0'+mm : mm
                   	mm = (mm == '00') ? '12' : mm 
                    
                    date = dd+'/'+mm+'/'+yyyy;
				} else {
					date = '';
				}
			    return date;
			}
		}
	});
    </script>
</body>
</html>