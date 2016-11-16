<?php
	/*

		


	*/
	require_once('PessoaJuridica.php');
	require_once('PessoaFisica.php');
	require_once('DAO.php');

	class PessoaDAO implements DAO{

		private $sql;
		private $pdo;

		function __construct( PDO $pdo ){
			$this->pdo = $pdo;
		}

		function adicionar( &$pessoa ){
			$tipo = '';
			if( $pessoa instanceOf  PessoaFisica){
				$tipo = "fisica";
				var_dump("Aqui!");
				$this->sql = "INSERT INTO pessoa( nome, email, telefone, rg, cpf, tipo) VALUES( :nome, :email, :telefone, :rg, :cpf, :tipo)";
				
				try{
					$ps = $this->pdo->prepare( $this->sql );
					$ps->execute(array("nome"=>$pessoa->getNome(),
										"email"=>$pessoa->getEmail(),
										"telefone"=>$pessoa->getTelefone(),
										"rg"=>$pessoa->getRg(),
										"cpf"=>$pessoa->getCpf(),
										"tipo"=>$tipo
						));
					$pessoa->setId( $this->pdo->lastInsertId());
				}catch( Exception $e){
					throw new DAOExcpetion( $e );
				}
			}
			if( $pessoa instanceOf PessoaJuridica){
				$tipo = "juridica";
				$this->sql = "INSERT INTO pessoa( nome, email, telefone, nomeContato, cnpj, tipo) VALUES( :nome, :email, :telefone, :nomeContato, :cnpj, :tipo)";
				try{
					$ps = $this->pdo->prepare( $this->sql );
					$ps->execute( array( "nome"=>$pessoa->getNome(),
										 "email"=>$pessoa->getEmail(),
										  "telefone"=>$pessoa->getTelefone(),
										  "nomeContato"=>$pessoa->getNomeContato(),
										  "cnpj"=>$pessoa->getCnpj(),
										  "tipo"=>$tipo
								));
				}catch( Exception $e ){
					throw new DAOException( $e );
				}
			}
		}

		function alterar($pessoa){

			if( $pessoa instanceOf PessoaFisica ){
				$this->sql = "UPDATE pessoa SET nome = :nome , email = :email , telefone = :telefone , cpf = :cpf , rg = :rg WHERE id = :id";

				try{
					$ps = $this->pdo->prepare( $this->sql);
					$ps->execute( array( "nome"=> $pessoa->getNome(),
										 "email"=> $pessoa->getEmail(),
										 "telefone"=>$pessoa->getTelefone(),
										 "cpf"=>$pessoa->getCpf(),
										 "rg"=>$pessoa->getRg(),
										 "id"=>$pessoa->getId()
										));


				}catch( Exception $e){
					throw new DAOException($e);
				}	
			}	
			if( $pessoa instanceOf PessoaJuridica){
				$this->sql = "UPDATE pessoa SET nome = :nome , email = :email , telefone = :telefone , cnpj = :cnpj , nomeContato = :nomeContato WHERE id = :id";
				try{
					$ps = $this->pdo->prepare( $this->sql);
					$ps->execute( array("nome"=>$pessoa->getNome(),
										"emai"=>$pessoa->getEmail(),
										"telefone"=>$pessoa->getTelefone(),
										"cnpj"=>$pessoa->getCnpj(),
										"nomeContato"=>$pessoa->getNomeContato(),
										"id"=>$pessoa->getId()
										));
				}catch( Exception $e){
					throw new DAOException( $e );
				}
			}
			
			
		}
		function remover($pessoa){
			$this->sql = "DELETE FROM pessoa WHERE id = :id";
			try{
				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array("id"=> $pessoa->getId()));
			}catch( Exception $e){
				throw new DAOException($e);
			}
		}
		function comId( $id ){
			$this->sql = "SELECT * FROM pessoa WHERE id = :id";
			$pessoa = null;
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=> $id ));
				$resultado = $ps->fetchObject();
				if( $resultado->tipo === "fisica"){
					$pessoa = new PessoaFisica();
					$pessoa->setNome( $resultado->nome);
					$pessoa->setEmail($resultado->email);
					$pessoa->setTelefone($resultado->telefone);
					$pessoa->setRg( $resultado->rg);
					$pessoa->setCpf($resultado->cpf);
					$pessoa->setId($resultado->id);
				}
				if( $resultado->tipo === "juridica"){
					$pessoa = new PessoaJuridica();
					$pessoa->setNome( $resultado->nome);
					$pessoa->setEmail($resultado->email);
					$pessoa->setTelefone($resultado->telefone);
					$pessoa->setCnpj( $resultado->cnpj);
					$pessoa->setNomeContato($resultado->nomeContato);
					$pessoa->setId($resultado->id);
				}

			}catch( Exception $e){
				throw new DAOException( $e );
			}
			return $pessoa;
		}
		function listar(){
			$this->sql = "SELECT * FROM pessoa";
			$pessoas = [];
			try{
				$resultado = $this->pdo->query( $this->sql );
				foreach ($resultado as $row) {
					$pessoa = null ;
					if( $row['tipo'] === "fisica"){
						$pessoa = new PessoaFisica();
						$pessoa->setNome( $row['nome']);
						$pessoa->setEmail($row['email']);
						$pessoa->setTelefone($row['telefone']);
						$pessoa->setCpf( $row['cpf']);
						$pessoa->setRg($row['rg']);
						$pessoa->setId($row['id']);
					}
					if( $row['tipo'] === "juridica"){
						$pessoa = new PessoaJuridica();
						$pessoa->setNome( $row['nome']);
						$pessoa->setEmail($row['email']);
						$pessoa->setTelefone($row['telefone']);
						$pessoa->setCnpj( $row['cnpj']);
						$pessoa->setNomeContato($row['nomeContato']);
						$pessoa->setId($row['id']);
					}
					
					$pessoas[] = $pessoa ;

				}
			}catch( Exception $e){
				throw new DAOException( $e );
			}




			return $pessoas;
		}
	}




?>