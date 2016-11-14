( function( app ){
	'use strict';

	function ControladoraFormNotaVenda( ServicoNotaVenda, $, toastr ){

		var mostrarErro = function mostrarErro( jqXhr ){
			toastr.error( "ERRO AO EXECUTAR A OPERACAO ");
		};

		var mostrarSucesso = function mostrarSucesso( data ){
			toastr.success( "SUCESSO");
		};

		var qtdEntregue =  function qtdEntregue(){	
			var qtdEntregue = [] ;
			var MAXITENSPORNOTA = 9 ;
			var contagem = 0;
			for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){
				qtdEntregue[contagem] = $("#entregue_"+contagem ).val();

			}
			console.log( qtdEntregue );
			return qtdEntregue ;
		}

		var precosCapa =  function precosCapa(){	
			var precosCapa = [] ;
			var MAXITENSPORNOTA = 9 ;
			var contagem = 0;
			for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){

				precosCapa[contagem] = $("#precoCapa_"+contagem).val();

			}
			console.log( precosCapa );
			return precosCapa ;

		}

		var criarNotaVenda = function criarNotaVenda(){
			
			var notaVenda = {	
					dataNota: $('#dataNota').val(),
					pontoVenda: $("#pontoVenda").val(),
					itensNota: {
								qtdEntregue : _this.qtdEntregue(),
								precosCapa: _this.precosCapa()
								}
				};

			var resultado  = ServicoNotaVenda.criarNotaVenda( notaVenda );
			resultado.done( mostrarSucesso );
			resultado.error( mostrarErro );
		};

		var registrarCliqueBotoes = function registrarCliqueBotoes(){
			$("#criar").on( "click", function( event ){
				criarNotaVenda();
		};

		var idSelecionado = function idSelecionado(){
			return parseInt( $( '#notasVenda tbody .cor-linha :first' ).html() );
		};

		var configurar = function configurar(){
			registrarCliqueBotoes();
		};
	}

	app.ControladoraFormNotaVenda = ControladoraFormNotaVenda ;
})( app );