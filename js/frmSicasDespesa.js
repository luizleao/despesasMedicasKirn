$(document).ready(function(){
    var tempoTimeout = 5000;
    
    $('#btnBuscar').click(function () {
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
    });
});