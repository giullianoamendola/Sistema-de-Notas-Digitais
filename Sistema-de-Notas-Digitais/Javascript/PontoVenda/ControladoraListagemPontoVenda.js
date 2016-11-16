( function( app ){
	'use strict';

	function ControladoraListagemPontoVenda( servicoPontoVenda, $, toastr, window ){

		var montarSelectPontoVenda = function montarSelectPontoVenda( data ){
			
			var pontoVenda = jQuery.parseJSON( data );
			var HTML = '<select class ="select col-md-2" id = "pontoVenda">';

			$.each(pontoVenda , function ( indice, row) {
				console.log( row.id );
				HTML += '<option value ="'+row.id+'">'+row.nome+'</option>';

			});

			HTML += '</select>';

			$("#pontosVenda").html( HTML );
		
		};

		var mostrarErro = function mostrarErro( jqXhr ){
			toastr.error( " ERRO AO BUSCAR OS PONTOS DE VENDA ");
		};

		var mostrarSucesso = function mostrarSucesso( data ){
			toastr.success( "Pontos de venda ");
		};
	
		var configurar = function configurar(){
			var resultado = pontosVenda();
			resultado.done( montarSelectPontoVenda );
			resultado.fail( mostrarErro );
		};

	}

	app.ControladoraListagemPontoVenda = ControladoraListagemPontoVenda ;

})( app );