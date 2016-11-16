<?php

	class ControladoraJornal{

	private $geradoraResposta;
	private $jornalDAO ;

	function __construct( PDO $pdo, GeradoraResposta $geradoraResposta ){

		$this->jornalDAO = new JornalDAO( $pdo );
		$this->geradoraResposta = $geradoraResposta;
	}

	function listar(){
		try{

			$jornais = $this->jornalDAO->listar();
			return $this->geradoraResposta->ok( $jornais, GeradoraResposta::TIPO_JSON );
		
		}catch( DAOException $e ){

		}


	}

}





?>