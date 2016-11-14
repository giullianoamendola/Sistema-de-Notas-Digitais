( function( app ){
	'use strict';

	function ControladoraFormPrecoCapa( ServicoPrecoCapa, $, toastr ){
		
		var mostrarErro = function mostrarErro( jqXhr ){
			toastr.error( "ERRO AO EXECUTAR A OPERACAO ");
		};

		var mostrarSucesso = function mostrarSucesso( data ){
			toastr.success( "SUECESSO ");
		};

		var registrarCliquebotoes = function registrarCliquebotoes( ){

		};

		var idSelecionado = function idSelecionado(){

		};

		var configurar = function configurar(){
			registrarCliquebotoes();
		};
	}

	app.ControladoraFormPrecoCapa = ControladoraFormPrecoCapa ;

})( app );