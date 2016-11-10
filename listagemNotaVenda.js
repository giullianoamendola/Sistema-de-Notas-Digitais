$(document).ready( function(){

	var _this = this ;

	$("#botoesListagem").hide();

	_this.desenharNotaVenda = function desenharNotaVenda( notaVenda ){
		var HTML =  notaVenda.pontoVenda.nome;
		HTML += "<br/>";
		HTML += "Data: "+notaVenda.dataNota;
		HTML += "<br/>";
		HTML += "Data Pagamento: "+notaVenda.dataPagamento;
		HTML += "<br/>";


		 HTML += " <table class = 'table' border = '1' >	"+		
			"<thead> <tr> <th> Jornal </th> <th> Entregue</th> <th> Vendido </th> <th>Preco </th>   </tr></thead>"
				+"<tbody>";

				var itensNota = notaVenda.itensNota;
			$.each(itensNota, function ( indice, row) {
												    
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



	_this.listagemNotaVenda = function listagemNotaVenda( notasVenda ){
		

		var notasVenda = jQuery.parseJSON( notasVenda );
		
		var HTML = "<table class = 'table' border = '1' >";
		HTML += "<tr> <th> DataNota </th> <th> Ponto Venda </th> <th> Data Pagamento</th>" ;
		HTML += "<th> Paga </th> <th> Selecionar </th></tr>" ;
		
		$.each(notasVenda, function ( indice, row ) {
			var paga = notasVenda[indice].paga ;
			var estado ;
			var pontoVenda = notasVenda[indice].pontoVenda ;
			if( paga  ){
				estado = "SIM";
			}
			else{
				estado = "NAO";
			}

			HTML += "<tr>";
			HTML +=" <td>"+notasVenda[indice].dataNota+"</td>";
			HTML += "<td>"+pontoVenda.nome+"</td>";
			HTML += "<td>"+notasVenda[indice].dataPgmt +"</td>";
			HTML += "<td>"+estado+"</td>";
			HTML += "<td> <input type='checkbox'id ='checkNota_"+indice+"' value = '"+notasVenda[indice].id+"''></td>";
			HTML += "</tr> ";

		});

		HTML += " </table>"

		return HTML ;
	}


	$("#dataNota").mask("99/99/9999");

	$("#listar").on("click", function( event ){
		event.preventDefault();
		$.ajax({
			url : "api/NotaVenda/PorData",
			type : "get",
			data : { dataNota : $("#dataNota").val() },
			success : function( resposta ){
				$("#listar").hide();
				$("#notasVenda").html(_this.listagemNotaVenda( resposta ) );
				$("#botoesListagem").show();
			},
			fail : function(){
				alert("Deu ruim ");
			}

		});
	});

	$("#visualizar").on("click", function( event){
		event.preventDefault();

		$.each( $("input[type='checkbox']"), function(indice, row){

				if( $("#checkNota_"+indice).is(":checked") ){
					 alert( $("#notaVenda_"+indice).val() );
				}
		      
		 });




	});






});