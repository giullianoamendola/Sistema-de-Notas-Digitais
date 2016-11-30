$(document).ready( function(){
	
	$("#logar").on("click", function( event ){
		event.preventDefault();

		$.ajax({
			url:"api/Usuario",
			type: "get",
			data:{
				login: $("#login").val(),
				senha: $("#senha").val()
			},
			success: function( resposta ){
				if( resposta == 'ADM' ){
					location.href = "index.html";
				}
				if( resposta == 'jornaleiro' ){
					location.href = "indexJornaleiro.html";
				}	
			},
			error: function( jqXhr ){
				alert( "Usuario ou senha inexistentes"+jqXhr );
			}
		});
	});
});