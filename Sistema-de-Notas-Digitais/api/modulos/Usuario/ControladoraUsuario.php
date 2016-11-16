<?php

	class ControladoraUsuario{

		private $usuarioDAO ;
		private $geradoraRespota ;

		function __construct( PDO $pdo, Geradora $geradoraResposta ){
			$this->usuarioDAO = new usuarioDAO( $pdo );
			$this->geradoraResposta = $geradoraResposta ;
		}

		function login( $usuario ){

		}

		function logout( $usuario ){
			
		}

	}







?>