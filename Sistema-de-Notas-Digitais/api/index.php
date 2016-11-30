<?php
/**
 *  @author	Alessandro Bastos Grandini
 */

define( 'REMOTE_IP',	'0.0.0.0' );
define( 'REMOTE_HOST',	'' );
define( 'DEBUG_MODE',	true );

require_once 'vendor/autoload.php';

use Slim\App;


//use \phputil\DI;

// Realiza ajustes de zona, data e hora do servidor
date_default_timezone_set( 'America/Sao_Paulo' );

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];


// Cria a aplicação Slim
$app = new \Slim\App($configuration);

// Realiza ajustes para modo de depuração
if ( ! DEBUG_MODE ) {

	// Modifica o retorno default do servidor para 500,
	// pois ele retorna 200 mesmo com erro no PHP
	http_response_code( 500 );

	// Desabilita a exibição de erros, por motivos de segurança
	ini_set( 'display_errors', 0 );

	// Desabilita a tela de diagnóstico do Slim
	$app->config( 'debug', false );
}


// Checagens de segurança HTTP
/*
$httpSecurity = new HttpSecurity( $app );
$httpSecurity->allowCORS( REMOTE_IP, REMOTE_HOST );
$httpSecurity->preventClickJacking();
*/

// CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add( function ( $req, $res, $next ) {
    $response = $next( $req, $res );
    return $response
            ->withHeader( 'Access-Control-Allow-Origin', 'http://mysite' )
            ->withHeader( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )
            ->withHeader( 'Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS' )
            ;//->withStatus( 200 );
});



$options[ PDO::ATTR_PERSISTENT ] = true; 
$options[ PDO::MYSQL_ATTR_INIT_COMMAND ] = 'SET NAMES utf8';        

$pdo = new PDO('mysql:host=localhost;dbname=sistema_notas_digitais', "root", '', $options);
session_start();
// Definição das rotas
//require_once 'rotasAlteradas.php';
require_once 'routes.php';
// Execução


 $app->run();
  

  //session_destroy();
 
?>