( function( app ) {

	'use strict';

	function ControladoraFormPontoVenda( $, servicoPontoVenda, toastr ){

		var mostrarErro = function mostrarErro( jqXhr ){
			toastr.error( " ERRO AO BUSCAR PRECOS ");
		};

		var mostrarSucesso = function mostrarSucesso( jqXhr ){
			toastr.success( "SUCESSO ");
		};

		var registrarCliqueBotoes = function registrarCliqueBotoes(){

		};

		var idSelecionado = function idSelecionado(){
			return $("#pontoVenda").val();
		};

		this.configurar = function configurar() {
			registrarCliqueBotoes();
		};

	}

	app.ControladoraFormPontoVenda = ControladoraFormPontoVenda ;

})( app );