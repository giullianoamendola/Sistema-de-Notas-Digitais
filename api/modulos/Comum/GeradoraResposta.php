<?php

/**
 * Geradora de resposta.
 *
 * @author	Thiago Delgado Pinto
 */
interface GeradoraResposta {

	// CÓDIGOS ________________________________________________________________
	
	// sucesso
	const OK				= 200;
	const CRIADO			= 201;
	const SEM_CONTEUDO		= 204;
	// erro
	const ERRO				= 400;
	const NAO_AUTORIZADO	= 401;
	const PROIBIDO			= 403;
	
	// TIPOS __________________________________________________________________
	
	const TIPO_TEXTO		= 'text/plain; charset=UTF-8';
	const TIPO_HTML			= 'text/html; charset=UTF-8';
	const TIPO_JSON			= 'application/json; charset=UTF-8';
	

	/**
	 *  Envia uma resposta ao cliente.
	 *  
	 *  @param string	$conteudo	Conteúdo a ser enviado.
	 *  @param int		$codigo		Código de status.
	 *  @param string	$tipo		Tipo de conteúdo.
	 */
	function resposta( $conteudo, $codigo, $tipo );
	
	// UTILIDADES
	
	/**
	 *  Envia uma resposta de código 200.
	 *  
	 *  @param string	$conteudo	Conteúdo a ser enviado.
	 *  @param string	$tipo		Tipo de conteúdo.
	 */
	function ok( $conteudo, $tipo );
	
	/**
	 *  Envia uma resposta de código 201.
	 *  
	 *  @param string	$conteudo	Conteúdo a ser enviado.
	 *  @param string	$tipo		Tipo de conteúdo.
	 */
	function criado( $conteudo, $tipo );
	
	/**
	 *  Envia uma resposta de código 204.
	 */
	function semConteudo();	
	
	/**
	 *  Envia uma resposta de código 400.
	 *  
	 *  @param string	$conteudo	Conteúdo a ser enviado.
	 *  @param string	$tipo		Tipo de conteúdo.
	 */
	function erro( $conteudo, $tipo );
	
	/**
	 *  Envia uma resposta de código 401.
	 *  
	 *  @param string	$conteudo	Conteúdo a ser enviado.
	 *  @param string	$tipo		Tipo de conteúdo.
	 */
	function naoAutorizado( $conteudo, $tipo );

	/**
	 *  Envia uma resposta de código 403.
	 *  
	 *  @param string	$conteudo	Conteúdo a ser enviado.
	 *  @param string	$tipo		Tipo de conteúdo.
	 */
	function proibido( $conteudo, $tipo );
}

?>