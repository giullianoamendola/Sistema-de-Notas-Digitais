( function ( $, app,  ){

	function NotaVendaServico(){

		var _this = this ;

		var notaVenda = function notaVenda(){
			
			return ( $('#data').val() , $('#dataPgmt').val(), $('#pontoVenda').val() );
								
		}

		var criarNotaVenda = function criarNotaVenda(){
			$.ajax({
							url: "api/NotaVenda",
							type: "post",
							data: _this.notaVenda,
							success: function (resposta) {
								alert("Item Nota Criada");
							},
							error: function( jqXHR, textStatus, errorThrown ){
								alert("Item Nota nao Criada");
							}
			});
		}	


	}

	app.NotaVendaVM = NotaVendaVM ;

})( $, app);