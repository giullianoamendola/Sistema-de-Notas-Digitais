<?php

	class PrecoCapaDAO implements DAO{

		private $sql;
		private $pdo;
		private $jornalDAO;

		function __construct( PDO $pdo, JornalDAO $jornalDAO ){
			$this->pdo = $pdo ;
			$this->jornalDAO = $jornalDAO;
		}

		function adicionar( &$precoCapa ){
			$this->sql = "INSERT INTO precoCapa(data , preco, id_jornal) VALUES( :data, :preco, :id_jornal)";
			$jornal = $precoCapa->getJornal();
			try{
				$ps = $this->pdo->prepare( $this->sql);
				$ok = $ps->execute( array("data"=> $precoCapa->getData(),
									"preco"=>$precoCapa->getPreco(),
									"id_jornal"=>$jornal->getId()
									));
				$precoCapa->setId( $this->pdo->lastInsertId());	

					
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

		}

		function alterar( $precoCapa ){
			$this->sql = "UPDATE precoCapa SET data = :data, preco = :preco , id_jornal = :id_jornal WHERE id = :id";
			$jornal = $precoCapa->getJornal();
			try{
				$jornal = $precoCapa->getJornal();
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array("data"=>$precoCapa->getData(),
									"preco"=>$precoCapa->getPreco(),
									"id_jornal"=>$jornal->getId(),
									"id"=>$precoCapa->getId()	
									));
			}catch( Exception $e ){
				throw new DAOException ($e);
			}
		}

		function remover( $precoCapa ){
			$this->sql = "DELETE FROM precoCapa WHERE id = :id";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id"=>$precoCapa->getId()));
			}catch( Exception $e){
				throw new DAOException($e);
			}
		}

		function comId( $id ){
			$this->sql = "SELECT * FROM precoCapa WHERE id = :id";
			$precoCapa = null ;
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id"=>$id));
				$resultado = $ps->fetchObject();
				$jornal = $this->jornalDAO->comId( $resultado->id_jornal);
				$precoCapa = new PrecoCapa( $resultado->preco, $resultado->data, $jornal, $resultado->id);
			}catch( Exception $e ){
				throw new DAOException($e);
			}

			return $precoCapa;
		}

		function listar(){
			$this->sql = "SELECT * FROM precoCapa";
			$precosCapa = [];
			try{
				$resultado = $this->pdo->query( $this->sql );
				foreach ($resultado as $row) {
					$jornal = $this->jornalDAO->comId( $row['id_jornal']);
					$precoCapa = new PrecoCapa( $row['preco'], $row['data'], $jornal, $row['id']);
					$precosCapa[] = $precoCapa;
				}

			}catch( Exceptio $e ){
				throw new DAOException( $e );
			}

			return $precosCapa;
		}

		function listarPorData( $data ){
			$this->sql = "SELECT * FROM precoCapa WHERE data = :data ";
			$precosCapa = [];
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "data"=>$data ));
				$resultado = $ps->fetchAll();
				$precoCapa = null ;
				foreach ($resultado as $row) {
					$jornal = $this->jornalDAO->comId( (int)$row['id_jornal']);
					$precoCapa = new PrecoCapa( $row['preco'], $row['data'], $jornal, $row['id']);
					$precosCapa[] = $precoCapa;
				}
			}catch( Exceptio $e ){
				throw new DAOException( $e );
			}
			return $precosCapa;
		}

		function comDataEJornal( $data , $jornal ){
			$this->sql = "SELECT * FROM precoCapa WHERE data = :data AND id_jornal = :id_jornal";
			$precoCapa = null ;
			try{

				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "data"=>$data,
									 "id_jornal"=>$jornal->getId()
					));
				$resultado = $ps->fetchObject();
				
				if( $resultado != null ){

					$precoCapa = new PrecoCapa( $resultado->preco, $resultado->data, $jornal, $resultado->id);
				}


			}catch( Exception $e ){
				throw new DAOException($e);
			}

			return $precoCapa;
		}

		function lancar( &$precoCapa ){
			//var_dump("LANCANDO PRECOS...");

			if( $precoCapa->getId() == 0){
	
				$this->adicionar( $precoCapa );
				
			}

			else{

				$this->alterar( $precoCapa );
			
			}

		}

	}








?>