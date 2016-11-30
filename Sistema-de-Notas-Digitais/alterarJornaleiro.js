$(document).ready( function(){

	var _this = this ;

	$("#pessoaFisica").hide();
	$("#pessoaJuridica").hide();

	_this.idJornaleiro = function idJornaleiro(){
		var url   = window.location.href ;
		var pametroDaUrl = url.split("?")[1];
		var id = pametroDaUrl.split("=")[1];
		return id ;
	}

	$.ajax({
		url :'api/Jornaleiro/ComId',
		type: 'get',
		data: { id :  _this.idJornaleiro() },
		success : function ( resposta ){
			var jornaleiro = JSON.parse( resposta );
			$("#id_jornaleiro").val( jornaleiro.id );
			$("#id_pessoa").val( jornaleiro.pessoa.id );
			$("#nome").val( jornaleiro.pessoa.nome );
			$("#email").val( jornaleiro.pessoa.email );
			$("#telefone").val( jornaleiro.pessoa.telefone );
			if( jornaleiro.tipoPessoa  == "fisica"){
				$("#tipoPessoa").val( 1 );
				$("#pessoaFisica").show();
			}
			else{
				$("#tipoPessoa").val( 2 );
				$("#pessoaJuridica").show();
				$("#cnpj").val(jornaleiro.pessoa.cnpj );
				$("#nomeContato").val(jornaleiro.pessoa.nomeContato );
			}

			$("#tipoPagamento").val( jornaleiro.tipoPagamento );

		},
		error : function(){

		}
	});

	$("#alterar").on("click", function( event ){

		event.preventDefault();
		var jornaleiro = { 
							id: $("#id_jornaleiro").val(),
							nome : $("#nome").val() ,
							email : $("#email").val() ,
							telefone : $("#telefone").val(),
							rg : $("#rg").val(),
							cpf : $("#cpf").val(),
							cnpj : $("#cnpj").val(),
							nomeContato : $("#nomeContato").val(),
							tipoPagamento : $("#tipoPagamento").val(),
							tipoPessoa : $("#tipoPessoa").val(),
							id_pessoa : $("#id_pessoa").val()

						}
		$.ajax({
			url:"api/Jornaleiro",
			type:"put",
			data: jornaleiro,
			success : function(){
				alert( "Alterado ! ");
			},
			error : function(){
				alert("Error !");
			}

		});
	});
});


