$(document).ready( function(){

	var _this = this ;
	_this.roteiro = null ;
	_this.notasVenda = null ; 

	$.ajax({
		url :"api/NotaVenda/DoDia",
		type : "get",
		success: function( resposta ){
			_this.notasVenda = JSON.parse( resposta );
			$("#tabelaPontoVenda").html( _this.desenharPontoVenda( _this.notasVenda ) );
			_this.registrarCliqueEmLinhas();
		},
		error: function( jqXhr ){
			alert( jqXhr );
		}
	});

	_this.desenharPontoVenda = function desenharPontoVenda( notasVenda ){
		var HTML = "<table class='table' id ='pontosVenda' border='1'>";
		HTML += "<thead> <tr> <th>Bairro</th> <th> Ponto de Venda </th></tr> </thead>";
		HTML += "<tbody>";
		$.each( notasVenda, function( indice , row ){
			var pontoVenda = notasVenda[indice].pontoVenda;
			var bairro = pontoVenda.endereco.bairro ;
			HTML += "<tr>";
			HTML += "<td>"+pontoVenda.nome+"</td>";
			HTML += " <td>"+bairro.nome+"</td>";
			HTML += "</tr>";
		});
		HTML += "</tbody>";
		HTML += "</table>";
		return HTML ;
	}

	_this.registrarCliqueEmLinhas = function registrarCliqueEmLinhas() {
		$( '#tabelaPontoVenda tbody tr' ).click( function linhaClick() {
			$( this ).toggleClass( 'cor-linha' );
		} );
	}

	_this.selecionados = function selecionados(){
		
		var id_selecionados = [];
		var contador = 0 ;
		var linha = null ;
		var obj = [] ;

 		$( '#tabelaPontoVenda tbody tr.cor-linha ' ).each( function( indice ){
			linha = $(this).children();
			obj =  $(linha[0]).text();
			id_selecionados[indice] = obj ;

		});
			
		return id_selecionados ;
	}

	_this.montarSelecionados = function montarSelecionados( id_selecionados ){ 

		var objetosSelecionados = [] ;
		var cont = 0 ;

		$.each( _this.notasVenda , function( i){
			
			$.each( id_selecionados , function( j ){
				if( _this.notasVenda[i].pontoVenda.nome == id_selecionados[j]){
					objetosSelecionados[cont] = _this.notasVenda[i];
					cont = cont + 1 ;
				}
			});

		
		});
		return objetosSelecionados ;
	}

	$("#botaoMarcarTodos").on('click', function( event ){
		 event.preventDefault();
		 $( '#tabelaPontoVenda tbody tr' ).toggleClass( 'cor-linha' );
	});

	$("#emitir").on("click", function(event ){
		event.preventDefault();
		var id_selecionados = _this.selecionados() ;
		var objetosSelecionados = _this.montarSelecionados( id_selecionados );
		var roteiro = [ $("#entregador").val(), objetosSelecionados ];
		roteiro = JSON.stringify( roteiro ) ;
		localStorage.setItem("roteiro", roteiro);
		location.href = "roteiroImpressao.html" ;
	});

});