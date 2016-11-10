( function( $, app, PrecoCapaServico, PontoVendaServico ){

	function NotaVenda(){

		var _this = this ;
		var _this.precoCapaServico = new PrecoCapaServico();
		var _this.pontoVendaServico = new PontoVendaServico();
		
		var configurar = function configurar(){

			$("#dataNota").mask("99/99/9999");
			$("#dataPagamento").mask("99/99/9999");
			_this.precoCapaServico.getPrecosCapa();
			_this.pontoVendaServico.getPontosVenda();

		}


	}
		






})( $, app );