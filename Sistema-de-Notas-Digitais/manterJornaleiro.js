$(document).ready( function(){

	var _this = this ;

	_this.resposta = null ;

	$("#botoesListagem").hide();

	_this.buscarjornaleiros = function buscarjornaleiros(){
		$.ajax({
			url : 'api/Jornaleiro',
			type:'get',
			success: function( resposta ){
				_this.resposta = JSON.parse( resposta );
				$("#jornaleiros").html( _this.listagemjornaleiro( _this.resposta ) );
				$("#botoesListagem").show();
				_this.registrarCliqueEmLinhas();
			},
			error: function( jqXhr ){

			}
		});
	}();

	_this.listagemjornaleiro = function listagemjornaleiro( jornaleiros ){
		
		var HTML = '' ;
		HTML += "<table class='table' border = '1'id= 'tabelajornaleiro'>";
		HTML += "<thead> <tr> <th> Id </th> <th> Tipo Pagamento </th>";
		HTML += "<th> Nome </th> <th>Cpf</th> ";
		HTML +="<th>Rg</th> <th> Cnpj</th> <th> Nome Contato </tr> </thead>";
		HTML += "<tbody>";

		$.each( jornaleiros, function( indice , row){
			/*Ebonecar a tabela */
			HTML += "<tr>";
			HTML += "<td>"+jornaleiros[indice].id +"</td>";
			HTML += "<td>"+jornaleiros[indice].tipoPagamento +"</td>";
			HTML += "<td>"+_this.checarCampo( jornaleiros[indice].pessoa.nome )+"</td>";
			HTML += "<td>"+_this.checarCampo( jornaleiros[indice].pessoa.cpf ) +"</td>";
			HTML += "<td>"+_this.checarCampo( jornaleiros[indice].pessoa.rg) +"</td>";
			HTML += "<td>"+_this.checarCampo( jornaleiros[indice].pessoa.cnpj )+"</td>";
			HTML += "<td>"+_this.checarCampo( jornaleiros[indice].pessoa.nomeContato ) +"</td>";
			HTML += "</tr>";
		
		});

		HTML += "</tbody>";
		HTML += "</table>";

		return HTML ;
	}

	_this.checarCampo = function checarCampo( campo ){

		if( campo == undefined ){
			return "-";
		}

		return campo ;
	}

	_this.registrarCliqueEmLinhas = function registrarCliqueEmLinhas() {
		$( '#tabelajornaleiro tbody tr' ).click( function linhaClick() {
			$( '#tabelajornaleiro tbody tr' ).removeClass( 'cor-linha' );
			$( this ).toggleClass( 'cor-linha' );
		} );
	}

	_this.idSelecionado = function idSelecionado() {
		return  $( '#tabelajornaleiro tbody tr.cor-linha :first' ).html() ;
	}

	$("#criarJornaleiro").on("click", function(){
		$(location).attr("href","criarJornaleiro.html" );
	});

	$("#alterar").on('click', function(){
		$(location).attr("href","alterarJornaleiro.html?id="+_this.idSelecionado());
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