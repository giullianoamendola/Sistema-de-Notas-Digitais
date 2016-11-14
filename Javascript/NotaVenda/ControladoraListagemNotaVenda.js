( function( app ){
	'use strict';

	function ControladoraListagemNotaVenda( ServicoNotaVenda, $, toastr ){

		var listarNotasVenda = function listarNotasVenda( data ){

		};

		var mostrarErro = function mostrarErro( jqXhr ){
			toastr.error("ERRO AO EXECUTAR A OPERACAO");
		};

		var mostrarSucesso = function mostrarSucesso( data ){
			toastr.error("SUCESSO");
		};

		var registrarCliqueEmLinhas = function registrarCliqueEmLinhas(){
				$( '#notasVenda tbody tr' ).click( function linhaClick() {
				$( '#notasVenda tbody tr' ).removeClass( 'cor-linha' );
				$( this ).toggleClass( 'cor-linha' );
			} );
		};

		var removerNotaVenda = function removerNotaVenda(){

		};

		var alterarNotaVenda = function alterarNotaVenda(){

		};



		var registrarCliqueEmBotoes = function registrarCliqueEmBotoes(){
			
		};

		var idSelecionado = function idSelecionado(){
			return parseInt( $( '#notasVenda tbody .cor-linha :first' ).html() );
		};

		var configurar = function configurar(){
			var resultado = ServicoNotaVenda.notasVenda;
			resultado.done( listarNotasVenda );
			resultado.fail( mostrarErro );
		};
	}

	app.ControladoraListagemNotaVenda = ControladoraListagemNotaVenda ;

})( app );