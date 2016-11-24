$(document).ready( function(){

	_this = this;

	_this.resposta
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
	$("#dataNota").mask("99/99/9999");
	
	$("#botaoListagem").hide();
	$("#botaoMarcarTodos").hide();


		$.ajax({ 
				url: "api/PontoVenda",
				type: "get",
				dataType: "html",
				success: function (resposta) {


					$("#pontosVenda").html( _this.selectPontosVenda( resposta ) );
				
				},
				error: function(){
					alert("Erro Ponto de Venda");
				}
			    });

	$("#botaoProcurar").on("click", function(event){

		event.preventDefault();

		$.ajax({
			url : "api/NotaVenda/PorData",
			type : "get",
			data : { dataNota : $("#dataNota").val() },
			success : function( resposta ){

				_this.resposta = jQuery.parseJSON(resposta); ;

				$("#notasVenda").html(_this.listagemNotaVenda(_this.resposta ) );
				$("#botaoProcurar").hide();
				$("#botaoListagem").show();
				$("#botaoMarcarTodos").show();
				_this.registrarCliqueEmLinhas();
			},
			error : function( jqXhr ){
				alert(jqXhr);
			}

		});
			
	});



	_this.listagemNotaVenda = function listagemNotaVenda( notasVenda ){
		
		var HTML = "<table class = 'table' border = '1' id= 'tabelaNotaVenda' >";
		HTML += "<thead> <tr><th>Id</th> <th> DataNota </th> <th> Ponto Venda </th> <th> Data Pagamento</th>" ;
		HTML += "<th> Paga </th></tr> </thead>" ;
		
		$.each(notasVenda, function ( indice, row ) {
			var paga = notasVenda[indice].paga ;
			var estado ;
			var pontoVenda = notasVenda[indice].pontoVenda ;
			if( paga == 1 ){
				estado = "SIM";
			}
			else{
				estado = "NAO";
			}
			var itemNota = notasVenda[indice].itensNota;
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


	_this.desenharNotaVenda = function desenharNotaVenda( notaVenda ){
		
		//var notaVenda = jQuery.parseJSON( notaVenda );
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



//PONTO VENDA
	_this.registrarCliqueEmLinhas = function registrarCliqueEmLinhas() {
		$( '#tabelaNotaVenda tbody tr' ).click( function linhaClick() {
			//$( '#tabelaNotaVenda tbody tr' ).removeClass( 'cor-linha' );
			$( this ).toggleClass( 'cor-linha' );
		} );
	}

	_this.selecionados = function selecionados(){
		
		var id_selecionados = [];
		var contador = 0 ;
		var linha = null ;
		var obj = [] ;

 		$( '#tabelaNotaVenda tbody tr.cor-linha ' ).each( function( indice ){
			linha = $(this).children();
			obj =  $(linha[0]).text()
			id_selecionados[indice] = obj ;

		});
			
		return id_selecionados ;
	}

	_this.montarSelecionados = function montarSelecionados( id_selecionados ){ 

		var objetosSelecionados = [] ;
		var cont = 0 ;

		$.each( _this.resposta , function( i){
			
			$.each( id_selecionados , function( j ){
				if( _this.resposta[i].id == id_selecionados[j]){
					objetosSelecionados[cont] = _this.resposta[i];
					cont = cont + 1 ;
				}
			});

		
		});
		return objetosSelecionados ;
	}


	$("#emitir").on("click", function( event ){
		
		event.preventDefault();
		var id_selecionados = _this.selecionados() ;
		 var objetosSelecionados = _this.montarSelecionados( id_selecionados );
		
		 notasVenda = JSON.stringify( objetosSelecionados) ;
		 document.cookie = "notasVenda="+notasVenda;


		 location.href = "notaVendaImpressao.html";
		//$(location).attr("href","notaVendaImpressao.js");

	});

	$("#visualizar").on("click", function( event ){
		 event.preventDefault();

		 if( _this.selecionados() > 0 ){
		 	var id = _this.selecionados() ;
		 	var obj = [] ;
		 	$.each(_this.resposta , function( indice, row){
		 		if( _this.resposta[indice].id == id ){
		 			obj = _this.resposta[indice] ;
		 		}
		 	});

		 	$("#modalNotaVenda #notaVenda").html( _this.desenharNotaVenda( obj ) );
		 }

		 else{
		 	alert( "Selecionar Apenas uma linha ! ");
		 }


	});

	$("#botaoMarcarTodos").on('click', function( event ){
		 event.preventDefault();
		 $( '#tabelaNotaVenda tbody tr' ).toggleClass( 'cor-linha' );
	});





});
