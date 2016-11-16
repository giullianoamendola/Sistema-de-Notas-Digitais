<?php
	
	require_once("ItemNota.php");
	require_once("JornalDAO.php");
	require_once("NotaVendaDAO.php");

	class ItemNotaDAO implements DAO{

		private $pdo ;
		private $sql ;
		private $jornalDAO ;
		private $notaVendaDAO ;

		function __construct( PDO $pdo , JornalDAO $jornalDAO, NotaVendaDAO $notaVendaDAO ){
			$this->pdo = $pdo ;
			$this->jornalDAO = $jornalDAO ;
			$this->notaVendaDAO = $notaVendaDAO ;

		}

		function adicionar( &$itemNota ){
			$this->sql = "INSERT INTO itemNota( qtdEntregue, qtdVendido, id_jornal , id_notaVenda) VALUES( :qtdEntregue, :qtdVendido , :id_jornal , :id_notaVenda)";
			$jornal = $itemNota->getJornal();
			$notaVenda = $itemNota->getNotaVenda();
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "qtdEntregue"=>$itemNota->getQtdEntregue(),
									 "qtdVendido"=>$itemNota->getQtdVendido(),
									 "id_jornal"=> $jornal->getId(),
									 "id_notaVenda"=>$notaVenda->getId()
									));
				$itemNota->setId( $this->pdo->lastInsertId());
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function alterar( $itemNota ){
			$this->sql = "UPDATE itemNota SET qtdEntregue = :qtdEntregue , qtdVendido = :qtdVendido , id_jornal = :id_jornal , id_notaVenda = :id_notaVenda WHERE id = :id ";
			$jornal = $itemNota->getJornal();
			$notaVenda = $itemNota->getNotaVenda();
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array(  "qtdEntregue"=>$itemNota->getQtdEntregue(),
									 "qtdVendido"=>$itemNota->getQtdVendido(),
									 "id_jornal"=> $jornal->getId(),
									 "id_notaVenda"=>$notaVenda->getId(),
									 "id"=>$itemNota->getId()

									));
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function remover( $itemNota ){
			$this->sql = "DELETE FROM itemNota WHERE id = :id ";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id"=>$itemNota->getId()));
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function comId( $id ){
			$this->sql = "SELECT * FROM itemNota WHERE id = :id";
			$itemNota = null;
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id"=>$id));
				$resultado = $ps->fetchObject();
				$jornal = $this->jornalDAO->comId( $resultado->id_jornal );
				$notaVenda = $this->notaVendaDAO->comId( $resultado->id_notaVenda);
				$itemNota = new ItemNota( $resultado->qtdEntregue , $resultado->qtdVendido , $notaVenda , $jornal , $resultado->id );
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			return $itemNota ;
		}

		function listar(){
			$this->sql = "SELECT * FROM itemNota";
			$itensNota = [];
			try{
				$resultado = $this->pdo->query( $this->sql );
				foreach ($resultado as $row ) {
					$jornal = $this->jornalDAO->comId( $row['id_jornal']);
					$notaVenda = $this->notaVendaDAO->comId( $row['id_notaVenda']);
					$itemNota = new ItemNota( $row['qtdEntregue'], $row['qtdVendido'], $notaVenda , $jornal , $row['id'] );
					$itensNota[] = $itemNota;
				}
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
			return $itensNota ;
		}
	}








?>