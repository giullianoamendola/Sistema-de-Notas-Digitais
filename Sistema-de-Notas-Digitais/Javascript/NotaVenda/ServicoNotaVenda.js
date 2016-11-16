( function( app ){
	'use strict';

	function ServicoNotaVenda( $ ){
		var rotaBase = "api/NotaVenda";

		var notasVenda = function notasVenda(){
			return $.ajax({
				url : rotaBase,
				type: "get"
			});
		};

		var criarNotaVenda = functio criarNotaVenda( notaVenda ){
			return $.ajax({
				url : rotaBase,
				type: "post",
				data: notaVenda
			});
		};

	}

	app.ServicoNotaVenda = ServicoNotaVenda ;
})( app );
