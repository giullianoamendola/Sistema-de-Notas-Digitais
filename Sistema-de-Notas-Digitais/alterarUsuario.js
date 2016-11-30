$(document).ready( function(){

	var _this = this ;
	_this.idUsuario = function idUsuario(){
		var url   = window.location.href ;
		var pametroDaUrl = url.split("?")[1];
		var id = pametroDaUrl.split("=")[1];
		return id ;
	}

	$.ajax({
		url :'api/Usuario/ComId',
		type: 'get',
		data: { id :  _this.idUsuario() },
		success : function ( resposta ){
			var Usuario = JSON.parse( resposta );
			$("#id_Usuario").val( Usuario.id );
			$("#nome").val( Usuario.nome );
			$('#login').val( Usuario.login );
			$('#senha').val( Usuario.senha );
		},
		error : function(){
			alert("Error !");
		}
	});

	$("#alterar").on("click", function( event ){

		event.preventDefault();

		$.ajax({
			url:"api/Usuario",
			type:"put",
			data: { 
					id : $("#id_Usuario").val(),
					nome: $("#nome").val(),
					login: $("#login").val(),
					senha : $("#senha").val()
				},
			success : function(){
				alert( "Alterado ! ");
				$(location).attr("href","manterUsuario.html" );
			},
			error : function(){
				alert("Error !");
			}

		});
	});
});


