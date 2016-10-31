<?php
	

	class ItemNotaDAO implements DAO{

		private $pdo ;
		private $sql ;
		private $precoCapaDAO ;
		private $notaVendaDAO ;

		function __construct( PDO $pdo , PrecoCapaDAO $precoCapaDAO, NotaVendaDAO $notaVendaDAO ){
			$this->pdo = $pdo ;
			$this->precoCapaDAO = $precoCapaDAO ;
			$this->notaVendaDAO = $notaVendaDAO ;

		}

		function alterar( $itemNota ){
			$this->sql = "UPDATE itemNota SET qtdEntregue = :qtdEntregue , qtdVendido = :qtdVendido , id_precoCapa= :id_precoCapa , id_notaVenda = :id_notaVenda WHERE id = :id ";
			$precoCapa = $itemNota->getPrecoCapa();
			$notaVenda = $itemNota->getNotaVenda();
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array(  "qtdEntregue"=>$itemNota->getQtdEntregue(),
									 "qtdVendido"=>$itemNota->getQtdVendido(),
									 "id_precoCapa"=> $precoCapa->getId(),
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
				$precoCapa = $this->precoCapaDAO->comId( $resultado->id_precoCapa );
				$notaVenda = $this->notaVendaDAO->comId( $resultado->id_notaVenda);
				$itemNota = new ItemNota( $resultado->qtdEntregue , $resultado->qtdVendido , $notaVenda , $precoCapa , $resultado->id );
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
					
					$precoCapa = $this->precoCapaDAO->comId( $row['id_precoCapa']);
					$notaVenda = $this->notaVendaDAO->comId( $row['id_notaVenda']);
					$itemNota = new ItemNota( $row['qtdEntregue'], $row['qtdVendido'], $precoCapa, $notaVenda, $row['id'] );
					$itensNota[] = $itemNota;
				}
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
			return $itensNota ;
		}

		function buscarPorNotaVenda( $id ){
			$this->sql = "SELECT * FROM itemNota WHERE id_notaVenda = :id_notaVenda ";
			$itensNota = [] ;
			try{
				$ps = $thus->pdo->prepare( $this->sql );
				$ps->execute( array( "id_notaVenda"=>$id ));
				$resultado = $ps->fetchAll();

				foreach ($resultado as $row ) {

					$precoCapa = $this->precoCapaDAO->comId( $row['id_precoCapa']);
					$notaVenda = $this->notaVendaDAO->comId( $row['id_notaVenda']);					
					$itemNota = new ItemNota( $row['qtdEntregue'], $row['qtdVendido'], $precoCapa, $notaVenda, $row['id'] );
				
				}
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			return $itensNota ;
		}
	}








?>