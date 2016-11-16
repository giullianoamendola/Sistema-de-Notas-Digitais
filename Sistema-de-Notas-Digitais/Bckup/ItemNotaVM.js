( function ( $, app ){

	function ItemNotaVM(){

		var _this = this ;


		var criarItensNota = function criarItensNota(){
			$.ajax({
							url: "app/ItemNota",
							type: "post",
							data: $("#itensNota").val(),
							success: function (resposta) {
								alert("Item Nota Criada");
							},
							error: function( jqXHR, textStatus, errorThrown ){
								alert("Item Nota nao Criada");
							}
			});
		}	


	}

	app.ItemNotaVM = ItemNotaVM ;

})( $, app);