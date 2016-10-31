( function ( $, app ){

	function NotaVendaVM(){

		var _this = this ;


		var notaVenda = function notaVenda(){
			
			return ( $('#data').val() , $('#dataPgmt').val(), $('#pontoVenda').val() );
								
		}

		var criarNotaVenda = function criarNotaVenda(){
			$.ajax({
							url: "ControladoraNotaVenda.php",
							type: "post",
							data: _this.notaVenda,
							dataType: "html"
			});
		}	


	}

	app.NotaVendaVM = NotaVendaVM ;

})( $, app);