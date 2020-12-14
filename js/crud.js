$(document).ready(function(){
    var classe = $("#classe").val();
    var timeout = 10000;

    /**
     * 
     * Ação Cadastrar
     * 
     * @author luizleao
     */
    $("#btnCadastrar").click(function () {
        dados = retornaParametros(document.forms[0]);
        $.ajax({
            url : '',
            type : 'post',
            data : dados,
            dataType: 'html',
            beforeSend: function(){
                $('#btnCadastrar').button('loading');
            },
            timeout: timeout,
            success: function(retorno){
            	console.log(retorno);
            	$('#btnCadastrar').button('reset');
                $('#modalResposta').find('.modal-body').html((retorno !== '') ? '<img src="img/ico_error.png" /> '+retorno : '<img src="img/ico_success.png" /> Cadastrado com sucesso');
                $('#modalResposta').modal('show');            
            },
            error: function(retorno){
            	console.log(retorno);
                $('#btnCadastrar').button('reset');
                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> '+retorno);
                $('#modalResposta').modal('show');
            }
        });
        $('#modalResposta').on('shown.bs.modal', function (){
            $('#modalResposta').find('#btnFechar').focus();
        });
    });
	
    
    
    /**
     * 
     * Ação Editar
     * @author luizleao
     */
    $("#btnEditar").click(function () {
        dados = retornaParametros(document.forms[0]);
        //print_r(document.forms[0]); return false;
        
        $.ajax({
            url : '',
            type : 'post',
            data : dados,
            dataType: 'html',
            beforeSend: function(){
                $('#btnEditar').button('loading');
            },
            timeout: timeout,
            success: function(retorno){
                $('#btnEditar').button('reset');
                $('#modalResposta').find('.modal-body').html((retorno !== '') ? '<img src="img/ico_error.png" /> '+retorno : '<img src="img/ico_success.png" /> Editado com sucesso');
                $('#modalResposta').modal('show');
            },
            error: function(response){
            	console.log(response);
                $('#btnEditar').button('reset');
                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Erro!!: '+response.statusText);
                $('#modalResposta').modal('show');
            }
        });
        $('#modalResposta').on('shown.bs.modal', function (){
            $('#modalResposta').find('#btnFechar').focus();
        });
    });
    
    /**
	 * Funcao Excluir
	 * 
	 * @author luizleao
	 */
	$("a#btnExcluir").click(function () {
		var campo = $(this).data("id");
		var valor = $(this).data("id-valor");
		
		$('#modalExcluir').modal('show');
	    $('#modalExcluir').find('.modal-body').html('Deseja excluir o registro?');

	    $('#btnSim').click(function () {
	        $.ajax({
	            url        : '?acao=excluir&'+campo+'='+valor,
	            type       : 'get',
	            beforeSend : function(){
	                $('#btnCadastrar').button('loading');
	            },
	            timeout : timeout,
	            success : function(retorno){
	                $('#modalExcluir').modal('hide');
	                $('#modalResposta').find('.modal-body').html((retorno !== '') ? '<img src="img/ico_error.png" /> '+retorno : '<img src="img/ico_success.png" /> Excluido com sucesso');
	                $('#modalResposta').modal('show');
	                $('#modalResposta').on('hide.bs.modal', function () {
	                    window.location = '';
	                });
	            },
	            error : function(retorno){
	                $('#modalExcluir').modal('hide');
	                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Erro: '+retorno.responseText);
	                $('#modalResposta').modal('show');
	            }
	        });
	    });
	});
	
	
	 /**
     * 
     * Ação Logar
     * @author luizleao
     */
    $('#btnLogar').click(function(){
        dados = retornaParametros(document.forms[0]);
        $.ajax({
            url : 'resIndex.php',
            type : 'post',
            data : dados,
            dataType: 'html',
            beforeSend: function(){
                $('#btnLogar').button('loading');
            },
            timeout: timeout,
            success: function(retorno){
                //$('#btnLogar').button('reset');

                if(retorno !== ''){
                	$('#btnLogar').button('reset');
                    $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> '+retorno);
                    $('#modalResposta').modal('show');
                } else{
                    window.location = 'principal.php';
                }
            },
            error: function(retorno){
            	//console.log(retorno);
            	switch(retorno.statusText){
	            	case "timeout": 
	            		msg = "Tempo de requisição esgotado";
	            	break;
            	}
            	
                $('#btnLogar').button('reset');
                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Erro: '+msg);
                $('#modalResposta').modal('show');
            }
        });
        $('#modalResposta').on('shown.bs.modal', function (){
            $('#modalResposta').find('#btnFechar').focus();
        });
    });
	
	
	
	
	
	/**
	 * Funcao ver detalhes
	 * 
	 * @author luizleao
	 */
	$("a#btnDetalhes").click(function () {
	    $('#modalRemote').find('.modal-body').load('detail'+classe+'.php?id='+$(this).data("id"));
	    $('#modalRemote').modal('show');
	});

	
// Mascaramento de dados
    //$('.data').mask('11/11/1111');
    //$('.time').mask('00:00:00');
    //$('.datehora').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.telefone').mask('(00) 00000-0000');
    $('.celular').mask('(00) 00000-0000');
    $('.mixed').mask('AAA 000-S0S');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    
    /**
     * 
     * Exibir Detalhes de Pessoa
     * 
     * @author luizleao
     */
    /*
    $("#btnConsultar").click(function () {
	    $("#btnDetalhesPessoa151").click(function () {
		//$("button[id^='btnDetalhesPessoa']").click(function () {
			alert($(this).attr('data-pessoa'));
		    //$('#modalRemote').find('.modal-body').load('frmDetailSicasPessoa.php?cd_pessoa='+$(this).attr('data-pessoa'));
		    //$('#modalRemote').modal('show');
		});
    });
    */
   
});

function excluir(campo, valor){
	var timeout = 5000;
	
    $('#modalExcluir').modal('show');
    $('#modalExcluir').find('.modal-body').html('Deseja excluir o registro?');

    $('#btnSim').click(function () {
        $.ajax({
            url        : '?acao=excluir&'+campo+'='+valor,
            type       : 'get',
            beforeSend : function(){
                $('#btnCadastrar').button('loading');
            },
            timeout    : timeout,
            success    : function(retorno){
                $('#modalExcluir').modal('hide');
                $('#modalResposta').find('.modal-body').html((retorno !== '') ? '<img src="img/ico_error.png" /> '+retorno : '<img src="img/ico_success.png" /> Excluido com sucesso');
                $('#modalResposta').modal('show');
                $('#modalResposta').on('hide.bs.modal', function () {
                    window.location = '';
                });
            },
            error	   : function(retorno){
                $('#modalExcluir').modal('hide');
                $('#modalResposta').find('.modal-body').html('<img src="img/ico_error.png" /> Erro: '+retorno);
                $('#modalResposta').modal('show');
            }
        });
    });
}

function verDetalhe(id){
    var classe = $("#classe").val();
    
    $('#modalRemote').find('.modal-body').load('detail'+classe+'.php?id='+id);
    $('#modalRemote').modal('show');
}