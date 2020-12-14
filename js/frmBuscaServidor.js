$(document).ready(function(){
    var tempoTimeout = 5000;
    /**
     * Ação Buscar Servidor
     * 
     */ 
    $("#linhaAcoes").fadeOut(500, function (){});
    
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
        window.location = 'editSicasPessoa.php?cd_pessoa='+$("#cd_pessoa").val();
    });
    
    $("#btnEditarServidor").click(function (){
        //alert('Aki 2');
        window.location = 'editSicasServidor.php?cd_servidor='+$("#cd_servidor").val();
    });
    
    $("#btnFrequenciaMensal").click(function (){
        var win = window.open('resFrequenciaMensal.php?cd_servidor='+$("#cd_servidor").val(), '_blank');
    	win.focus();
    });
});