<?php

	class ControladoraUsuario{

		private $usuarioDAO ;
		private $geradoraRespota ;

		function __construct( PDO $pdo, GeradoraResposta $geradoraResposta ){
			$this->usuarioDAO = new usuarioDAO( $pdo );
			$this->geradoraResposta = $geradoraResposta ;
		}



		function login( $params ){

			try{

				$login = $params['login'];
				$senha = $params['senha'];
				$site = null ;
				if( strlen($login) < 30 || strlen($login) > 0 || strlen($senha) < 30 || strlen($senha > 0)){

						$usuario = new Usuario( $login, $senha  );
						$usuario = $this->usuarioDAO->logar( $usuario ); 
					if( $usuario !== null  ){
						$usuarioNaSessao = array( "nome"=> $usuario->getNome() , "id"=>$usuario->getId(), "perfil"=>$usuario->getPerfil() );
						$_SESSION['usuario'] = $usuarioNaSessao;
					}
					return $this->geradoraResposta->ok($usuario->getPerfil(), GeradoraResposta::TIPO_TEXTO);
				}
				else{
					throw new Exception("Usuario ou senha invalidos !");
				}
				
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro("['Login Invalido : ']"+$e->getMessage(),GeradoraResposta::TIPO_JSON );
			}
		}
		function logout( $params ){
			
		}

		function listar(){
			try{
				$usuarios = $this->usuarioDAO->listar();
				return $this->geradoraResposta->ok( $usuarios, GeradoraResposta::TIPO_JSON );
			
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}

		}

		function adicionar( $params ){
			try{
				$nome = $params['nome'];
				$login = $params['login'];
				$senha = $params['senha'];
				if( strlen( $nome ) <= 30 && strlen( $nome ) > 0 && strlen( $login ) <= 30 && strlen( $login ) > 0  && strlen( $senha ) <= 30 && strlen( $senha ) > 0 ){
					$usuario = new Usuario( $login, $senha, $nome , "jornaleiro");
					$this->usuarioDAO->adicionar( $usuario );
				}
				else{
					throw new Exception("Cadastro incorreto !");
				}
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		function comId( $id ){
			try{
				if( is_numeric($id) ){
					$usuario = $this->usuarioDAO->comId( $id );
				}
				else{
					throw new Exception("Erro ao Buscar o usuario");
				}
				return $this->geradoraResposta->ok( $usuario , GeradoraResposta::TIPO_JSON);
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		function alterar( $params ){
			try{
				$nome = $params['nome'];
				$login = $params['login'];
				$senha = $params['senha'];
				$id = $params['id'];
				$usuario = new Usuario( $login, $senha, $nome, "jornaleiro" , $id );
				$this->usuarioDAO->alterar( $usuario );
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

	}







?>