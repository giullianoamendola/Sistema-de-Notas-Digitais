$(document).ready( function(){

	var _this = this ;

	$("#notaVenda").hide();
	$("#botaoAlterar").hide();
	$("#dataNota").mask("99/99/9999");
	$("#dataPagamento").mask("99/99/9999");

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

	_this.desenharNotaVenda = function desenharNotaVenda( notaVenda ){


		 var HTML = " <table class = 'table' border = '1' >	"+		
			"<thead> <tr> <th> Jornal </th> <th> Entregue</th> <th> Vendido </th> <th>Preco </th>   </tr></thead>"
				+"<tbody>";

				var itensNota = notaVenda.itensNota;
			$.each(itensNota, function ( indice, row ) {
												    
													var precoCapa = itensNota[indice].precoCapa;
													var jornal = precoCapa.jornal;
													HTML +='<tr> <td>'+jornal.nome+'</td> ';
													HTML += '<td>'+itensNota[indice].qtdEntregue+'</td> ';
													HTML += ' <td> </td> ';
													HTML +=' <td>'+precoCapa.preco+'</td> </tr>';
											});

			HTML += "</tbody>";



			return HTML ;

	}


	$.ajax({ 
			url: "api/PontoVenda",
			type: "get",
			dataType: "json",
			success: function (resposta) {
					$("#pontosVenda").html( _this.selectPontosVenda( resposta ) );
								//$("#pontosVenda").html(resposta);
							
			},
			error: function(){
					alert("Erro Ponto de Venda");
			}
	    });

	$("#botaoProcurar").on("click", function(event){

		event.preventDefault();

		var dataEPontoVenda = {	dataNota : $("#dataNota").val(), pontoVenda : $("#pontoVenda").val() };
		
		$.ajax({
						url: "api/NotaVenda/DataEPonto",
						type: "get", 
						data: dataEPontoVenda,
						dataType: "json",
						success: function (notaVenda) {
							$("#notaVenda").show();
							$("#itensNota").html(_this.desenharNotaVenda(notaVenda));
							$("#botaoProcurar").hide();
							$("#botaoAlterar").show();
							$("#dataPagamento").val( notaVenda.dataPgmt );
							$("#id_notavenda").val( notaVenda.id );
						},
						error: function(){
							alert("Nao funcionou ! ");
						}
		});




	});
/*
	$("#alterar").on("click",function(){
		$.ajax({
			url:"api/NotaVenda",
			type:"put",
			data: {
					
			}
		});
	});
*/
});


