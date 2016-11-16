<?php
	
	require_once('Jornal.php');
	require_once('DAO.php');

	class JornalDAO implements DAO{

		private $pdo;
		private $sql;

		function __construct( PDO $pdo ){
			$this->pdo = $pdo;
		}

		function adicionar( &$jornal){
			$this->sql = "INSERT INTO jornal( nome ) VALUES( :nome )";
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "nome"=> $jornal->getNome()));
				$jornal->setId( $this->pdo->lastInsertId());
			}catch( Exception $e ){
				throw new DAOException($e);
			}
		}

		function alterar( $jornal ){
			$this->sql = "UPDATE jornal SET nome = :nome WHERE id = :id";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "nome"=>$jornal->getNome(), "id"=>$jornal->getId()));
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function remover( $jornal){
			$this->sql = "DELETE FROM jornal WHERE id = :id";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id"=> $jornal->getId()));
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function comId( $id ){
			$this->sql = "SELECT * FROM jornal WHERE id = :id";
			$jornal = null;
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id"=> $id));
				$resultado = $ps->fetchObject();
				$jornal = new Jornal( $resultado->nome, $resultado->id );
			}catch( Exception $e){
				throw new DAOException( $e );
			}

			return $jornal;
		}

		function listar(){
			$this->sql = "SELECT * FROM jornal";
			$jornais = [];
			try{
				$resultado = $this->pdo->query( $this->sql);
				foreach( $resultado as $row ){
					$jornal = new Jornal( $row['nome'], $row['id']);
					$jornais[] = $jornal;
				}

			}catch( Exception $e){
				throw new DAOException( $e );
			}

			return $jornais;
		}
	}











?>