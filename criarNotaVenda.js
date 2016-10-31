


$(document).ready( function(){


	$.ajax({ 
		url: "api/PrecoCapa",
		type: "get",
		dataType: "html",
				//dataType: "json",
				success: function (resposta) {

					$("#itensNota").html( resposta);
				},
				error: function(){
					alert("Erro PrecoCapa");
				}

			});

	$.ajax({ 
		url: "api/PontoVenda",
		type: "get",
		dataType: "html",
		success: function (resposta) {

			$("#pontosVenda").html(resposta);

		},
		error: function(){
			alert("Erro Ponto de Venda");
		}

	});
	_this = this ;


	_this.qtdEntregue =  function qtdEntregue(){	
		var qtdEntregue = [] ;
		var MAXITENSPORNOTA = 8 ;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){
			qtdEntregue[contagem] = $("#itensNota #itemNota #entregue_"+contagem ).val();

		}
		return qtdEntregue ;
	}

	_this.precosCapa =  function precosCapa(){	
		var precosCapa = [] ;
		var MAXITENSPORNOTA = 8 ;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){

			precosCapa[contagem] = $("#itensNota #itemNota #precoCapa_"+contagem).val();

		}
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
						dataPgmt: $('#dataPagamento').val(),
						pontoVenda: $("#pontovenda").val(),
						itensNota: {
									qtdEntregue : _this.qtdEntregue(),
									precosCapa: _this.precosCapa()
									}

					},
					success: function (resposta) {

						alert(" Nota Criada "+ resposta);



					},
					error: function( jqXHR, textStatus, errorThrown ){
						alert("Nota nao Criada");
					}
				});

				
			});




});




/*


												$.ajax({
												url: "api/ItemNota",
												type: "POST",
												data: {
																notaVenda: resposta,//id da nota de Venda
																precosCapa: _this.precosCapa(),
																itensNota: _this.itensNota()
															},
															success: function( resposta ){
																alert("Itens Criados"+ resposta );
															},
															error: function( jqXHR, textStatus, errorThrown ){
																alert("Itens nao Criados");
															}
													});
											}


	$(document).ready({

		var obj = new PontoVendaVM;

		obj.listar();
	
		PrecoCapaVM.listar();

		$('#criar').onclick({

			NotaVendaVM.criarNotaVenda();
			ItemNotaVM.criarItemNota();
		});

	});





	_this.tabelaPrecoCapa = function tabelaPrecoCapa( resposta ){

	var HTML = '';

	 HTML = " <table class = 'table' border = '1' >	"+		
		"<thead> <tr> <th> Jornal </th> <th>Preco </th>   </tr></thead>"
			+"<tbody>";
		$.each(resposta, function ( indice, precoCapa) {

												var jornal = precoCapa.jornal;
												HTML +='<tr> <td>'+jornal.nome+'</td> ';
						
												HTML +=' <td>'+precoCapa.preco+'</td> </tr>';
											
										});

		HTML += "</tbody>";

		return HTML ;


	_this.qtdEntregue =  function qtdEntregue(){	
		var qtdEntregue = [] ;
		var MAXITENSPORNOTA = 2 ;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){

			qtdEntregue[contagem] = $("#entregue_"+contagem).val();
			alert( $("#entregue_"+contagem).val() );
		}
		return qtdEntregue ;
	}









*/