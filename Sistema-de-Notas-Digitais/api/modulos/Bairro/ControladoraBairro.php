<?php

	class ControladoraBairro{

		private $bairroDAO ;
		private $cidadeDAO;
		private $geradoraResposta ;

		function __construct( PDO $pdo , $geradoraResposta ){
			$this->cidadeDAO = new CidadeDAO( $pdo );
			$this->bairroDAO = new bairroDAO(  $this->cidadeDAO, $pdo  );
			$this->geradoraResposta = $geradoraResposta ;
		}

		function listar(){
			try{
				$bairros = $this->bairroDAO->listar();
				return $this->geradoraResposta->ok( $bairros, GeradoraResposta::TIPO_JSON);
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		function adicionar( $params ){
			try{
				$nome = $params['nome'] ;
				if( ( strlen( $nome ) <= 30 ) && ( strlen( $nome ) > 0 ) ){

					if( is_numeric( $params['cidade'] ) ){
						$cidade = $this->cidadeDAO->comId( $params['cidade'] );
						$bairro = new Bairro( $nome , $cidade );
						$this->bairroDAO->adicionar( $bairro );
						return $this->geradoraResposta->criado('', GeradoraResposta::TIPO_TEXTO );
					}
					else{
						throw new Exception("Cidade invalida");
					}

				}
				else{
					throw new Exception("Nome com tamanho invalido ");
				}
					

			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
				
		}

	}








?>