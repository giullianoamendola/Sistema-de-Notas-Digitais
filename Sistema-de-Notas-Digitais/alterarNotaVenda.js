$(document).ready( function(){

	var _this = this ;

	//$("#notaVenda").hide();
	$("#botaoAlterar").hide();
	$("#dataNota").mask("99/99/9999");
	$("#dataPagamento").mask("99/99/9999");

	_this.idNotaVenda = function idNotaVenda(){
		var url   = window.location.href ;
		var pametroDaUrl = url.split("?")[1];
		var id = pametroDaUrl.split("=")[1];
		return id ;
	}

	_this.desenharItensNota = function desenharItensNota( itensNota ){

		 var HTML = " <table class = 'table' border = '1'  id = 'tabelaItensNota '>	"+		
			"<thead> <tr> <th> Jornal </th> <th> Entregue</th> <th> Vendido </th> <th>Preco </th> <th> Id</th>  </tr></thead>"
				+"<tbody>";
			$.each(itensNota, function ( indice, row ) {
					var precoCapa = itensNota[indice].precoCapa;
					var jornal = precoCapa.jornal;
					HTML +='<tr>';
					HTML +='<td>'+jornal.nome+'</td> ';
					HTML += '<td><input type="text" id = "qtdEntregue_'+indice+'"value="'+itensNota[indice].qtdEntregue+'"/></td>'; 
					HTML += '<td><input  type="text" id = "qtdVendido_'+indice+'"value="'+itensNota[indice].qtdVendido+'"/></td>'; 
					HTML +=' <td>'+precoCapa.preco+'</td> ';
					HTML += '<td><input  type="text" id = "idItemNota_'+indice+'"value="'+itensNota[indice].id+' "readOnly/></td>';
					HTML += '</tr>';
			});

			HTML += "</tbody> </table>";


			console.log( $("#tabelaItensNota tbody tr #idItemNota_0").val() );
			
			$("#notaVenda #itensNota").html( HTML ) ;

	}

	_this.desenharNotaVenda = function desenharNotaVenda( notaVenda ){
		var notaVenda = jQuery.parseJSON( notaVenda );
		//console.log( notaVenda.itensNota[0].precoCapa.jornal.nome );
		$("#pontoVenda").html("<h3>Ponto de Venda: "+notaVenda.pontoVenda.nome+"</h3>" );
		$("#dataNota").html("<h3>Data da Nota: "+notaVenda.dataNota+"</h3>" );	
		$("#dataPagamento").val( notaVenda.dataPgmt );
		$("#id_notavenda").val(  _this.idNotaVenda() );
		_this.desenharItensNota( notaVenda.itensNota );
	}


	$.ajax({
		url :'api/NotaVenda/ComId',
		type: 'get',
		data: { id :  _this.idNotaVenda() },
		success : function ( notaVenda ){
			_this.desenharNotaVenda( notaVenda );
			$('#botaoAlterar').show();
		},
		error : function(){

		}
	});

	_this.itensNota = function itensNota(){
		
		var itensNota = [];
		 var itemNota = [] ;
		for (var contador = 0 ; contador < 5 ; contador = contador + 1 ){
		    console.log( $("#idItemNota_"+contador ).val() );
		     itensNota[contador] = [  $("#qtdEntregue_"+contador).val(), $("#qtdVendido_"+contador).val() , $("#idItemNota_"+contador).val() ];
		}

		return itensNota ;
	}


	$("#alterar").on("click",function( event ){
		
		event.preventDefault();

		$.ajax({
			url:"api/NotaVenda",
			type:"put",
			data: {
					dataPgmt : $("#dataPagamento").val(),
					itensNota: _this.itensNota(),
					id : _this.idNotaVenda()
			},
			success : function(){
				alert( "Alterada ");
			},
			error : function(){

			}
		});
	});

	$("#cancelar").on("click",function( event ){
		
		event.preventDefault();

		 location.href = "listagemNotaVenda.html";
	});


});


