<?php


	class EnderecoDAO implements DAO{

		private $pdo;
		private $sql;
		private $bairroDAO;

		function __construct( PDO $pdo, BairroDAO $bairroDAO){
			$this->pdo =  $pdo;
			$this->bairroDAO = $bairroDAO;
		}
		function adicionar( &$endereco ){
			$this->sql = "INSERT INTO endereco( logradouro, numero, complemento, id_bairro) VALUES(:logradouro, :numero, :complemento, :id_bairro)";
			$bairro = $endereco->getBairro();
			//var_dump($bairro);
			try{
				$ps = $this->pdo->prepare( $this->sql);
				
				$ps->execute( array(
									 "logradouro"=>$endereco->getLogradouro(),
									 "numero"=>$endereco->getNumero(),
									 "complemento"=> $endereco->getComplemento(),
									 "id_bairro"=> $bairro->getId()
				 					));
				$endereco->setId( $this->pdo->lastInsertId());
				//var_dump( $this->pdo->lastInsertId());
				var_dump( $endereco);
			}catch( Exception $e){
				echo 'Lancou Excecao';
				die();
				throw new DAOException($e);
			}

		}

		function remover($endereco){
			$this->sql = "DELETE FROM endereco WHERE id = :id";
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=>$endereco->getId()));

			}catch(Exception $e){
				throw new DAOException($e);
			}
		}
		function alterar($endereco){
			$this->sql = "UPDATE enderero SET logradouro = :logradouro , numero = :numero , complemento = :complemento , id_bairro = :id_bairro WHERE id = :id ";
			$bairro = $endereco->getBairro();
			var_dump($endereco);
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "logradouro" =>$endereco->getLogradouro(),
									 "numero"=> $endereco->getNumero(),
									 "complemento"=> $endereco->getComplemento(),
									 "id_bairro"=> $bairro->getId(),
									 "id"=> $endereco->getId()
							 ));
			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}
		function comId( $id){
			$this->sql = "SELECT * FROM endereco WHERE id = :id";
			$endereco = null ;
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=> $id));
				$resultado = $ps->fetchObject();;
				$bairro = $this->bairroDAO->comId( $resultado->id_bairro);
				$endereco = new Endereco( $resultado->logradouro, $resultado->numero, $resultado->complemento, $bairro, $resultado->id);	

			}catch( Exception $e){
				throw new DAOException( $e);
			}
			return $endereco;
		}
		function listar(){
			$this->sql = "SELECT * FROM endereco";
			$enderecos = [];
			try{
				$resultado = $this->pdo->query($this->sql);
				foreach( $resultado as $row){
					$bairro = $this->bairroDAO->comId( $row['id_bairro']);
					$endereco = new Endereco( $row['logradouro'], $row['numero'], $row['complemento'], $bairro, $row['id']);
					$enderecos[] = $endereco;
				}
			}catch( Execption $e ){
				throw new DAOException( $e);
			}
			return $enderecos;
		}
	}





?>