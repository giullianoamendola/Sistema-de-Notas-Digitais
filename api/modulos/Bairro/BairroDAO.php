<?php


	class BairroDAO implements DAO{

		private $cidadeDAO;
		private $pdo;
		private $sql;

		function __construct( CidadeDAO $cidadeDAO, PDO $pdo ){
			$this->cidadeDAO = $cidadeDAO;
			$this->pdo = $pdo ;
		}

		function adicionar( &$bairro){
			$this->sql = " INSERT INTO bairro( nome, id_cidade) VALUES( :nome, :id_cidade)";
			$cidade = $bairro->getCidade(); 
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute(array("nome"=>$bairro->getNome(), "id_cidade"=> $cidade->getId()));
				var_dump( $cidade->getId());
				$bairro->setId( $this->pdo->lastInsertId());
			}catch( Exception $e){
				throw new DAOException( $e);
			}
		}
		function remover($id){
			$this->sql = "DELETE FROM bairro WHERE id = :id ";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id"=>$id));
			}catch( Exception $e ){
				throw new DAOException( $e);
			}

		}

		function alterar( $bairro ){
			$this->sql = "UPDATE bairro SET nome = :nome , id_cidade = :id_cidade WHERE id = :id";
			$cidade = $bairro->getCidade();			var_dump($cidade);

			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array("nome"=>$bairro->getNome(),
									"id_cidade"=>$cidade->getId(),
									"id"=>$bairro->getId()
									));
			}catch( Exception $e ){
				throw new DAOException( $e);
			}
		}

		function comId( $id){
			$this->sql = "SELECT * FROM bairro WHERE id = :id";
			$bairro = new Bairro();;
			try{
				$ps = $this->pdo->prepare( $this->sql);
				$ps->execute( array( "id"=> $id));
				$resultado = $ps->fetchObject();
				$cidade = $this->cidadeDAO->comId( $resultado->id_cidade);

				$bairro->setNome($resultado->nome);
				$bairro->setCidade($cidade);
				$bairro->setId($id);

			}catch( Exception $e ){
				throw new DAOException($e);
			}


			return $bairro;
		}
		function listar(){
			$bairros = [];
			$this->sql = "SELECT * FROM bairro";
			try{
				$resultado = $this->pdo->query($this->sql);
				foreach ($resultado as $row) {
					$cidade = $this->cidadeDAO->comId( $row['id_cidade']);
					$bairro = new Bairro($row['nome'], $cidade, $row['id']);
					$bairros[] = $bairro;
				}

			}catch( Exception $e){
				throw new DAOException($e);
			}
			return $bairros;
		}


	}








?>