$(document).ready( function(){
	
	var _this = this ;

	$("#pessoaFisica").hide();
	$("#pessoaJuridica").hide();	

	_this.criarJornaleiro = function criarJornaleiro(){
		var jornaleiro = { 
							nome : $("#nome").val() ,
							email : $("#email").val() ,
							telefone : $("#telefone").val(),
							rg : $("#rg").val(),
							cpf : $("#cpf").val(),
							cnpj : $("#cnpj").val(),
							nomeContato : $("#nomeContato").val(),
							tipoPagamento : $("#tipoPagamento").val(),
							tipoPessoa : $("#tipoPessoa").val()

						}
		$.ajax({
			url :"api/Jornaleiro",
			type: "post",
			data: jornaleiro,
			success : function( resposta ){
				alert( "Jornaleiro Criado !");
				location.href("manterJornaleiro.html");
			},
			error : function(){

			}
		});
	}

	$("#criar").on("click", function( event ){
		event.preventDefault();
		_this.criarJornaleiro();
	});

	$("#tipoPessoa").change( function(){

		if( $("#tipoPessoa").val() == 1 ){
			$("#pessoaFisica").show();
			$("#pessoaJuridica").hide();
		}

		if( $("#tipoPessoa").val() == 2 ){
			$("#pessoaFisica").hide();
			$("#pessoaJuridica").show();
		}


		
	});


});