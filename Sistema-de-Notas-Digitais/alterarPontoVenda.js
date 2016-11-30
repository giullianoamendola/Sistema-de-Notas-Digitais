$(document).ready( function(){

	var _this = this ;

	_this.pontoVenda = null ;

	_this.idPontoVenda = function idPontoVenda(){
		var url   = window.location.href ;
		var pametroDaUrl = url.split("?")[1];
		var id = pametroDaUrl.split("=")[1];
		return id ;
	}


	_this.desenharEndereco = function desenharEndereco( endereco ){
		
	}


	$.ajax({
		url :'api/PontoVenda/ComId',
		type: 'get',
		data: { id :  _this.idPontoVenda() },
		success : function ( pontoVenda ){
			$("#pontoVenda").val( pontoVenda.nome );
			$("#id_pontoVenda").val( pontoVenda.id );
			$("#id_endereco").val(pontoVenda.endereco.id );
			$('#botaoAlterar').show();
		},
		error : function(){

		}
	});

	$.ajax({
		url :'api/Jornaleiro',
		type: 'get',
		success : function ( resposta ){
			var jornaleiros = JSON.parse( resposta );
			$("#jornaleiros").html( _this.desenharSelectJornaleiro( jornaleiros ) );
		},
		error : function(){

		}
	});
	

	_this.desenharSelectJornaleiro = function desenharSelectJornaleiro( jornaleiros ){
		var HTML = '';
		HTML += '<select id =jornaleiro>';
		$.each( jornaleiros , function( indice, row ){
			HTML += '<option value='+jornaleiros[indice].id+'>'+jornaleiros[indice].pessoa.nome+'</option>';
		});
		HTML += "</select>";

		return HTML ;
	}


		// var endereroJson = { logradouro : $("#logradouro").val(),
		// 				 complemento: $('#complemento').val(),
		// 				 numero : $("#numero").val(),
		// 				 id_endereco : $("#id_endereco").val(),
		// 				 bairro : {
		// 				 		id_bairro : $("#id_bairro"),
		// 				 		bairro: $("#bairro").val(),
		// 				 		cidade : {
		// 				 			id_cidade : $("#id_cidade").val(),
		// 				 			nome : $("#cidade").val(),
		// 				 			uf : $("#uf").val(),
		// 				 		}
		// 				 }
		// 				};


	$("#alterar").on("click",function( event ){
		
		event.preventDefault();
		var pontoVenda = { nome : $("#pontoVenda").val() ,
						 jornaleiro : $("#jornaleiro").val() ,
						  endereco : $("#id_endereco").val() ,
						  id : $("#id_pontoVenda").val() 
						   };
		console.log( pontoVenda );
		$.ajax({
			url:"api/PontoVenda",
			type:"put",
			data: pontoVenda,
			success : function(){
				alert( "Alterada ");
				location.href = "manterPontoVenda.html";

			},
			error : function(){

			}
		});
	});

	$("#cancelar").on("click",function( event ){
		
		event.preventDefault();

		 location.href = "listagemPontoVenda.html";
	});


});


