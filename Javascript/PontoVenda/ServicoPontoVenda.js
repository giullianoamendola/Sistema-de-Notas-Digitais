( function( app ){
	'use strict';

	function ServicoPontoVenda( $ ){
		var urlBase = 'api/PontoVenda';

		_this.pontosVenda = pontosVenda(){
			return	$.ajax({ 
							url: urlBase,
							type: "get"
						});
		};



	}

	app.ServicoPontoVenda = ServicoPontoVenda ;

})( app );