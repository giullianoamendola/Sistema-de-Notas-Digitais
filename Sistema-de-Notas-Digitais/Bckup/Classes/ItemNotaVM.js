( function( $, app ){

	function ItemNotaVM(){

		var _this = this;

		var criarItensNota = function criarItensNota(){
			$.ajax({
							url: "ControladoraItemNota.php",
							type: "post",
							data: ("#itensNota").val(),
							dataType: "html"
			});
		}


	}



})