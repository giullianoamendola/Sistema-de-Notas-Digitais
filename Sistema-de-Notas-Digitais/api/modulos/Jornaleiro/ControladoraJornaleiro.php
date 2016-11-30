<?php

	class ControladoraJornaleiro{

		private $jornaleiroDAO ;
		private $geradoraResposta ;

		function __construct( PDO $pdo , $geradoraResposta ){
			$pessoaDAO = new PessoaDAO( $pdo );
			$this->jornaleiroDAO = new JornaleiroDAO( $pdo , $pessoaDAO );
			$this->geradoraResposta = $geradoraResposta ;
		}

		function listar(){
			try{
				$jornaleiros = $this->jornaleiroDAO->listar();
				return $this->geradoraResposta->ok( $jornaleiros, GeradoraResposta::TIPO_JSON);
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		function adicionar( $params ){
			try{
				$tipoPessoa = $params['tipoPessoa'];
				$tipoPagamento = $params['tipoPagamento'];
				$pessoa = null ;
				if( $tipoPessoa == 1 ){
					$rg =  $params['rg'];
					$cpf = $params['cpf'] ;
					$nome = $params['nome'] ;
					$email = $params['email'];
					$telefone = $params['telefone'];
					if( preg_match(self::ER_RG, $rg ) ){
						if( preg_match(self::ER_CPF, $cpf ) ){
							if( preg_match(self::ER_EMAIL, $email )){
								if( preg_match(self::ER_TELEFONE, $telefone) ){
									if( strlen($nome) <= 30 && strlen($nome) > 0  ){
										$pessoa = new PessoaFisica( $rg, $cpf );
										$pessoa->setNome( $nome );
										$pessoa->setEmail( $email );
										$pessoa->setTelefone( $telefone );							
									}
									else{
										throw new Exception("Tamanho do nome invalido");
									}
								}
								else{
									throw new Exception("Telefone invalido");		
								}
							}
							else{
								throw new Exception("Email invalido");
							}
						}
						else{
							throw new Exception("CPF invalido");
						}

					}
					else{
						throw new Exception("RG invalido");
					}

				}

				if( $tipoPessoa == 2 ){
					$nomeContato =  $params['nomeContato'];
					$cnpj = $params['cnpj'] ;
					$nome = $params['nome'] ;
					$email = $params['email'];
					$telefone = $params['telefone'];
					if(  strlen($nomeContato) <= 30 && strlen($nomeContato) > 0 ){
						if( preg_match(self::ER_CNPJ, $cnpj ) ){
							if( preg_match(self::ER_EMAIL, $email )){
								if( preg_match(self::ER_TELEFONE, $telefone) ){
									if( strlen($nome) <= 30 && strlen($nome) > 0 ){
										$pessoa = new PessoaJuridica( $nomeContato, $cnpj );
										$pessoa->setNome( $nome );
										$pessoa->setEmail( $email );
										$pessoa->setTelefone( $telefone );							
									}
									else{
										throw new Exception("Tamanho do nome invalido");
									}
								}
								else{
									throw new Exception("Telefone invalido");		
								}
							}
							else{
								throw new Exception("Email invalido");
							}
						}
						else{
							throw new Exception("CNPJ invalidos");
						}

					}
					else{
						throw new Exception("Tamanho do nome de contato e invalido ");
					}

				}

				$jornaleiro = new Jornaleiro( $tipoPagamento, $pessoa );
				$this->jornaleiroDAO->adicionar( $jornaleiro );
				return $this->geradoraResposta->criado('', GeradoraResposta::TIPO_TEXTO );
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		function alterar( $params ){
			try{
					
				$tipoPessoa = $params['tipoPessoa'];
				$tipoPagamento = $params['tipoPagamento'];
				$pessoa = null ;
				if( $tipoPessoa == 1 ){
					$rg =  $params['rg'];
					$cpf = $params['cpf'] ;
					$nome = $params['nome'] ;
					$email = $params['email'];
					$telefone = $params['telefone'];
					if( preg_match(self::ER_RG, $rg ) ){
						if( preg_match(self::ER_CPF, $cpf ) ){
							if( preg_match(self::ER_EMAIL, $email )){
								if( preg_match(self::ER_TELEFONE, $telefone) ){
									if( strlen($nome) <= 30 && strlen($nome) > 0  ){
										$pessoa = new PessoaFisica( $rg, $cpf );
										$pessoa->setNome( $nome );
										$pessoa->setEmail( $email );
										$pessoa->setTelefone( $telefone );							
									}
									else{
										throw new Exception("Tamanho do nome invalido");
									}
								}
								else{
									throw new Exception("Telefone invalido");		
								}
							}
							else{
								throw new Exception("Email invalido");
							}
						}
						else{
							throw new Exception("CPF invalido");
						}

					}
					else{
						throw new Exception("RG invalido");
					}

				}

				if( $tipoPessoa == 2 ){
					$nomeContato =  $params['nomeContato'];
					$cnpj = $params['cnpj'] ;
					$nome = $params['nome'] ;
					$email = $params['email'];
					$telefone = $params['telefone'];
					if(  strlen($nomeContato) <= 30 && strlen($nomeContato) > 0 ){
						if( preg_match(self::ER_CNPJ, $cnpj ) ){
							if( preg_match(self::ER_EMAIL, $email )){
								if( preg_match(self::ER_TELEFONE, $telefone) ){
									if( strlen($nome) <= 30 && strlen($nome) > 0 ){
										$pessoa = new PessoaJuridica( $nomeContato, $cnpj );
										$pessoa->setNome( $nome );
										$pessoa->setEmail( $email );
										$pessoa->setTelefone( $telefone );							
									}
									else{
										throw new Exception("Tamanho do nome invalido");
									}
								}
								else{
									throw new Exception("Telefone invalido");		
								}
							}
							else{
								throw new Exception("Email invalido");
							}
						}
						else{
							throw new Exception("CNPJ invalidos");
						}

					}
					else{
						throw new Exception("Tamanho do nome de contato e invalido ");
					}

				}

				$jornaleiro = new Jornaleiro( $tipoPagamento, $pessoa , $id );
				$this->jornaleiroDAO->alterar( $jornaleiro );
				return $this->geradoraResposta->semConteudo();
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		function comId( $id ){
			try{
				if( is_numeric($id) ){
					$jornaleiro = $this->jornaleiroDAO->comId( $id );
				}
				else{
					throw new Exception("Erro ao Buscar os Jornais");
				}
				return $this->geradoraResposta->ok( $jornaleiro , GeradoraResposta::TIPO_JSON);
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		function excluir( $params ){
			try{
				$id = $params['id'];
				$jornaleiro = $this->jornaleiroDAO->comId( $id );
				$this->jornaleiroDAO->remover( $jornaleiro );
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro("['Login Invalido : ']"+$e->getMessage(),GeradoraResposta::TIPO_JSON );
			}
		}
		
		const ER_RG = "/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}-[0-9]{1}/";
		const ER_CPF = "/^[0-9]{2}\.[0-9]{3}-[0-9]{3}/";
		const ER_CNPJ = "/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}-[0-9]{2}/";
		const ER_EMAIL = "/^[A-Za-z0-9_.-]+@[A-Za-z0-9_]+\.[A-Za-z]{2,4}/";
		const ER_TELEFONE = "/^[0-9]{4}-[0-9]{4}/";
	}








?>