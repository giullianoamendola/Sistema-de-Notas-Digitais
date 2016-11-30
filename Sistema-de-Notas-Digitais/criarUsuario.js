$(document).ready( function(){
	
	var _this = this ;

	_this.criarUsuario = function criarUsuario(){
		$.ajax({
			url :"api/Usuario",
			type: "post",
			data: { 
					nome : $("#nome").val(),
					login : $("#login").val(),
					senha : $("#senha").val(),
			},
			success : function( resposta ){
				alert( "Usuario Criado !");
				$(location).attr("href","manterUsuario.html");
			},
			error : function(){

			}
		});
	}

	$("#criar").on("click", function( event ){
		event.preventDefault();
		_this.criarUsuario();
	});
});