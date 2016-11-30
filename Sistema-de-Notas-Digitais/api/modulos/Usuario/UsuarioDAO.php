<?php

	class UsuarioDAO implements DAO{

		private $pdo ;
		private $sql ;
		//private $pessoaDAO ;

		function __construct( PDO $pdo ){
			$this->pdo = $pdo ;
			//$this->pessoaDAO = $pessoaDAO ;
		}

		function adicionar( &$usuario ){
			$this->sql = "INSERT INTO usuario( nome , login , senha , perfil ) VALUES( :nome, :login, :senha , :perfil )";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "nome"=> $usuario->getNome(),
									 "login"=> $usuario->getLogin(),
									 "senha"=> $usuario->getSenha(),
									 "perfil"=> $usuario->getPerfil()
									));
				$usuario->setId( $this->pdo->lastInsertId());
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function alterar( $usuario ){
			$this->sql = "UPDATE usuario SET nome = :nome , login = :login , senha = :senha , perfil = :perfil WHERE id = :id ";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "nome" =>$usuario->getNome(),									
		 							"login" => $usuario->getLogin(),
									 "senha" => $usuario->getSenha(),
									 "perfil" => $usuario->getPerfil(),
									 "id" => $usuario->getId()
									));
			}catch( Exception $e ){
				throw new DAOException( $e );
			}


		}

		function remover( $usuario ){
			$this->sql = "DELETE FROM usuario WHERE id = :id ";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id" => $usuario->getId() ));
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function comId( $id ){
			
			$this->sql = "SELECT * FROM usuario WHERE id = :id ";
			$usuairo = null ;
			
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id" => $id ));
				$resultado = $ps->fetchObject();
				$usuario = new Usuario( $resultado->login , $resultado->senha , $resultado->nome , $resultado->perfil , $resultado->id );
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
			return $usuario;
		}

		function listar(){

			$this->sql = "SELECT * FROM usuario ";
			$usuarios = [] ;
			try{
				$resultado = $this->pdo->query( $this->sql );
				foreach ($resultado as $row ) {
					$usuario = new Usuario( $row['login'], $row['senha'], $row['nome'], $row['perfil'], $row['id']);
					$usuarios[] = $usuario ;
				}
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			return $usuarios ;
		}

		function logar( $usuario ){
			
			$this->sql = "SELECT * FROM usuario WHERE login = :login AND senha = :senha ";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "login" => $usuario->getLogin() , "senha" => $usuario->getSenha() ));
				$resultado = $ps->fetchObject();
				$usuario = new Usuario( $resultado->login , $resultado->senha , $resultado->nome , $resultado->perfil , $resultado->id );
			}catch( Exception $e ){
				throw new DAOException( $e, "LOGIN OU SENHA INCORRETOS !" );
			}
			return $usuario ;

		}

		function logout(){
			session_destroy();
		}


	}



?>