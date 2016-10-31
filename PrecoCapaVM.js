( function( $, app ){

	function PrecoCapaVM(){

		var _this = this;


		_this.listar = function (){
			$.ajax({ 
					url: "api/PrecoCapa",
					type: "get",
					dataType: "html",
					success: function (resposta) {
						$("#precosCapa").html(resposta);
					},
					error: function(){
						alert("Erro no Preco de Capa");
					}

				});
		}
	}


})($, app);