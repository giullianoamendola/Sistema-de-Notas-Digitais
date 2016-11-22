/*
( function( $, app, toastr ){
	'use strict';

	var servicoNotaVenda  =  app.ServicoNotaVenda( $ );
	var servicoPrecoCapa = new app.ServicoPrecoCapa( $ );
	var servicoPontoVenda = new app.ServicoPontoVenda( $ );

	var ctrlListagemPrecoCapa = new app.ListagemPrecoCapa( servicoPrecoCapa,
		 $,
		 toastr
		  );
	var ctrlListagemPontoVenda = new app.ListagemPontoVenda( servicoNotaVenda,
		 $,
		 toastr
		  );

	var ctrlFormNotaVenda = new app.ControladoraFormNotaVenda( 
		servicoNotaVenda,
		 $,
		 toastr
		  );
	ctrlListagemPontoVenda.configurar();
	ctrlListagemPrecoCapa.configurar();
	ctrlFormNotaVenda.configurar();

})( jQuery , app);



*/

$(document).ready( function(){

	_this = this ;

	$("#dataNota").mask("99/99/9999");
	$("#dataPagamento").mask("99/99/9999");
	$("#registrar").hide();
	
	_this.pontosDoJornaleiro = function pontosDoJornaleiro(){
			$.ajax({ 
			url: "api/PontoVendaPorJornaleiro",
			type: "get",
			dataType: "html",
			success: function (resposta) {

				$("#pontosVenda").html( _this.selectPontosVenda( resposta ) );

			},
			error: function(){
				alert("Erro Ponto de Venda");
			}

		});
	}();


	_this.desenharNotaVenda = function desenharNotaVenda( notaVenda ){

		var HTML = '';

		 HTML = " <table class = 'table' border = '1' >	"+		
			"<thead> <tr> <th> Jornal </th>  <th>Entregue</th> <th> Vendido</th> <th>Preco </th>  </tr></thead>"
				+"<tbody>";
			 var itensNota = notaVenda.itensNota ;
			$.each(itensNota, function ( indice, itemNota) {
				var precoCapa = itemNota.precoCapa;
				var jornal = precoCapa.jornal;
				console.log( itemNota );
				HTML +='<tr><input type="hidden" id ="idItemNota_'+indice+'" value="'+itemNota.id+'"> <td>'+jornal.nome+'</td> ';
				HTML +=' <td>'+itemNota.qtdEntregue+'</td> ';
				HTML +='<td><input type ="text" id ="qtdVendido_'+indice+'"/> </td>';
				HTML +=' <td>'+precoCapa.preco+'</td> ';
				//HTML += '<input type ="text" id ="idItemNota_'+indice+'" value="'+itemNota.id+'"/></tr> ';
				
			});

			HTML += "</tbody>";

			return HTML ;
	}


	_this.selectPontosVenda = function selectPontosVenda( pontoVenda ){
		var pontoVenda = jQuery.parseJSON( pontoVenda );
		var HTML = '<select class ="select col-md-2" id = "pontoVenda">';

		$.each(pontoVenda , function ( indice, row) {
			HTML += '<option value ="'+row.id+'">'+row.nome+'</option>';

		});

		HTML += '</select>';

		return HTML ;
	}



	_this.itensNota =  function itensNota(){	
		var itensNota = [] ;
		var MAXITENSPORNOTA = 5 ;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){
			
			itensNota[contagem] = { id  : $("#idItemNota_"+contagem).val() , qtdVendido  : $("#qtdVendido_"+contagem ).val() };
			console.log( $("#idItemNota_"+contagem).val() );
		}
		return itensNota ;
	}

		$("#procurar").on("click", function(event){

			event.preventDefault();
			var dataEPontoVenda = {	dataNota : $("#dataNota").val(), pontoVenda : $("#pontoVenda").val() };
			
			$.ajax({
								url: "api/NotaVenda/DataEPonto",
								type: "get", 
								data: dataEPontoVenda,
								dataType: "json",
								success: function (notaVenda) {
									$("#itensNota").html(_this.desenharNotaVenda(notaVenda));
									$("#procurar").hide();
									$("#idNotaVenda").val(notaVenda.id );
									$("#registrar").show();
									//$("#botaoEnvio").show();
								},
								error: function(){
									alert("Nao funcionou ! ");
								}
				});


	});



	$("#registrar").on( "click", function( event ){

		event.preventDefault();
				//NOTA VENDA 
				$.ajax({
					url: "api/NotaVenda/RegistrarVenda",
					type: "put",
					data: {
						id : $('#idNotaVenda').val(),
						itensNota: _this.itensNota()

					},
					success: function (resposta) {

						alert("Venda Registrada !"+ resposta);



					},
					error: function( jqXHR, textStatus, errorThrown ){
						alert("Venda nao Registrada");
					}
				});

				
			});




});


