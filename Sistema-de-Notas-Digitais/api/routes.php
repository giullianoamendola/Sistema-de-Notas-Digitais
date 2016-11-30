<?php

// ----------------------------------------------------------------------------
// Variáveis do index.php são acessíveis neste arquivo.
// ----------------------------------------------------------------------------

// NOTA DE VENDA


$app->post( '/NotaVenda', function( $request, $response, $args ) use ( $app, $pdo ) {
	
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraNotaVenda = new ControladoraNotaVenda( $pdo, $geradoraResposta);
		$params = $request->getParsedBody();
		$controladoraNotaVenda->criarNotaVenda( $params );
	}
	else{
		echo "<script>location.href='../login.html';</script>";
	}
} )->add( new ControladoraAcesso( array("ADM") ));

$app->get('/NotaVenda/DataEPonto', function( $request, $response, $args ) use( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getQueryParams();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraNotaVenda = new ControladoraNotaVenda( $pdo, $geradoraResposta);
		$controladoraNotaVenda->buscarPorDataEPontoVenda( $params );
	
	}
	else{
		echo "<script>location.href='../../login.html';</script>";
	}
})->add( new ControladoraAcesso(array("ADM","jornaleiro")));

$app->get('/NotaVenda/PorData', function( $request, $response, $args ) use( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getQueryParams();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraNotaVenda = new ControladoraNotaVenda( $pdo, $geradoraResposta);

		$controladoraNotaVenda->buscarPorData( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ) );

$app->get('/NotaVenda/DoDia', function( $request, $response, $args ) use( $app, $pdo ){
	
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraNotaVenda = new ControladoraNotaVenda( $pdo, $geradoraResposta);
		$controladoraNotaVenda->buscarNotasDoDia( $params );
	}
	else{
		echo 'Sem Acesso ';
	}
})->add( new ControladoraAcesso(array("ADM") ));

$app->get('/NotaVenda/PorDataENaoPaga', function( $request, $response, $args ) use( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso){		
		$params = $request->getQueryParams();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraNotaVenda = new ControladoraNotaVenda( $pdo, $geradoraResposta);

		$controladoraNotaVenda->buscarPorDataENaoPaga( $params );
	}


})->add( new ControladoraAcesso( array("ADM") ));

$app->put( '/NotaVenda/RegistrarPagamento', function( $request, $response, $args ) use ( $app, $pdo ) {
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraNotaVenda = new ControladoraNotaVenda( $pdo, $geradoraResposta);
		$params = $request->getParsedBody();
		$controladoraNotaVenda->registrarPagamento( $params );
	}

	
} )->add( new ControladoraAcesso( array("ADM") ));

$app->get( '/NotaVenda/ComId', function( $request, $response, $args ) use ( $app, $pdo ) {
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getQueryParams();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$ctrl = new ControladoraNotaVenda($pdo, $geradoraResposta );
		$ctrl->buscarComId( intval( $params['id']) );
	}
} )->add( new ControladoraAcesso( array("ADM") ));

$app->get('/NotaVenda/PontosSemNota', function( $request, $response, $args )use ( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$ctrl = new ControladoraNotaVenda($pdo, $geradoraResposta );
		 $ctrl->pontosVendaSemNotaDoDia();
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->put( '/NotaVenda/RegistrarVenda', function( $request, $response, $args  ) use ( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$ctrl = new ControladoraNotaVenda( $pdo, $geradoraResposta  );
		$ctrl->registrarVenda( $params );	
	}

} )->add( new ControladoraAcesso( array("jornaleiro")));


$app->put( '/NotaVenda', function( $request, $response, $args  ) use ( $app, $pdo ) {
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$ctrl = new ControladoraNotaVenda( $pdo, $geradoraResposta  );
		$ctrl->alterarNotaVenda( $params );
	}

} )->add( new ControladoraAcesso( array("ADM") ));

$app->delete('/NotaVenda', function( $request, $response, $args ) use( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $params ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$ctrl = new ControladoraNotaVenda( $pdo, $geradoraResposta );
		$ctrl->excluirNotaVenda( $params );
	}

})->add( new ControladoraAcesso( array("ADM") ));

