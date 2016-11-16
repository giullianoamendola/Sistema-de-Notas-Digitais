$(document).ready( function (){

	var _this = this ;

	_this.configurarMascaras = function configurarMascaras(){

	}

	$.ajax({
		url: "api/Jornal",
		type:"get",
		dataType: "json",
		success: function( resposta ){
			$("#jornais").html( _this.tabelaJornais( resposta ) );
			_this.buscarPrecosCapa();
		},
		error: function(){

		}

	});

	_this.buscarPrecosCapa = function buscarJornais(){

		$.ajax({
			url: "api/PrecoCapaPorData",
			type:"get",
			dataType:"json",
			success: function( resposta ){
				$("#data").html( "<h3>Data:"+resposta[0].data+"</h3>");
				$.each( resposta, function( indice, precoCapa ){

					//$("#precoCapa_"+indice).mask("?99.9?9");
					$("#precoCapa_"+indice).val( precoCapa.preco);
					console.log(precoCapa.id );
					$("#precoCapaId_"+indice).val( precoCapa.id );
					
				});
			},
			error: function( jqHxr ){
				alert("Nao funcionou ! ");
			}
		});

	}



	_this.tabelaJornais = function tabelaJornais( resposta ){

		var HTML = " <table class = 'table' border = '1' >	"+		
			"<thead> <tr> <th> Jornal </th> <th>Preco </th>   </tr></thead>"
				+"<tbody>";
		$.each(resposta, function ( indice, jornal) {
			//BOTAR ID NA LINHA 
			HTML +='<tr>  <td>'+jornal.nome+'</td> ';
			HTML += '<input type="hidden" id = "jornal_'+indice+'"value = "'+jornal.id+'"/>';
			HTML +=' <td><input type="text" id = "precoCapa_'+indice+'" value = ""/></td> </tr>';								
			HTML +='<input type="hidden" id = "precoCapaId_'+indice+'" />'
		});

		HTML += '</table>';

		return HTML;

	}
	
	_this.precosCapa =  function precosCapa(){	
		var precosCapa = [] ;
		var MAXITENSPORNOTA =5;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){

			var precoCapa = [] ;
			precoCapa[0] = $("#jornais #precoCapa_"+contagem).val();
			precoCapa[1] = $("#jornais #precoCapaId_"+contagem).val();

			precosCapa[contagem] = precoCapa ;
			
		}
			console.log( precosCapa );
		return precosCapa ;
	}

	_this.jornais =  function jornais(){	
		var jornais = [] ;
		var MAXITENSPORNOTA =5;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){

			jornais[contagem] = $("#jornais #jornal_"+contagem).val();

		}

		return jornais ;
	}

	$("#lancar").on("click", function( event ){
		event.preventDefault();
		
		$.ajax({
			url: "api/PrecoCapa",
			type:"post",
			dataType:"json",
			data: {
				precosCapa:	_this.precosCapa(),
				jornais: _this.jornais()
			},
			success: function( resposta ){
				alert(resposta);
			},
			error: function(jqXhr){
				alert("Nao funcionou ! "+ jqXhr.responseText );
			}

		});
	
	});









});





































/*
	

	
	_this.tabelaPrecoCapa = function tabelaPrecoCapa( resposta ){

	var HTML = '';

	 HTML = " <table class = 'table' border = '1' >	"+		
		"<thead> <tr> <th> Jornal </th> <th>Preco </th>   </tr></thead>"
			+"<tbody>";
		if( resposta == null ){

			_
		}
		$.each(resposta, function ( indice, precoCapa) {

												var jornal = precoCapa.jornal;
												HTML +='<tr> <td>'+jornal.nome+'</td> ';
												HTML += '<input type="hidden" id = "jornal_'+indice+'"value = "'+jornal.id+'"/>';
												HTML +=' <td><input type="text" id = "precoCapa_'+indice+'" value = "'+precoCapa.preco+'"/></td> </tr>';
												
										});

		HTML += "</tbody>";

		return HTML ;


	}

	$.ajax({
		url: "api/PrecoCapaPorData",
		type:"get",
		dataType:"json",
		success: function( resposta ){
			$("#precosCapa").html(_this.tabelaPrecoCapa( resposta ));
		},
		error: function(){
			alert("Nao funcionou ! ");
		}
	});

	_this.buscarJornais = function buscarJornais(){

	}

	_this.precosCapa =  function precosCapa(){	
		var precosCapa = [] ;
		var MAXITENSPORNOTA = 8 ;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){

			precosCapa[contagem] = $("#precosCapa #precoCapa_"+contagem).val();

		}

		return precosCapa ;
	}

		_this.jornais =  function jornais(){	
		var jornais = [] ;
		var MAXITENSPORNOTA = 8 ;
		var contagem = 0;
		for( contagem = 0; contagem < MAXITENSPORNOTA ; contagem = contagem + 1){

			jornais[contagem] = $("#precosCapa #jornal_"+contagem).val();

		}

		return jornais ;
	}

		


	$("#lancar").on("click", function( event ){
		event.preventDefault();
		
		$.ajax({
			url: "api/PrecoCapa",
			type:"post",
			dataType:"json",
			data: {

				precosCapa:	_this.precosCapa(),
				jornais: _this.jornais()
			},
			success: function( resposta ){
				alert("Precos Lancados "+resposta );
			},
			error: function(){
				alert("Nao funcionou ! ");
			}

		})
	
	});
*/
	
