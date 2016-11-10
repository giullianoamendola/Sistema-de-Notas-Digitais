<?php

	class RoteiroDAO implements DAO{

		private $pdo;
		private $pessoaDAO;
		private $sql;

		function __construct( PDO $pdo, pessoaDAO $pessoaDAO ) {

			$this->pdo = $pdo ;
			$this->pessoaDAO = $pessoaDAO;

		}

		function adicionar( &$roteiro ){
			$this->sql = "INSERT INTO roteiro( bairro, id_entregador ) VALUES( :bairro , :id_entregador )";
			try{
				$ps = $this->pdo->prepare( $this->sql );
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}


		function adicionar( &$roteiro){
			$this->sql = "INSERT INTO roteiro( id_bairro, id_entregador ) VALUES( :id_bairro, :id_entregador, :id_endereco)";
			$entregador = $roteiro->getEntregador();
			$bairro = $roteiro->getBairro();
			try{
				$ps = $this->pdo->prepare( $this->sql);
				$ps->execute( array(
									"id_bairro"=> $bairro->getId(),
									"id_entregador"=>$entregador->getId()
									));
				$roteiro->setId( $this->pdo->lastInsertId());

			}catch( Exception $e){
				throw new DAOException( $e );
			}
		}

		function remover( $roteiro){
			$this->sql = "DELETE FROM roteiro WHERE id = :id";
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=> $roteiro->getId()));

			}catch( Exception $e){
				throw new DAOException($e);
			}
		}
	

	function alterar( $roteiro ){
		$this->sql = "UPDATE roteiro SET id_bairro = :id_bairro , id_entregador = :id_entregador , id_endereco = :id_endereco WHERE id = :id";
		$entregador = $roteiro->getentregador();
		$endereco = $roteiro->getEndereco();		
		try{
			$ps = $this->pdo->prepare($this->sql);
			var_dump($roteiro->getid_bairro());
			$ps->execute( array("id_bairro"=>$roteiro->getid_bairro(),
								 "id_entregador"=>$endereco->getId(),
								 "id_endereco"=>$endereco->getId(),
								 "id"=>$roteiro->getId()

								));
		}catch( Exception $e ){
			throw new DAOException($e);
		}
	}

	function comId( $id ){
		$this->sql = 'SELECT * FROM roteiro WHERE id = :id ';
		$roteiro = null ;
		try{
			$ps = $this->pdo->prepare($this->sql);
			$ps->execute( array( "id"=>$id));
			$resultado = $ps->fetchObject();
			$entregador = $this->entregadorDAO->comId( $resultado->id_entregador );
			$endereco = $this->enderecoDAO->comId( $resultado->id_endereco );
			$roteiro = new roteiro( $resultado->id_bairro, $entregador, $endereco, $resultado->id );

		}catch( Exception $e){	
			throw new DAOException($e);
		}

		return $roteiro ;
	}

	function listar(){
		$this->sql = "SELECT * FROM roteiro";
		$roteiros = [];
		try{
			$resultado = $this->pdo->query($this->sql);
			
			foreach( $resultado as $row ){
				
				$entregador = $this->entregadorDAO->comId( $row['id_entregador'] );
				$endereco = $this->enderecoDAO->comId( $row['id_endereco']);		
				$roteiro = new roteiro( $row['id_bairro'], $entregador, $endereco, $row['id'] );		
				$roteiros[] = $roteiro;
			}
		}catch( Exception $e ){
			throw new DAOException($e);
		}

		return $pontoVendas;
	}

}
	}





?>