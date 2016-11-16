$(document).ready( function(){

	var _this = this ;

	$("#dataNota").mask("99/99/9999");
	
	$("#registrar").hide();
	$("#divPontosVenda").hide();

	_this.selectPontosVenda = function selectPontosVenda( notaVenda ){
		var notaVenda = jQuery.parseJSON( notaVenda );
		var HTML = '<select class ="select col-md-2" id = "pontoVenda">';

		$.each(notaVenda , function ( indice, row) {
			var pontoVenda = notaVenda[indice].pontoVenda;
			HTML += '<option value ="'+pontoVenda.id+'">'+pontoVenda.nome+'</option>';

		});

		HTML += '</select>';

		return HTML ;
	}



	$("#procurar").on("click", function( event ){
		event.preventDefault();
		//var dataNota = $("#dataNota").val();
		$.ajax({
			url: "api/NotaVenda/PorDataENaoPaga",
			data: { dataNota : $("#dataNota").val() },
			type: "get",
			
			success: function( resposta ){
				$("#divPontosVenda").show();
				$("#registrar").show();
				$("#procurar").hide();
				$("#pontosVenda").html( _this.selectPontosVenda( resposta ) );
			
			},
			error: function(){
				alert("Erro !");
			}
		});

	});

	$("#registrar").on("click", function(){
		$.ajax({
			url: "api/NotaVenda/RegistrarPagamento",
			type: "put",
			data: {
					pontoVenda : $("#pontoVenda").val(),
					dataNota : $("#dataNota").val()
				},
			success: function( resposta ){
				alert("Pagamento Registrado ");
			},
			error: function(){
				alert("Nao funcionou ");
			}
		});
	});

});