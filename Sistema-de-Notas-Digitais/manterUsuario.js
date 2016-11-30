$(document).ready( function(){

	var _this = this ;

	_this.Usuarios = null ;

	$("#botoesListagem").hide();

	_this.buscarUsuarios = function buscarUsuarios(){
		$.ajax({
			url : 'api/Usuario/Todos',
			type:'get',
			success: function( resposta ){
				_this.Usuarios = JSON.parse( resposta );
				$("#usuarios").html( _this.listagemUsuarios(_this.Usuarios) );
				$("#botoesListagem").show();
				_this.registrarCliqueEmLinhas();
			},
			error: function( jqXhr ){

			}
		});
	}();

	_this.listagemUsuarios = function listagemUsuarios( Usuarios ){
		
		var HTML = '' ;
		HTML += "<table class='table' border = '1'id= 'tabelaUsuarios'>";
		HTML += "<thead> <tr> <th> Id </th> <th> Nome </th> </tr> </thead>";
		HTML += "<tbody>";

		$.each( Usuarios, function( indice , row){
			HTML += "<tr>";
			HTML += "<td>"+Usuarios[indice].id +"</td>";
			HTML += "<td>"+Usuarios[indice].nome +"</td>";
			HTML += "</tr>";
		});

		HTML += "</tbody>";
		HTML += "</table>";

		return HTML ;
	}

	_this.registrarCliqueEmLinhas = function registrarCliqueEmLinhas() {
		$( '#tabelaUsuarios tbody tr' ).click( function linhaClick() {
			$( '#tabelaUsuarios tbody tr' ).removeClass( 'cor-linha' );
			$( this ).toggleClass( 'cor-linha' );
		} );
	}

	_this.idSelecionado = function idSelecionado() {
			return  $( '#tabelaUsuarios tbody tr.cor-linha :first' ).html() ;
	}

	$("#criarUsuario").on("click", function(){
		$(location).attr("href","criarUsuario.html" );
	});

	$("#alterar").on('click', function(){
		$(location).attr("href","alterarUsuario.html?id="+_this.idSelecionado());
	});

	$("#remover").on("click", function(){
		$.ajax({
			url :"api/Usuario",
			type:"delete",
			data : { id : _this.idSelecionado() },
			success: function(){
				alert( "Removido ! ");
			},
			error: function(){

			}
		});
	});
		
});