$(document).ready( function(){

	var _this = this ;

	_this.jornais = null ;

	$("#botoesListagem").hide();

	_this.buscarJornais = function buscarJornais(){
		$.ajax({
			url : 'api/Jornal',
			type:'get',
			success: function( resposta ){
				_this.jornais = JSON.parse( resposta );
				$("#jornais").html( _this.listagemJornais(_this.jornais) );
				$("#botoesListagem").show();
				_this.registrarCliqueEmLinhas();
			},
			error: function( jqXhr ){

			}
		});
	}();

	_this.listagemJornais = function listagemJornais( jornais ){
		
		var HTML = '' ;
		HTML += "<table class='table' border = '1'id= 'tabelaJornais'>";
		HTML += "<thead> <tr> <th> Id </th> <th> Nome </th> </tr> </thead>";
		HTML += "<tbody>";

		$.each( jornais, function( indice , row){
			HTML += "<tr>";
			HTML += "<td>"+jornais[indice].id +"</td>";
			HTML += "<td>"+jornais[indice].nome +"</td>";
			HTML += "</tr>";
		});

		HTML += "</tbody>";
		HTML += "</table>";

		return HTML ;
	}

	_this.registrarCliqueEmLinhas = function registrarCliqueEmLinhas() {
		$( '#tabelaJornais tbody tr' ).click( function linhaClick() {
			$( '#tabelaJornais tbody tr' ).removeClass( 'cor-linha' );
			$( this ).toggleClass( 'cor-linha' );
		} );
	}

	_this.idSelecionado = function idSelecionado() {
		return  $( '#tabelaJornais tbody tr.cor-linha :first' ).html() ;
	}

	$("#criarJornal").on("click", function(){
		$(location).attr("href","criarJornal.html" );
	});

	$("#alterar").on('click', function(){
		$(location).attr("href","alterarJornal.html?id="+_this.idSelecionado());
	});

	$("#remover").on("click", function(){
		$.ajax({
			url :"api/Jornal",
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