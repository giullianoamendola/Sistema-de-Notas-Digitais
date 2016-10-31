<?php

/**
 * Geradora de resposta com Slim.
 *
 * @author	Thiago Delgado Pinto
 * @author	Alessandro Bastos Grandini
 */
class GeradoraRespostaComSlim implements GeradoraResposta {

	private $slim;

	function __construct( \Slim\Container $slim ) {
		$this->slim = $slim;
	}
	
	protected function getSlim() {
		return $this->slim;
	}	

	/**
	 * @inheritDoc
	 */
	function resposta( $conteudo, $codigo, $tipo ) {
		$r = $this->slim->response;
		if ( $codigo !== null ) {
			$r = $r->withStatus( $codigo );
		}
		$body = $conteudo;
		if ( $tipo !== null ) {
			$r = $r->withHeader( 'Content-Type', $tipo );
			if ( is_object( $conteudo ) || is_array( $conteudo ) ) {
				$body = \JSON::encode( $conteudo );
			}
		}
		if ( $body !== null ) {
			$r->getBody()->write( $body );
		}
		return $r;
	}		
	
	// UTILIDADES
	
	/**
	 * @inheritDoc
	 */
	function ok( $conteudo, $tipo ) {
		return $this->resposta( $conteudo, self::OK, $tipo );
	}
	
	/**
	 * @inheritDoc
	 */
	function criado( $conteudo, $tipo ) {
		return $this->resposta( $conteudo, self::CRIADO, $tipo );
	}
	
	/**
	 * @inheritDoc
	 */
	function semConteudo() {
		return $this->resposta( null, self::SEM_CONTEUDO, null );
	}
	
	/**
	 * @inheritDoc
	 */
	function erro( $conteudo, $tipo ) {
		return $this->resposta( $conteudo, self::ERRO, $tipo );
	}
	
	/**
	 * @inheritDoc
	 */
	function naoAutorizado( $conteudo, $tipo ) {
		return $this->resposta( $conteudo, self::NAO_AUTORIZADO, $tipo );
	}

	/**
	 * @inheritDoc
	 */
	function proibido( $conteudo, $tipo ) {
		return $this->resposta( $conteudo, self::PROIBIDO, $tipo );
	}
}

?>