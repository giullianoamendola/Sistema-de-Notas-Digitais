$(document).ready( function (){

	var _this = this ;
	_this.precoCapa = null;
	_this.numeroRegistros = null ;
	$("#data").mask("99/99/9999");

	_this.configurarMascaras = function configurarMascaras(){

	}

	_this.buscarJornais = function buscarJornais(){
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
	}();





	_this.inserirPrecosNaTabela = function inserirPrecosNaTabela( precoCapa ){

		$.each( precoCapa, function( indice, precoCapa ){

					$("#precoCapa_"+indice).maskMoney();
					$("#precoCapa_"+indice).val( precoCapa.preco);
					$("#precoCapa_"+indice).maskMoney();
					$("#precoCapaId_"+indice).val( precoCapa.id );
					
		});
	}

	_this.setarData = function setarData( data ){
		$("#data").val( data ); 
	}
	_this.buscarPrecosCapa = function buscarPrecosCapa(){

		$.ajax({
			url: "api/PrecoCapaPorData",
			type:"get",
			dataType:"json",
			success: function( resposta ){
				_this.setarData( resposta[0].data );
				_this.inserirPrecosNaTabela( resposta );
			},
			error: function( jqHxr ){
				alert("Preco de Capa nao encontrado ");
			}
		});

	}



	_this.tabelaJornais = function tabelaJornais( resposta ){

		var HTML = " <table class = 'table' border = '1' >	"+		
			"<thead> <tr> <th> Jornal </th> <th>Preco </th>   </tr></thead>"
				+"<tbody>";
		$.each(resposta, function ( indice, jornal) {

			HTML +='<tr>  <td>'+jornal.nome+'</td> ';
			HTML += '<input type="hidden" id = "jornal_'+indice+'"value = "'+jornal.id+'"/>';
			HTML +=' <td><input type="text" id = "precoCapa_'+indice+'" value = ""/></td> </tr>';								
			HTML +='<input type="hidden" id = "precoCapaId_'+indice+'" />'
			_this.numeroRegistros = indice ;
		});

		_this.numeroRegistros = _this.numeroRegistros + 1; 
		HTML += '</table>';

		return HTML;

	}
	
	_this.precosCapa =  function precosCapa( ){	
		var precosCapa = [] ;
		var contagem = 0;
		for( contagem = 0; contagem < _this.numeroRegistros ; contagem = contagem + 1){

			var precoCapa = { 
							jornal : $("#jornais #jornal_"+contagem).val(),
							preco : $("#jornais #precoCapa_"+contagem).val(),
							id : $("#jornais #precoCapaId_"+contagem).val()
						};

			precosCapa[contagem] = precoCapa ;
			
		}

		return precosCapa ;
	}

	$("#lancar").on("click", function( event ){
		event.preventDefault();
		
		$.ajax({
			url: "api/PrecoCapa",
			type:"post",
			dataType:"json",
			data: {
				precosCapa:	_this.precosCapa()
			},
			success: function( resposta ){
				alert(resposta);
			},
			error: function(jqXhr){
				//alert("Erro : ! "+ jqXhr.responseText );
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
	
