$(document).ready( function(){

	_this = this;

	_this.resultado = 0 ;

	$("#botaoEnvio").hide();


		$.ajax({ 
							url: "api/PontoVenda",
							type: "get",
							dataType: "html",
							success: function (resposta) {


								$("#pontosVenda").html(resposta);
							
							},
							error: function(){
								alert("Erro Ponto de Venda");
							}
			    });

	$("#botaoProcurar").on("click", function(event){

		event.preventDefault();
		var dataEPontoVenda = {	dataNota : $("#dataNota").val(), pontoVenda : $("#pontovenda").val() };
		
	$.ajax({
						url: "api/NotaVenda/DataEPonto",
						type: "get", 
						data: dataEPontoVenda,
						dataType: "json",
						success: function (notaVenda) {
							$("#notaVenda").html(_this.desenharNotaVenda(notaVenda));
							$("#botaoProcurar").hide();
							$("#botaoEnvio").show();
							
						},
						error: function(){
							alert("Nao funcionou ! ");
						}
		});


	});





	_this.desenharNotaVenda = function desenharNotaVenda( notaVenda ){
		console.log( notaVenda );
		var HTML =  notaVenda.pontoVenda.nome;
		HTML += "<br/>";
		HTML += "Data: "+notaVenda.dataNota;;
		HTML += "<br/>";
		


		 HTML += " <table class = 'table' border = '1' >	"+		
			"<thead> <tr> <th> Jornal </th> <th> Entregue</th> <th> Vendido </th> <th>Preco </th>   </tr></thead>"
				+"<tbody>";
		//console.log(HTML);	
				var itensNota = notaVenda.itensNota;
			$.each(itensNota, function ( indice, row) {
												    
													var precoCapa = itensNota[indice].precoCapa;
													var jornal = precoCapa.jornal;
													HTML +='<tr> <td>'+jornal.nome+'</td> ';
													HTML += '<td>'+itensNota[indice].qtdEntregue+'</td> ';
													HTML += ' <td> </td> ';
													HTML +=' <td>'+precoCapa.preco+'</td> </tr>';
											});

			HTML += "</tbody>";



			return HTML ;

	}




//PONTO VENDA



	$("#emitir").on("click", function(){

/*
			console.log(_this.desenharNotaVenda());
			HTML +="<br/>";		
			HTML +="Total da Venda: ";
			HTML +="<br/>";
			HTML +="Comissao";
			HTML +="<br/>";
			HTML +="A pagar:";

*/		var myWindow = window.open("notaVendaImpressao.html", "MsgWindow", "width=200,height=100");
		var HTML =  $("#notaVenda").html();
		HTML += "<br/>";
		HTML += "Total da Venda: ";
		HTML += "<br/>";
		HTML +="Comissao";
		HTML +="<br/>";
		HTML +="A pagar:";
		myWindow.document.write( HTML );
		//myWindow.document.getElementById( "conteudo" ).innerHTML =HTML;

	});





});















/*

	_this.esconderCampos = function esconderCampos(){

		$("#dataPagamento").hide();
		$("#itensNota").hide();
		$("#emitir").hide();
		$("#cancelar").hide();
	}();

*/


/*NOTA VENDA

$("#buscarNota").on("click", function (){
	$.ajax({ 
							url: "api/NotaVenda",
							type: "get",
							data: {
									pontovenda: $('#pontosVenda').val(),
									dataNota: $('#dataNota').val()
								},
							dataType: "json",
							success: function (resposta) {


								$("#notaVenda").val(resposta);
							
							},
							error: function(){
								alert("Erro Ponto de Venda");
							}
			    });
	$("#dataPagamento").apper();
	$("#itensNota").apper();
	$("#emitir").apper();
	$("#cancelar").apper();
*/