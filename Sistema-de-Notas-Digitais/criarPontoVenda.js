$(document).ready( function(){

	var _this = this ;

	_this.bairros = null ;
	_this.cidades = null ;
	_this.jornaleiros = null ;

	_this.buscarBairros = function buscarBairros(){

		$.ajax({
			url :"api/Bairro",
			type:"get",
			success: function( resposta ){
				_this.bairros = JSON.parse( resposta );
				$("#bairros").html( _this.desenharSelectBairro( _this.bairros ) );
			},
			error: function( jqXhr ){
	             alert( jqXhr );
			}
		});

	}();


	_this.buscarJornaleiros = function buscarJornaleiros(){

		$.ajax({
			url :"api/Jornaleiro",
			type:"get",
			success: function( resposta ){
				_this.jornaleiros = JSON.parse( resposta );
				$("#jornaleiros").html( _this.desenharSelectJornaleiro( _this.jornaleiros ) );
			},
			error: function( jqXhr ){
	             alert( jqXhr );
			}
		});
	
	}();

	_this.buscarCidades = function buscarCidades(){
		
		$.ajax({
			url :"api/Cidade",
			type:"get",
			success: function( resposta ){
				_this.cidades = JSON.parse( resposta );
				$("#formBairro #cidades").html( _this.desenharSelectCidade( _this.cidades ) );
			},
			error: function( jqXhr ){
	             alert( jqXhr );
			}
		});

	}


	_this.desenharSelectBairro = function desenharSelectBairro( bairros ){
		
		var HTML = "<select id='bairro' class='col-md-2' >";

		$.each(bairros, function( indice, row ){
			HTML +="<option value ='"+bairros[indice].id+"'>"+bairros[indice].nome+"</option>";
		});

		HTML += "</select>";

		return HTML ;
	}

	_this.desenharSelectCidade = function desenharSelectCidade( cidades ){
		
		var HTML = "<select id='cidade' class='col-md-offset-2 col-md-6'>";

		$.each(cidades, function( indice, row ){
			HTML +="<option value ='"+cidades[indice].id+"'>"+cidades[indice].nome+"</option>";
		});

		HTML += "</select>";

		return HTML ;
	}

	_this.desenharSelectJornaleiro = function desenharSelectJornaleiro( jornaleiros ){

		var HTML = "<select id='jornaleiro' class='col-md-2'>";

		$.each(jornaleiros, function( indice, row ){
			HTML +="<option value ='"+jornaleiros[indice].id+"'>"+jornaleiros[indice].pessoa.nome+"</option>";
		});

		HTML += "</select>";

		return HTML ;
	}


	$("#novaCidade").on("click", function( event ){
		event.preventDefault();
	});

	$("#novoBairro").on("click", function( event ){
		event.preventDefault();
		_this.buscarCidades();
	});

	$("#criar").on('click', function( event ){
		event.preventDefault();

		var pontoVenda = { 
							nome : $("#nome").val(),
							logradouro : $("#logradouro").val(),
							complemento: $('#complemento').val(),
						 	numero : $("#numero").val(),
						 	id_bairro : $("#bairro").val(),
						 	jornaleiro : $("#jornaleiro").val()
						};
		$.ajax({
			url :"api/PontoVenda",
			type: "post",
			data : pontoVenda,
			success: function( resposta ){
				alert( resposta );
				$(location).attr('href', 'manterPontoVenda.html');
			},
			error : function(){
				alert( jqXhr );
			}
		});

	});

	$("#criarBairro").on('click', function( event ){
		event.preventDefault();
		
		var bairro = { nome : $("#formBairro #nome").val(),cidade : $("#formBairro #cidade").val() };

		$.ajax({
			url:"api/Bairro",
			type: "post",
			data: bairro,
			success: function( resposta ){
				alert( 'Bairro Criado');
				_this.bairro.push( bairro ) ;
				_this.desenharSelectBairro( _this.bairro );
			},
			error: function( jqXhr ){
             alert( jqXhr );
			}

		});
	});

});