( function( app ){
	"use strict";

	function ServicoPrecoCapa( $ ){

		var rotaBase = "api/PrecoCapa";

		var precosCapa = function(){
			return $.ajax({
					url : rotaBase,
					type: "get"
				});
		};
	}

	app.ServicoPrecoCapa = ServicoPrecoCapa;


})( app );