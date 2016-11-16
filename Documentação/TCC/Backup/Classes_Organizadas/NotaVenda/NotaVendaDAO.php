<?php

	require_once('NotaVenda.php');
	require_once( 'PontoVendaDAO.php');
	require_once('DAO.php');

	class NotaVendaDAO implements DAO{

		private $pdo;
		private $pontoVendaDAO;
		private $sql;

		function __construct( PDO $pdo, PontoVendaDAO $pontoVendaDAO ){

			$this->pdo = $pdo ;
			$this->pontoVendaDAO = $pontoVendaDAO;
		}

		function adicionar( &$notaVenda ){
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
	}






?>