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
			return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
		}

	}

	function excluir( $params ){
		try{
			$id = $params['id'];
			if( is_numeric($id )){
				$jornal = $this->jornalDAO->comId( $id );
				$this->jornalDAO->remover( $jornal );
			}
			else{
				throw new Exception("Erro ao excluir");
			}
		}catch( DAOException $e ){
			return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
		}
	}

	function adicionar( $params ){
		try{
			$nome = $params['nome'];
			if( strlen( $nome ) <= 30 && strlen( $nome ) > 0){
				$jornal = new Jornal( $nome );
				$this->jornalDAO->adicionar( $jornal );
			}
			else{
				throw new Exception("Tamanho invalido ");
			}

		}catch( DAOException $e ){
			return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);			
		}
	}

	function alterar( $params ){
		try{
			$nome = $params['nome'];
			$id = $params['id'];
			$jornal = new Jornal( $nome , $id );
			$this->jornalDAO->alterar( $jornal );
		}catch( DAOException $e ){
			return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
		}
	}

	function comId( $id ){
		try{

			$jornal = $this->jornalDAO->comId( $id );
			return $this->geradoraResposta->ok( $jornal, GeradoraResposta::TIPO_JSON );
		}catch( DAOException $e ){
			return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
		}
	}

}





?>