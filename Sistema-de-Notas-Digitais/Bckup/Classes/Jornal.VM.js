( function( $, app ){

	function JornalVM(){

		var _this = this;

		var listarJornal = function (){ 
			$('#tabelaJornal').val( $.ajax({
													url: "ControladoraJornal.php",
													type: "get",
													data:"",
													dataType: "html"
												}));	//RETORNARA UMA TABELA

		}

	}


})($, app);