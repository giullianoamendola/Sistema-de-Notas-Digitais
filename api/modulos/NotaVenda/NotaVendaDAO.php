<?php


	class NotaVendaDAO implements DAO{

		private $pdo;
		private $pontoVendaDAO;
		private $precoCapaDAO;
		private $sql;

		function __construct( PDO $pdo, PontoVendaDAO $pontoVendaDAO , PrecoCapaDAO $precoCapaDAO){

			$this->pdo = $pdo ;
			$this->pontoVendaDAO = $pontoVendaDAO;
			$this->precoCapaDAO = $precoCapaDAO ;
		}

		function adicionar( &$notaVenda ){
			
			$pontoVenda = $notaVenda->getPontoVenda();
/*
			try{
				$notaExistente = $this->buscarPorPontoEData( $pontoVenda , $notaVenda->getDataNota() );
				if( $notaExistente != null){
					return ...
				}

			}catch( Exception $e ){
				throw new DAOException ( $e );
			}
*/	
			$this->sql  = "INSERT INTO notaVenda( dataNota, dataPgmt, comissao, id_pontoVenda) VALUES( :dataNota, :dataPgmt, :comissao, :id_pontoVenda) ";
			$pontoVenda = $notaVenda->getPontoVenda();
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "dataNota"=> $notaVenda->getDataNota(),
									 "dataPgmt"=> $notaVenda->getDataPgmt(),
									 "comissao"=> $notaVenda->getComissao(),
									 "id_pontoVenda"=> $pontoVenda->getId()

									));
				$notaVenda->setId( $this->pdo->lastInsertId());
			}catch( Exception $e){
				throw new DAOException( $e );
			}

			$this->sql = "INSERT INTO itemNota( qtdEntregue, qtdVendido, id_precoCapa , id_notaVenda) VALUES( :qtdEntregue, :qtdVendido , :id_precoCapa , :id_notaVenda)";
			
			$id_notaVenda = $notaVenda->getId();

			foreach ($notaVenda->getItensNota() as $itemNota ) {
			

					$precoCapa = $itemNota->getPrecoCapa();
					$notaVenda = $itemNota->getNotaVenda();
					try{
						$ps = $this->pdo->prepare( $this->sql );
						$ps->execute( array( "qtdEntregue"=>$itemNota->getQtdEntregue(),
											 "qtdVendido"=>$itemNota->getQtdVendido(),
											 "id_precoCapa"=> $precoCapa->getId(),
											 "id_notaVenda"=> $id_notaVenda
											));
						$itemNota->setId( $this->pdo->lastInsertId());
					}catch( Exception $e ){
						throw new DAOException( $e );
					}
			}
		}

		function alterar( $notaVenda ){
			$this->sql = "UPDATE notaVenda SET dataNota = :dataNota , dataPgmt = :dataPgmt , comissao = :comissao , id_pontoVenda = :id_pontoVenda WHERE id = :id ";
			$pontoVenda = $notaVenda->getPontoVenda();
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "dataNota"=>$notaVenda->getDataNota(),
									 "dataPgmt"=> $notaVenda->getDataPgmt(),
									 "comissao"=>$notaVenda->getComissao(),
									 "id_pontoVenda"=>$pontoVenda->getId(),
									 "id"=>$notaVenda->getId()
									));
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function remover( $notaVenda ){
			$this->sql = "DELETE FROM notaVenda WHERE id =:id ";
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=>$notaVenda->getId()));
			}catch( Exception $e){
				throw new DAOException( $e );
			}
		}

		function comId( $id ){
			$this->sql = "SELECT * FROM notaVenda WHERE id = :id ";
			$notaVenda = null ;
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=> $id));
				$resultado = $ps->fetchObject();
				$pontoVenda = $this->pontoVendaDAO->comId( $resultado->id_pontoVenda);
				$notaVenda = new NotaVenda( $resultado->dataNota, $resultado->dataPgmt, $resultado->comissao, $pontoVenda, $resultado->id);
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			return $notaVenda;
		}

		function listar(){
			$this->sql = "SELECT * FROM notaVenda";
			$notasVenda = [];
			try{
				$resultado = $this->pdo->query( $this->sql );
				foreach( $resultado as $row){
					$pontoVenda = $this->pontoVendaDAO->comId( $row['id_pontoVenda']);
					$notaVenda = new NotaVenda($row['dataNota'], $row['dataPgmt'], $row['comissao'], $pontoVenda, $row['id']  );
					$notasVenda[] = $notaVenda; 
				}
			}catch( Exception $e){
				throw new DAOException( $e );
			}

			return $notasVenda;
		}

		function buscarPorPontoEData( $pontoVenda, $dataNota ){
			$this->sql = "SELECT * FROM notaVenda WHERE id_pontoVenda = :id_pontoVenda AND dataNota = :dataNota";
			$notaVenda = null ;
			try{

				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id_pontoVenda"=> $pontoVenda->getId() , "dataNota"=> $dataNota ));
				$resultado = $ps->fetchObject();
				$pontoVenda = $this->pontoVendaDAO->comId( $resultado->id_pontoVenda);
				$notaVenda = new NotaVenda( $dataNota, $resultado->dataPgmt, $resultado->comissao, $pontoVenda, $resultado->id, 0);

			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			$this->sql = "SELECT * FROM itemNota WHERE id_notaVenda = :id_notaVenda";
			$id_notaVenda = $notaVenda->getId();
			$itensNota = [] ;
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id_notaVenda"=> $id_notaVenda ));
				$resultado = $ps->fetchAll();			
				foreach ($resultado as $row ) {

					$precoCapa = $this->precoCapaDAO->comId( $row['id_precoCapa'] );
					$itemNota = new ItemNota( $row['qtdEntregue'], 0 ,$precoCapa , null , $row['id']);

					$itensNota[] = $itemNota ; 
				}
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			$notaVenda->setItensNota( $itensNota );

			return $notaVenda ;
		}
	}






?>