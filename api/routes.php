<?php

// ----------------------------------------------------------------------------
// Variáveis do index.php são acessíveis neste arquivo.
// ----------------------------------------------------------------------------

// NOTA DE VENDA

$app->post( '/NotaVenda', function( $request, $response, $args ) use ( $app, $pdo ) {

	$geradoraResposta = new GeradoraRespostaComSlim( $this );
	$controladoraNotaVenda = new ControladoraNotaVenda( $pdo, $geradoraResposta);
	$params = $request->getParsedBody();
	$controladoraNotaVenda->criarNotaVenda( $params );
	
} );
///ProcurarPorDataEPontoVenda',
$app->get('/NotaVenda/DataEPonto', function( $request, $response, $args ) use( $app, $pdo ){
	$params = $request->getQueryParams();
	$geradoraResposta = new GeradoraRespostaComSlim( $this );
	$controladoraNotaVenda = new ControladoraNotaVenda( $pdo, $geradoraResposta);

	$controladoraNotaVenda->buscarPorDataEPontoVenda( $params );

});
/*
$app->put( '/NotaVenda/:id', function( $id ) use ( $app ) {
	$ctrl = new ControladoraNota( $pdo );
	$params = $request->getParsedBody();
	$ctrl = new ControladoraNotaVenda( $params );
	$ctrl->atualizar();
} );



$app->get( '/NotaVenda', function() use ( $app ) {
	$params = $request->get();
	$geradoraResposta = new GeradoraRespostaComSlim( $app );
	$ctrl = new ControladoraMotorista( $geradoraResposta, $params );
	$ctrl->todos();
} );

$app->delete( '/NotaVenda/:id', function( $id ) use ( $app ) {
	$params = array( 'id' => $id );
	$ctrl = new ControladoraNotaVenda( $geradoraResposta, $params );
	$ctrl->remover();
} );*/

/*
//ITEM DE NOTA
$app->post( '/ItemNota', function( $request, $response, $args ) use( $app, $pdo ){
	$geradoraResposta = new GeradoraRespostaComSlim( $app );
	$params = $request->getParsedBody();
	$controladoraItemNota = new ContrladoraItemNota( $pdo, $geradoraResposta );
	$controladoraItemNota->criarItensNota( $params );

});

$app->get( '/ItemNota', function( $request, $response, $args) use( $app, $pdo ){

	$params = $request->getParsedBody();
	$geradoraResposta = new GeradoraRespostaComSlim( $this );
	$controladoraItemNota = new ControladoraItemNota( $pdo, $geradoraResposta );
	$itens =  $controladoraItemNota->listarItemNota();


});
$app->get( '/ItemNota/:id_notavenda', function( $id ) use ( $app ) {
	
	$params = array( 'id_notavenda' => $id );
	$controladoraItemNota = new ControladoraItemNota();
	$ControladoraItemNota->buscarPorNotaVenda( $params );

} );
*/
//PREÇO DE CAPA

$app->get( '/PrecoCapa', function( $request, $response, $args) use ( $app, $pdo ) {

	$params = $request->getParsedBody();
	$geradoraResposta = new GeradoraRespostaComSlim( $this );
	$controladoraPrecoCapa = new ControladoraPrecoCapa( $pdo, $geradoraResposta );
	return $controladoraPrecoCapa->listarPrecoCapa();

});

//PONTO DE VENDA 

$app->get( '/PontoVenda', function( $request, $response, $args ) use ( $app, $pdo ){
	$params = $request->getParsedBody();
	$geradoraResposta = new GeradoraRespostaComSlim( $this );
	$controladoraPontoVenda = new ControladoraPontoVenda( $pdo, $geradoraResposta );
	return $controladoraPontoVenda->listarPontoVenda();
});

$app->get('/PontoVenda/:id', function( $id ) use ( $app, $pdo){
	$params = array( 'id'=>$id );
	$geradoraResposta = new geradoraRespostaComSlim( $this );
	$controladoraPontoVenda = ControladoraPontoVenda( $pdo , $geradoraResposta );
	$controladoraPontoVenda->comId( $params );

})


/*IMPRESSAO
$app->get('/Impressao/:id', function( $request, $response, $args) use ( $app, $pdo ){
	$params = array( 'id'=>$id );
	$geradoraResposta = new GeradoraRespostaComSlim( $this );
	$controladoraNotaVenda = new ControladoraNotaVenda( $pdo, $geradoraResposta );
	$controladoraNotaVenda->buscarComId( $id );

});
*/






?>