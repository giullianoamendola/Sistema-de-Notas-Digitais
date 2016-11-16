$(document).ready( function(){

	var _this = this ;

	$("#botoesListagem").hide();
	$("#dataNota").mask("99/99/9999");

	_this.desenharNotaVenda = function desenharNotaVenda( notaVenda ){
		var notaVenda = jQuery.parseJSON( notaVenda );
		var HTML =  notaVenda.pontoVenda.nome;
		HTML += "<br/>";
		HTML += "Data: "+notaVenda.dataNota;
		HTML += "<br/>";
		HTML += "Data Pagamento: "+notaVenda.dataPgmt;
		HTML += "<br/>";


		HTML += " <table class = 'table' border = '1' id = 'tabelaItensNota'>	"+		
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

		HTML +="Comissao:"+notaVenda.comissao;
		HTML +="</br>";





			return HTML ;

	}



	_this.listagemNotaVenda = function listagemNotaVenda( notasVenda ){
		

		var notasVenda = jQuery.parseJSON( notasVenda );
		
		var HTML = "<table class = 'table' border = '1' id= 'tabelaNotaVenda' >";
		HTML += "<thead> <tr><th>Id</th> <th> DataNota </th> <th> Ponto Venda </th> <th> Data Pagamento</th>" ;
		HTML += "<th> Paga </th></tr> </thead>" ;
		
		$.each(notasVenda, function ( indice, row ) {
			var paga = notasVenda[indice].paga ;
			var estado ;
			var pontoVenda = notasVenda[indice].pontoVenda ;
			alert( notasVenda[indice].paga );
			if( paga ){
				estado = "SIM";
			}
			else{
				estado = "NAO";
			}

			HTML += "<tbody><tr>";
			HTML +=" <td>"+notasVenda[indice].id+"</td>";
			HTML +=" <td>"+notasVenda[indice].dataNota+"</td>";
			HTML += "<td>"+pontoVenda.nome+"</td>";
			HTML += "<td>"+notasVenda[indice].dataPgmt +"</td>";
			HTML += "<td>"+estado+"</td>";
			HTML += "</tr> </tbody>";

		});

		HTML += " </table>"

		return HTML ;
	}

	_this.alterarNotaVenda = function alterarNotaVenda( notaVenda ){
		
		var notaVenda = jQuery.parseJSON( notaVenda );
		var HTML = "<table class 'table' border = '1' >";
		HTML += "<thead><tr> <th> Jornal </th> <th> Preco Capa </th> <th> Entregue </th>";
		HTML += "<th>Vendido</th> </tr> </thead> ";
		HTML += "<tbody>";
		var itensNota = notaVenda.itensNota;
		$.each(itensNota , function ( indice, row ){
			var precoCapa = itensNota[indice].precoCapa;
			var jornal = precoCapa.jornal;
			HTML += "<tr>";
			HTML += "<td>"+jornal.nome+"</td>";
			HTML += "<td>"+precoCapa.preco+"</td>";
			HTML += "<td> <input type='text' id = 'entregue_"+indice+"'value= '"+itensNota[indice].qtdEntregue+"'></td>";
			HTML += "<td> <input type='text' id = 'vendido_"+indice+"'value= '"+itensNota[indice].qtdVendido+"'></td>";
			HTML += "</tr>";
		});

		HTML += "</tbody>";
		HTML += "</table>";

		return HTML ;
	}




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
				_this.registrarCliqueEmLinhas();
			},
			fail : function(){
				alert("Deu ruim ");
			}

		});
	});

		_this.registrarCliqueEmLinhas = function registrarCliqueEmLinhas() {
			$( '#tabelaNotaVenda tbody tr' ).click( function linhaClick() {
				$( '#tabelaNotaVenda tbody tr' ).removeClass( 'cor-linha' );
				$( this ).toggleClass( 'cor-linha' );
			} );
		};

		_this.idSelecionado = function idSelecionado() {
			return  parseInt($( '#tabelaNotaVenda tbody tr.cor-linha :first' ).html()) ;
		};
		




	$("#visualizar").on("click", function( event ){
		event.preventDefault();
		var notaVenda = '';
		$.ajax({
			url :'api/NotaVenda/ComId',
			type: 'get',
			data: { id :  _this.idSelecionado() },
			success : function ( notaVenda ){
				$("#notaVenda").html(  _this.desenharNotaVenda( notaVenda ) );
			},
			error : function(){

			}
		});


	});

	$('#alterar').on('click', function( event ){
		event.preventDefault();
		var notaVenda = '';
		$.ajax({
			url :'api/NotaVenda/ComId',
			type: 'get',
			data: { id :  _this.idSelecionado() },
			success : function ( notaVenda ){
				$("#notaVenda").html(  _this.alterarNotaVenda( notaVenda ) );
			},
			error : function(){

			}
		});

	});

	$("#excluir").on('click', function( event ){
		event.preventDefault();
	});


	





});