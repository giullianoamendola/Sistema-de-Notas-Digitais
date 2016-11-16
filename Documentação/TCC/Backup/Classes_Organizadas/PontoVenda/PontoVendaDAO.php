<?php

	require_once('PontoVenda/PontoVenda.php');
	require_once('Endereco/Endereco.php');
	require_once('Jornaleiro/Jornaleiro.php');
	require_once('DAO/DAO.php');

	class PontoVendaDAO implements DAO{

		private $sql;
		private $pdo;
		private $jornaleiroDAO;
		private $enderecoDAO;

		function __construct(PDO $pdo, JornaleiroDAO $jornaleiroDAO, EnderecoDAO $enderecoDAO){

			$this->pdo = $pdo ;
			$this->jornaleiroDAO = $jornaleiroDAO;
			$this->enderecoDAO = $enderecoDAO;
		}

		function adicionar( &$pontoVenda){
			$this->sql = "INSERT INTO pontoVenda( nome, id_jornaleiro, id_endereco) VALUES( :nome, :id_jornaleiro, :id_endereco)";
			$jornaleiro = $pontoVenda->getJornaleiro();
			$endereco = $pontoVenda->getEndereco();
			try{
				$ps = $this->pdo->prepare( $this->sql);
				$ps->execute( array(
									"nome"=>$pontoVenda->getNome(),
									"id_jornaleiro"=>$jornaleiro->getId(),
									"id_endereco"=>$endereco->getId()
									));
				$pontoVenda->setId( $this->pdo->lastInsertId());

			}catch( Exception $e){
				throw new DAOException( $e );
			}
		}

		function remover( $pontoVenda){
			$this->sql = "DELETE FROM pontoVenda WHERE id = :id";
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=> $pontoVenda->getId()));

			}catch( Exception $e){
				throw new DAOException($e);
			}
		}
	

	function alterar( $pontoVenda ){
		$this->sql = "UPDATE pontoVenda SET nome = :nome , id_jornaleiro = :id_jornaleiro , id_endereco = :id_endereco WHERE id = :id";
		$jornaleiro = $pontoVenda->getJornaleiro();
		$endereco = $pontoVenda->getEndereco();		
		try{
			$ps = $this->pdo->prepare($this->sql);
			var_dump($pontoVenda->getNome());
			$ps->execute( array("nome"=>$pontoVenda->getNome(),
								 "id_jornaleiro"=>$endereco->getId(),
								 "id_endereco"=>$endereco->getId(),
								 "id"=>$pontoVenda->getId()

								));
		}catch( Exception $e ){
			throw new DAOException($e);
		}
	}

	function comId( $id ){
		$this->sql = 'SELECT * FROM pontoVenda WHERE id = :id ';
		$pontoVenda = null ;
		try{
			$ps = $this->pdo->prepare($this->sql);
			$ps->execute( array( "id"=>$id));
			$resultado = $ps->fetchObject();
			$jornaleiro = $this->jornaleiroDAO->comId( $resultado->id_jornaleiro );
			$endereco = $this->enderecoDAO->comId( $resultado->id_endereco );
			$pontoVenda = new PontoVenda( $resultado->nome, $jornaleiro, $endereco, $resultado->id );

		}catch( Exception $e){	
			throw new DAOException($e);
		}

		return $pontoVenda ;
	}

	function listar(){
		$this->sql = "SELECT * FROM pontoVenda";
		$pontoVendas = [];
		try{
			$resultado = $this->pdo->query($this->sql);
			
			foreach( $resultado as $row ){
				
				$jornaleiro = $this->jornaleiroDAO->comId( $row['id_jornaleiro'] );
				$endereco = $this->enderecoDAO->comId( $row['id_endereco']);		
				$pontoVenda = new PontoVenda( $row['nome'], $jornaleiro, $endereco, $row['id'] );		
				$pontoVendas[] = $pontoVenda;
			}
		}catch( Exception $e ){
			throw new DAOException($e);
		}

		return $pontoVendas;
	}

}


?>