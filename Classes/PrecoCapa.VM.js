( function( $, app ){

	function PrecoCapaVM(){

		var _this = this;

		var listarPrecoCapa = function (){ 
			 $.ajax({ url: "ControladoraPrecoCapa.php",	type: "get", data:"",dataType: "html"}));	//RETORNARA UMA TABELA

		}

	}


})($, app);