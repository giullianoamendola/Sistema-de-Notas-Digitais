$(document).ready( function(){
	
	var _this = this ;

	_this.criarJornal = function criarJornal(){
		$.ajax({
			url :"api/Jornal",
			type: "post",
			data: { nome : $("#nome").val() },
			success : function( resposta ){
				alert( "Jornal Criado !");
				$(location).attr("href","manterJornal.html");
			},
			error : function(){

			}
		});
	}

	$("#criar").on("click", function( event ){
		event.preventDefault();
		_this.criarJornal();
	});
});