<?php
	require_once('PrecoCapa.php');
	require_once('JornalDAO.php');
	require_once('DAO.php');

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
				$ps = $this->pdo->execute( $this->sql);
				$ps->execute( array("data"=> $precoCapa->getData(),
									"preco"=>$precoCapa->getPreco(),
									"id_jornal"=>$jornal->getId()
									));
				$precoCapa->setId( $this->pdo->lastInsetId());
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function alterar( $precoCapa ){
			$this->sql = "UPDATE precoCapa SET data = :data, preco = :preco , id_jornal = :id_jornal WHERE id = :id";
			$jornal = $precoCapa->getJornal();
			try{
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
				$precoCapa = new PrecoCapa( $resultado->preco, $resultado->data, $jornal, $resultador->id);
			}catch( Exception $e ){
				throw new DAOException($e);
			}

			return $precoCapa;
		}

		function listar(){
			$this->sql = "SELECT * FROM precoCapa";
			$precosCapa = [];
			try{
				$resutlado = $this->pdo->query( $this->sql );
				foreach ($resutlado as $row) {
					$jornal = $this->jornalDAO->comId( $row['id']);
					$precoCapa = new PrecoCapa( $row['preco'], $row['data'], $jornal, $row['id']);
					$precosCapa[] = $precoCapa;
				}

			}catch( Exceptio $e ){
				throw new DAOException( $e );
			}

			return $precosCapa;
		}
	}








?>