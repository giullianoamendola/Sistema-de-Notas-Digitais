( function( $, app){		

	function PontoVendaVM(){

		var _this = this;

		var ListarPontosVenda = function (){ 
		 $.ajax({	url: "ControladoraPontosVenda.php",type: "get",data:"",dataType: "html"}));	//RETORNARA UMA TABELA

		}


	}

	app.PontoVendaVM = PontoVenda;

})( $, app );