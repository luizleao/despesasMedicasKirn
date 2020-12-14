<?php
require_once(dirname(__FILE__)."/classes/autoload.php");
$oController = new Controller();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php require_once("includes/header.php");?>
<script>
    $(document).ready(function(){
        var tempoTimeout = 5000;
        /**
         * Ação Buscar Servidor
         * 
         */ 
        $("#linhaAcoes").attr('style', 'display:none');
        
        $('#nm_pessoa').typeahead({
            source: function (query, process) {
                $.ajax({
                    url:      'retornoJson.php',
                    type:     'GET',
                    dataType: 'JSON',
                    data:     'acao=consultarSicasServidor&servidor_ativo=1&nm_pessoa=' + query,
                    timeout:  tempoTimeout,
                    success: function(data) {
                        aServidor = [];
                        oServidor = {};
                        
                        $.each(data, function (i, sServidor) {
                            oServidor[sServidor.oSicasPessoa.nm_pessoa] = sServidor;
                            aServidor.push(sServidor.oSicasPessoa.nm_pessoa);
                            //console.log(oServidor);
                        });
                        
                        process(aServidor);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + '-' + textStatus  + '-' + errorThrown);
                    }
                });
            },
            
            sorter: function (items) {
                return items.sort();
            },
            updater: function (item) {
                $("#cd_servidor").val(oServidor[item].cd_servidor);
                $("#cd_pessoa").val(oServidor[item].oSicasPessoa.cd_pessoa);
                
                $.get("frmDetailSicasPessoa.php?cd_servidor="+oServidor[item].cd_servidor, function(data){
                     $("#detalhesPessoa").html(data);
                });
                $("#linhaAcoes").fadeIn(500, function (){});
                return item;
                
            },
            highlighter: function (item) {
                var regex = new RegExp( '(' + this.query + ')', 'gi' );
                return item.replace(regex, '<strong>$1</strong>');
            }
        });
        
        $("#btnBuscar").click(function (){
            $.get("frmDetailSicasPessoa.php?nm_pessoa="+$('#nm_pessoa').val(), function (data){
                //alert('teste');
            });
        });
        
        $("#btnEditarPessoa").click(function (){
            //alert('Aki 1');
            window.location = 'frmSicasPessoa.php?cd_pessoa='+$("#cd_pessoa").val();
        });
        
        $("#btnEditarServidor").click(function (){
            //alert('Aki 2');
            window.location = 'frmSicasServidor.php?cd_servidor='+$("#cd_servidor").val();
        });
        
        $("#btnFrequenciaMensal").click(function (){
            var win = window.open('resFrequenciaMensal.php?cd_servidor='+$("#cd_servidor").val(), '_blank');
        	win.focus();
        });
    });
    </script>
</head>
<body>
    <div class="container">
        <?php
		require_once("includes/titulo.php");
		require_once("includes/menu.php");
		?>
        <ul class="breadcrumb">
			<li><a href="principal.php">Home</a></li>
			<li><a href="admSicasServidor.php">Servidor</a></li>
			<li class="active">Busca de Servidor</li>
		</ul>
<?php
if ($oController->msg != "")
	$oController->componenteMsg($oController->msg, "erro");
?>
       	<form onsubmit="return false;">
			<div class="row">
				<div class="col-md-12">
					<input type="hidden" id="cd_servidor" name="cd_servidor" /> 
					<input type="hidden" id="cd_pessoa" name="cd_pessoa" />
					<div class="input-group">
						<input type="text" id="nm_pessoa" name="nm_pessoa" class="form-control" data-provide="typeahead" data-items="10" autocomplete="off" placeholder="Nome do Servidor" autofocus />
						<span id="linhaAcoes" class="input-group-btn">
    						<button type="button" class="btn btn-success" id="btnEditarPessoa" name="btnEditarPessoa"><i class="glyphicon glyphicon-edit"></i> Editar Pessoa</button>
    						<button type="button" class="btn btn-primary" id="btnEditarServidor" name="btnEditarServidor"><i class="glyphicon glyphicon-edit"></i> Editar Servidor</button>
    						<button type="button" class="btn btn-warning" id="btnFrequenciaMensal" name="btnFrequenciaMensal"><i class="glyphicon glyphicon-calendar"></i> Frequência Mensal</button>
						</span>
					</div>
					
				</div>
			</div>
			<div id="detalhesPessoa"></div>
		</form>
	</div>
    <?php require_once("includes/footer.php")?>
    <?php require_once("includes/modals.php");?>
    
</body>
</html>