//JORNAL 
$app->get('/Jornal', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornal = new ControladoraJornal( $pdo, $geradoraResposta );
		$controladoraJornal->listar();		
	}

})->add( new ControladoraAcesso( array("ADM") ));

$app->delete('/Jornal', function( $resquest, $response ,$args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $resquest->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornal = new ControladoraJornal( $pdo, $geradoraResposta );
		$controladoraJornal->excluir( $params );	
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->post('/Jornal', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornal = new ControladoraJornal( $pdo, $geradoraResposta );
		$controladoraJornal->adicionar( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->put('/Jornal', function( $request , $response, $args ) use( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornal =  new ControladoraJornal( $pdo, $geradoraResposta );
		$controladoraJornal->alterar( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->get('/Jornal/ComId', function(  $request , $response, $args  ) use( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){	
		$params = $request->getQueryParams();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornal = new ControladoraJornal( $pdo, $geradoraResposta );
		$controladoraJornal->comId( $params['id'] );
	}
})->add( new ControladoraAcesso( array("ADM") ));



//PREÇO DE CAPA
$app->post('/PrecoCapa', function( $request, $response, $args) use( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){	
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraPrecoCapa = new ControladoraPrecoCapa( $pdo, $geradoraResposta );
		$controladoraPrecoCapa->lancarPrecoCapa( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->get( '/PrecoCapa', function( $request, $response, $args) use ( $app, $pdo ) {
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){	
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraPrecoCapa = new ControladoraPrecoCapa( $pdo, $geradoraResposta );
		return $controladoraPrecoCapa->listarPrecoCapaDoDia();
	}
	//return $controladoraPrecoCapa->listarPrecoCapaPorData();//SO PARA TESTAR
})->add( new ControladoraAcesso( array("ADM") ));

$app->get( '/PrecoCapaPorData', function( $request, $response, $args ) use ( $app, $pdo ) {
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){	
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraPrecoCapa = new ControladoraPrecoCapa( $pdo, $geradoraResposta );
		return $controladoraPrecoCapa->listarPrecoCapaPorData();
	}
})->add( new ControladoraAcesso( array("ADM") ));
//PONTO DE VENDA 

$app->get( '/PontoVenda', function( $request, $response, $args ) use ( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){	
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraPontoVenda = new ControladoraPontoVenda( $pdo, $geradoraResposta );
		return $controladoraPontoVenda->listarPontoVenda();
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->get('/PontoVenda/ComId', function($request, $response, $args ) use ( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){	
		$params = $request->getQueryParams();
		$geradoraResposta = new geradoraRespostaComSlim( $this );
		$controladoraPontoVenda = new ControladoraPontoVenda( $pdo , $geradoraResposta );
		return $controladoraPontoVenda->comId( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->get('/PontoVendaPorJornaleiro', function( $request, $response, $args ) use ( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = array( "id" => 1 );
		$geradoraResposta = new geradoraRespostaComSlim( $this );
		$controladoraPontoVenda = new ControladoraPontoVenda( $pdo , $geradoraResposta );
		return $controladoraPontoVenda->comJornaleiro( $params );
	}
})->add( new ControladoraAcesso( array("jornaleiro") ));

$app->get('/PontoVendaSemNota' , function( $resquest, $response, $args ) use( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){	
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraPontoVenda = new ControladoraPontoVenda( $pdo, $geradoraResposta );
		return $controladoraPontoVenda->listarPontoVendaSemNota();
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->put( '/PontoVenda', function( $request, $response, $args ) use ( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraPontoVenda = new ControladoraPontoVenda( $pdo, $geradoraResposta );
		return $controladoraPontoVenda->alterar( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->post('/PontoVenda', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraPontoVenda = new ControladoraPontoVenda( $pdo, $geradoraResposta );
		$controladoraPontoVenda->adicionar( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ));

//JORNALEIRO

$app->get('/Jornaleiro', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornaleiro = new ControladoraJornaleiro( $pdo, $geradoraResposta );
		$controladoraJornaleiro->listar();
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->post('/Jornaleiro', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornaleiro = new ControladoraJornaleiro( $pdo, $geradoraResposta );
		$controladoraJornaleiro->adicionar( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->put('/Jornaleiro', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornaleiro = new ControladoraJornaleiro( $pdo, $geradoraResposta );
		$controladoraJornaleiro->alterar( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->get('/Jornaleiro/ComId', function(  $request , $response, $args  ) use( $app, $pdo ){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getQueryParams();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornaleiro = new ControladoraJornaleiro( $pdo, $geradoraResposta );
		$controladoraJornaleiro->comId( $params['id'] );
	}
})->add( new ControladoraAcesso( array("ADM") ));


$app->delete('/Jornaleiro', function( $resquest, $response ,$args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $resquest->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraJornaleiro = new ControladoraJornaleiro( $pdo, $geradoraResposta );
		$controladoraJornaleiro->excluir( $params );	
	}
})->add( new ControladoraAcesso( array("ADM") ));


//CIDADE 

$app->get('/Cidade', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraCidade = new ControladoraCidade( $pdo, $geradoraResposta );
		$controladoraCidade->listar();
	}
})->add( new ControladoraAcesso( array("ADM") ));

//BAIRRO 

$app->get('/Bairro', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraBairro = new ControladoraBairro( $pdo, $geradoraResposta );
		$controladoraBairro->listar();
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->post('/Bairro', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){
		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraBairro = new ControladoraBairro( $pdo, $geradoraResposta );
		$controladoraBairro->adicionar( $params );
	}
})->add( new ControladoraAcesso( array("ADM") ));






//LOGAR 

$app->get("/Usuario", function( $request, $response, $args ) use( $app, $pdo ){
	//$acesso = $request->getAttribute('acesso');
	//if( $acesso ){

		$params = $request->getQueryParams();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraUsuario = new ControladoraUsuario( $pdo, $geradoraResposta );
		$controladoraUsuario->login( $params );	
	//}

});//->add( new ControladoraAcesso( array("ADM", "jornaleiro") ));


$app->get('/Usuario/Todos', function( $request, $response, $args ) use( $app, $pdo){
	$acesso = $request->getAttribute('acesso');
	if( $acesso ){

		$params = $request->getParsedBody();
		$geradoraResposta = new GeradoraRespostaComSlim( $this );
		$controladoraUsuario = new ControladoraUsuario( $pdo, $geradoraResposta );
		$controladoraUsuario->listar();
	}
})->add( new ControladoraAcesso( array("ADM") ));

$app->post("/Usuario", function( $request, $response, $args )use( $app, $pdo){
		$acesso = $request->getAttribute('acesso');
		if( $acesso ){

			$params = $request->getParsedBody();
			$geradoraResposta = new GeradoraRespostaComSlim( $this );
			$controladoraUsuario = new ControladoraUsuario( $pdo, $geradoraResposta );
			$controladoraUsuario->adicionar( $params );
		}
})->add( new ControladoraAcesso( array("ADM") ));

$app->get('/Usuario/ComId', function(  $request , $response, $args  ) use( $app, $pdo ){
		$acesso = $request->getAttribute('acesso');
		if( $acesso ){
			$params = $request->getQueryParams();
			$geradoraResposta = new GeradoraRespostaComSlim( $this );
			$controladoraUsuario = new ControladoraUsuario( $pdo, $geradoraResposta );
			$controladoraUsuario->comId( $params['id'] );
		}
})->add( new ControladoraAcesso( array("ADM") ));

$app->put('/Usuario', function( $request, $response, $args ) use( $app, $pdo){
		$acesso = $request->getAttribute('acesso');
		if( $acesso ){
			$params = $request->getParsedBody();
			$geradoraResposta = new GeradoraRespostaComSlim( $this );
			$controladoraUsuario = new ControladoraUsuario( $pdo, $geradoraResposta );
			$controladoraUsuario->alterar( $params );
		}
})->add( new ControladoraAcesso( array("ADM") ));




?>