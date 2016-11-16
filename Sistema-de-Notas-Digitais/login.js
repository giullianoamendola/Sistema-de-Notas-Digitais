$(document).ready( function(){
	
	$("#logar").on("click", function( event ){
		event.preventDefault();
		$.ajax({
			url:"api/Login",
			type: "post",
			data:{
				login: $("#login").val(),
				senha: $("#senha").val()
			},
			success: function( resposta ){

			},
			error: function(){

			}
		});
	});
});