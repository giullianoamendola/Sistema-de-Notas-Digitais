<?php



	class JornaleiroDAO implements DAO{

		private $sql;
		private $pdo;
		private $pessoaDAO;

		function __construct( PDO $pdo, PessoaDAO $pessoaDAO){
			$this->pdo = $pdo;
			$this->pessoaDAO = $pessoaDAO;
		}

		function adicionar( &$jornaleiro){
			$this->sql = "INSERT INTO jornaleiro(tipoPagamento, id_pessoa) VALUES(:tipoPagamento , :id_pessoa)";
			$pessoa = $jornaleiro->getPessoa();
			try{
				if( $pessoa->getId() == 0 ){
					$this->pessoaDAO->adicionar( $pessoa );
				}
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "tipoPagamento"=> $jornaleiro->getTipoPagamento(),
									 "id_pessoa"=> $pessoa->getId()
									));
				$jornaleiro->setId( $this->pdo->lastInsertId());
			}catch( Exception $e){
				throw new DAOException($e);
			}
		}

		function alterar( $jornaleiro){
			$this->sql = "UPDATE jornaleiro SET tipoPagamento = :tipoPagamento , id_pessoa = :id_pessoa WHERE id = :id";
			$pessoa = $jornaleiro->getPessoa();
			try{
				$this->pessoaDAO->alterar( $jornaleiro->getPessoa());
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "tipoPagamento"=>$jornaleiro->getTipoPagamento(),
									 "id_pessoa"=>$pessoa->getId(),
									 "id"=>$jornaleiro->getId()
									));
			}catch( Exception $e){
				throw new DAOException($e);
			}
		}

		function remover( $jornaleiro){
			$this->sql = "DELETE FROM jornaleiro WHERE id = :id ";
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=>$jornaleiro->getId()));
			}catch( Exception $e){
				throw new DAOException($e);
			}
		}

		function comId( $id ){
			$this->sql = "SELECT * FROM jornaleiro WHERE id = :id";
			$jornaleiro = null;
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array("id"=>$id));
				$resultado = $ps->fetchObject();
				$pessoa = $this->pessoaDAO->comId($resultado->id_pessoa);
				$jornaleiro = new Jornaleiro($resultado->tipoPagamento, $pessoa , $resultado->id );
			}catch( Exception $e){
				throw new DAOException($e);
			}
			return $jornaleiro;
		}

		function listar(){
			$this->sql = "SELECT * FROM jornaleiro";
			$jornaleiros = [];
			try{
				$resultado = $this->pdo->query( $this->sql );
				foreach ($resultado as $row) {
					$pessoa = $this->pessoaDAO->comId( $row['id_pessoa']);
					$jornaleiro = new Jornaleiro($row['tipoPagamento'], $pessoa, $row['id']);
					$jornaleiros[] = $jornaleiro ;
				}
			}catch( Exception $e ){
				throw new DAOException($e);
			}

			return $jornaleiros;
		}

	}








?>