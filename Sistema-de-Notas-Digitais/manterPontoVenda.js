$(document).ready( function(){

	var _this = this ;

	_this.resposta = null ;

	$("#botoesListagem").hide();

	_this.buscarPontosVenda = function buscarPontosVenda(){
		$.ajax({
			url : 'api/PontoVenda',
			type:'get',
			success: function( resposta ){
				_this.resposta = JSON.parse( resposta );
				$("#pontosVenda").html( _this.listagemPontosVenda( _this.resposta ) );
				$("#botoesListagem").show();
				_this.registrarCliqueEmLinhas();
			},
			error: function( jqXhr ){

			}
		});
	}();

	_this.listagemPontosVenda = function listagemPontosVenda( pontosVenda ){
		console.log( pontosVenda );
		var HTML = '' ;
		HTML += "<table class='table' border = '1'id= 'tabelaPontoVenda'>";
		HTML += "<thead> <tr> <th> Id </th> <th> Nome </th>";
		HTML += "<th> Jornaleiro </th> <th>Logradouro</th> ";
		HTML +="<th>Complemento</th> <th> Numero</th> <th> Bairro</th> <th> Cidade</th> </tr> </thead>";
		HTML += "<tbody>";

		$.each( pontosVenda, function( indice , row){

			/*Ebonecar a tabela */
			HTML += "<tr>";
			HTML += "<td>"+pontosVenda[indice].id +"</td>";
			HTML += "<td>"+pontosVenda[indice].nome +"</td>";
			HTML += "<td>"+pontosVenda[indice].jornaleiro.pessoa.nome +"</td>";
			HTML += "<td>"+pontosVenda[indice].endereco.logradouro +"</td>";
			HTML += "<td>"+pontosVenda[indice].endereco.complemento +"</td>";
			HTML += "<td>"+pontosVenda[indice].endereco.numero +"</td>";
			HTML += "<td>"+pontosVenda[indice].endereco.bairro.nome +"</td>";
			HTML += "<td>"+pontosVenda[indice].endereco.bairro.cidade.nome +"</td>";
			HTML += "</tr>";
		
		});

		HTML += "</tbody>";
		HTML += "</table>";

		return HTML ;
	}

	_this.registrarCliqueEmLinhas = function registrarCliqueEmLinhas() {
		$( '#tabelaPontoVenda tbody tr' ).click( function linhaClick() {
			$( '#tabelaPontoVenda tbody tr' ).removeClass( 'cor-linha' );
			$( this ).toggleClass( 'cor-linha' );
		} );
	}

	_this.idSelecionado = function idSelecionado() {
		return  $( '#tabelaPontoVenda tbody tr.cor-linha :first' ).html() ;
	}

	$("#criar").on("click", function(){
		$(location).attr("href","criarPontoVenda.html" );
	});

	$("#alterar").on('click', function(){
		$(location).attr("href","alterarPontoVenda.html?id="+_this.idSelecionado());
	});

	$("#remover").on("click", function(){
		$.ajax({
			url :"api/Jornaleiro",
			type:"delete",
			data : { id : _this.idSelecionado() },
			success: function(){
				alert( "Removido ! ");
			},
			error: function(jqXhr){
				alert("Nao foi possivel excluir o item !"+jqXhr);
			}
		});
	});
		
});