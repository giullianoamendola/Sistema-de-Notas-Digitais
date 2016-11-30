<?php

	class ControladoraCidade{

		private $cidadeDAO ;
		private $geradoraResposta ;

		function __construct( PDO $pdo , $geradoraResposta ){

			$this->cidadeDAO = new CidadeDAO( $pdo );
			$this->geradoraResposta = $geradoraResposta ;
		}

		function listar(){
			try{
				$cidades = $this->cidadeDAO->listar();
				return $this->geradoraResposta->ok( $cidades, GeradoraResposta::TIPO_JSON);
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		// function adicionar( $params ){
		// 	try{
		// 		return $this->geradoraResposta->criado('', GeradoraResposta::TIPO_TEXTO );
		// 	}catch( DAOException $e ){

		// 	}
		// }

	}








?>