<?php
	require_once('DAO.php');
	require_once('Cidade.php');


	 class CidadeDAO implements DAO{

		private $sql;
		private $pdo;
	    


		function __construct( PDO $pdo ){
			$this->pdo = $pdo;
		}

		function adicionar(  &$cidade ){
			
			$this->sql = "INSERT INTO cidade( nome, uf) VALUES (:nome, :uf) ";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				//var_dump( $cidade->getNome());
				$ps->execute( array( "nome"=> $cidade->getNome(), "uf"=>$cidade->getUf()));
				$cidade->setId($this->pdo->lastInsertId());
				var_dump($cidade);
			}catch( Exception $e){
				throw new DAOException($e);
			}


		}

		function remover( $cidade ){
			$this->sql = "DELETE FROM cidade WHERE id = :id";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array("id"=>$cidade->getId()));
			}catch( Exception $e){
				throw new DAOException( $e);
			}
		}

		function alterar( $cidade){
			$this->sql = "UPDATE cidade SET nome = :nome , uf = :uf WHERE id = :id";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "nome" => $cidade->getNome(),
											 "uf"=>$cidade->getUf(),
											  "id"=>$cidade->getId()
										));
			}catch( Exception $e){
				throw new DAOException( $e);
			}
		}

		function comId( $id){

			$cidade = new Cidade();
			$this->sql = "SELECT * FROM cidade WHERE id = :id";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute(array("id"=> $id));
				$resultado = $ps->fetchObject();
				$cidade->setNome($resultado->nome);
				$cidade->setUf( $resultado->uf);
				$cidade->setId( $resultado->id);
			}catch( Exception $e){

				throw new DAOException( $e);
			}
			return $cidade;
		}

		function listar(){

			$cidades[] = '';
			$this->sql = " SELECT * FROM cidade ";
			try{
				$resultado = $this->pdo->query($this->sql);
					foreach ($resultado as $row) {
						$cidade= new Cidade( $row['nome'], $row['uf'], $row['id']);
						$cidades[] = $cidade;
					}

			}catch( Exception $e){
				throw new DAOException( $e);
			}
			return $cidades;
		}




	}









?>