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

	_this.tabelaItemNota = function tabelaItemNota( resposta ){

	var HTML = '';

	 HTML = " <table class = 'table' border = '1' >	"+		
		"<thead> <tr> <th> Jornal </th> <th>Preço </th> <th>Entregue</th>   </tr></thead>"
			+"<tbody>";
		$.each(resposta, function ( indice, precoCapa) {

			var jornal = precoCapa.jornal;

			HTML +='<tr> <td>'+jornal.nome+'</td> ';

			HTML +=' <td>'+precoCapa.preco+'</td> ';
			
			HTML +='<td> <input type="text" id =entregue_'+indice+'> </td> </tr>';

			HTML +='<input type="hidden" id = "precoCapa_'+indice+'"value ="'+precoCapa.id+'"/>';
		
		});

		HTML += "</tbody>";

		return HTML ;
	}

	_this.selectPontosVenda = function selectPontosVenda( pontoVenda ){
		
		var pontoVenda = jQuery.parseJSON( pontoVenda );
		var HTML = '<select class ="select col-md-2" id = "pontoVenda">';

		$.each(pontoVenda , function ( indice, row) {
			console.log( row.id );
			HTML += '<option value ="'+row.id+'">'+row.nome+'</option>';

		});

		HTML += '</select>';

		return HTML ;
	}

	_this.zerarLista = function zerarLista(){
		var MAXITENSPORNOTA = 5 ;
		for( var contagem = 0 ; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){
			$("#entregue_"+contagem).val(0);
		}
	}

	_this.buscarPrecoCapa = function buscarPrecoCapa(){
		$.ajax({ 
			url: "api/PrecoCapa",
			type: "get",
			//dataType: "json",
			success: function (resposta) {

				$("#itensNota").html( _this.tabelaItemNota( resposta ) );
			},
			error: function(){
						alert("Erro PrecoCapa");
			}

			});
	}();

	_this.buscarPontoVenda = function buscarPontoVenda(){
		$.ajax({ 
				url: "api/NotaVenda/PontosSemNota",
				type: "get",
				dataType: "html",
				success: function (resposta) {

					$("#pontosVenda").html( _this.selectPontosVenda( resposta ) );
				
				},
				error: function( jqXHR ){
					alert("Erro Ponto de Venda");
				}
			    });
	}();


	_this.qtdEntregue =  function qtdEntregue(){	
		var qtdEntregue = [] ;
		var MAXITENSPORNOTA = 5 ;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){
			qtdEntregue[contagem] = $("#entregue_"+contagem ).val();

		}
		console.log( qtdEntregue );
		return qtdEntregue ;
	}

	_this.precosCapa =  function precosCapa(){	
		var precosCapa = [] ;
		var MAXITENSPORNOTA = 5 ;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){

			precosCapa[contagem] = $("#precoCapa_"+contagem).val();

		}
		console.log( precosCapa );
		return precosCapa ;

	}


	$("#criar").on( "click", function( event ){

		event.preventDefault();
			
				//NOTA VENDA 
				$.ajax({
					url: "api/NotaVenda",
					type: "post",
					data: {

						dataNota: $('#dataNota').val(),
						pontoVenda: $("#pontoVenda").val(),
						itensNota: {
									qtdEntregue : _this.qtdEntregue(),
									precosCapa: _this.precosCapa()
									}

					},
					success: function (resposta) {

						alert(" Nota Criada "+ resposta);
						//document.location.reload();
						_this.zerarLista();
						$.ajax({ 
							url: "api/NotaVenda/PontosSemNota",
							type: "get",
							dataType: "html",
							success: function (resposta) {

								$("#pontosVenda").html( _this.selectPontosVenda( resposta ) );
							
							},
							error: function( jqXHR ){
								alert("Erro Ponto de Venda");
							}
						 });


					},
					error: function( jqXHR, textStatus, errorThrown ){
						alert("Nota nao Criada");
					}
				});

				
			});




});


