$(document).ready( function(){

	var _this = this ;
	_this.idJornal = function idJornal(){
		var url   = window.location.href ;
		var pametroDaUrl = url.split("?")[1];
		var id = pametroDaUrl.split("=")[1];
		return id ;
	}

	$.ajax({
		url :'api/Jornal/ComId',
		type: 'get',
		data: { id :  _this.idJornal() },
		success : function ( resposta ){
			var jornal = JSON.parse( resposta );
			$("#id_jornal").val( jornal.id );
			$("#nome").val( jornal.nome );
		},
		error : function(){

		}
	});

	$("#alterar").on("click", function( event ){

		event.preventDefault();

		$.ajax({
			url:"api/Jornal",
			type:"put",
			data: { 
							id : $("#id_jornal").val(),
							nome: $("#nome").val()
						},
			success : function(){
				alert( "Alterado ! ");
			},
			error : function(){
				alert("Error !");
			}

		});
	});
});


