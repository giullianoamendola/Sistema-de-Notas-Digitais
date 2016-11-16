( function( app ){
	'use strict';

	function ControladoraListagemPrecoCapa( ServicoPrecoCapa, $, toastr){

		var listarPrecoCapa = function listarPrecoCapa( data ){
			var HTML = '';

		 	HTML = " <table class = 'table' border = '1' >	"+		
			"<thead> <tr> <th> Jornal </th> <th>Preco </th> <th>Entregue</th>   </tr></thead>"
				+"<tbody>";
			$.each(data, function ( indice, precoCapa) {

				var jornal = precoCapa.jornal;

				HTML +='<tr> <td>'+jornal.nome+'</td> ';

				HTML +=' <td>'+precoCapa.preco+'</td> ';
				
				HTML +='<td> <input type="text" id =entregue_'+indice+'> </td> </tr>';

				HTML +='<input type="hidden" id = "precoCapa_'+indice+'"value ="'+precoCapa.id+'"/>';
			});

			HTML += "</tbody>";

			$("#itensNota").html( HTML );
			mostrarSucesso( data );
		};

		var mostrarErro = function mostrarErro( jqXhr ){
			toastr.error( "ERRO AO EXECUTAR A OPERACAO ");
		};

		var mostrarSucesso = function mostrarSucesso( data ){
			toastr.success( "SUCESSO ");
		};

		var registrarCliqueEmLinhas =  function registrarCliqueEmLinhas(){

		};

		var lancarPrecoCapa = function lancarPrecoCapa(){

		};

		var registrarCliqueBotoes = function registrarCliqueBotoes(){

		};

		var configurar = function configurar(){
			var resposta = precosCapa();
			resposta.done( listarPrecoCapa );
			resposta.error( mostrarErro );
		};
	}

	app.ControladoraListagemPrecoCapa = ControladoraListagemPrecoCapa ;

})( app );