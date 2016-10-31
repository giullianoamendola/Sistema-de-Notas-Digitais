( function( $, app ){

	function PontoVendaVM(){

		var _this = this;

		_this.listar = function (){ 
			$.ajax({ 
					url: "api/PontoVenda",
					type: "get",
					dataType: "html",
					success: function (resposta) {

						$("#pontosVenda").html(resposta);
					},
					error: function(){
						alert("Erro no Ponto de Venda");
					}
	   			 });

	}



})($, app);