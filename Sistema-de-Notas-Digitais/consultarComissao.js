$(document).ready( function(){

	var _this = this ;

	$("#dataNota").mask("99/99/9999");
	$("#dataPagamento").mask("99/99/9999");
	$("#resultadoDasVendas").hide();

	_this.selectPontosVenda = function selectPontosVenda( pontoVenda ){
		var pontoVenda = jQuery.parseJSON( pontoVenda );
		var HTML = '<select class ="select col-md-2" id = "pontoVenda">';

		$.each(pontoVenda , function ( indice, row) {
			HTML += '<option value ="'+row.id+'">'+row.nome+'</option>';

		});

		HTML += '</select>';

		return HTML ;
	}

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


	$("#procurar").on("click", function(event){

		event.preventDefault();
		var dataEPontoVenda = {	dataNota : $("#dataNota").val(), pontoVenda : $("#pontoVenda").val() };
		
		$.ajax({
						url: "api/NotaVenda/DataEPonto",
						type: "get", 
						data: dataEPontoVenda,
						dataType: "json",
						success: function (notaVenda) {
							$("#notaVenda").html(_this.desenharNotaVenda(notaVenda));
							$("#formconsultarComissao").hide();
							$("#finalizarConsulta").show();
							
						},
						error: function(){
							alert("Nao funcionou ! ");
						}
		});


	});

	_this.desenharNotaVenda = function desenharNotaVenda( notaVenda ){
		
		$("#dataPagamento").val( notaVenda.dataPgmt );

		var HTML =  notaVenda.pontoVenda.nome;
		HTML += "<br/>";
		HTML += "Data: "+notaVenda.dataNota;
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
				HTML += ' <td>'+itensNota[indice].qtdVendido+' </td> ';
				HTML +=' <td>'+precoCapa.preco+'</td> </tr>';

			});

			HTML += "</tbody>";

			_this.mostrarRegistroDasVendas( itensNota , notaVenda.comissao );

			return HTML ;

	}

	_this.mostrarRegistroDasVendas = function mostrarRegistroDasVendas( itensNota , comissao ){
		
		var totalVenda = 0 ;
		var valorDoPagamento = 0;

		$.each( itensNota, function( indice, row  ){
			var precoCapa = row.precoCapa ;
			totalVenda = totalVenda + ( precoCapa.preco * row.qtdVendido ) ;
		});

		$("#resultadoDasVendas").show();

		if( comissao == ( totalVenda * 0.15) ){
			$("#comissao").val( comissao );
		}

		valorDoPagamento = totalVenda - comissao ;

		$("#totalVenda").val( totalVenda );
		$("#valorDoPagamento").val( valorDoPagamento );
	}

	$("#finalizarConsulta").on( "click" ,function( event ){

			event.preventDefault();
   			location.reload();
    
     });



});