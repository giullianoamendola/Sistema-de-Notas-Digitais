<?php

	

	class ControladoraPontoVenda{

		private $pontoVendaDAO ;
		private $jornaleiroDAO ;
		private $bairroDAO ;
		private $geradoraResposta;
		private $enderecoDAO ;

		function __construct( PDO $pdo ,GeradoraResposta $geradoraResposta ){
			$this->pdo = $pdo ;
			$cidadeDAO = new CidadeDAO( $pdo);
	 		$this->bairroDAO = new BairroDAO( $cidadeDAO , $pdo);
	 		$this->enderecoDAO = new EnderecoDAO( $pdo,$this->bairroDAO);
	 		$pessoaDAO = new PessoaDAO( $pdo );
			$this->jornaleiroDAO = new JornaleiroDAO( $pdo, $pessoaDAO);
			$this->pontoVendaDAO = new PontoVendaDAO( $pdo , $this->jornaleiroDAO, $this->enderecoDAO );
			$this->geradoraResposta = $geradoraResposta ;
		}
		
		function listarPontoVenda(){
			
			try{
				$pontosVenda = $this->pontoVendaDAO->listar();
				$this->geradoraResposta->ok( $pontosVenda , GeradoraResposta::TIPO_JSON);			
			}catch( DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);			
			}
		}


		function comId( $params ){
			try{
				$id = $params['id'] ;
				if( is_numeric($id)){
					$pontoVenda =  $this->pontoVendaDAO->comId( $id);
					 return $this->geradoraResposta->ok( $pontoVenda , GeradoraResposta::TIPO_JSON);
				}
				else{
					throw new Exception("Erro ao buscar os Pontos de Venda");
				}
			}catch( DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);			
			}
		}

		function comJornaleiro( $params ){
			try{
				$id_jornaleiro = $params['id'] ;
				if( is_numeric($id_jornaleiro)){
					$pontosVenda = $this->pontoVendaDAO->comJornaleiro( $id_jornaleiro );
					return  $this->geradoraResposta->ok( $pontosVenda , GeradoraResposta::TIPO_JSON);
				}
				else{
					throw new Exception("Erro ao buscar os Pontos de Venda");
				}

			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		function alterar( $params ){
			try{
				if( is_numeric($params['jornaleiro'])){
					$jornaleiro = $this->jornaleiroDAO->comId( $params['jornaleiro'] );
					if( is_numeric( $params['endereco'])){
						$endereco = $this->enderecoDAO->comId( $params['endereco'] );
						if( is_numeric($params['id']) && (strlen($params['nome']) <= 30 ||strlen($params['nome']) > 0 )){
							$pontoVenda = new PontoVenda( $params['nome'] , $jornaleiro, $endereco, $params['id'] );
						}
						else{
							throw new Exception("Erro ao alterar o ponto de venda");
						}
					}
					else{
						throw new Exception("Erro ao buscar o endereco");
					}
				}
				else{
					throw new Exception("Erro ao buscar Jornaleiro");
				}
				
				$pontoVenda = new PontoVenda( $params['nome'] , $jornaleiro, $endereco, $params['id'] );
			
				$this->pontoVendaDAO->alterar( $pontoVenda );
				return  $this->geradoraResposta->semConteudo();
			}catch( DAOExcption $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		function adicionar( $params ){
			try{
				if( is_numeric($params['id_bairro'])){
					$bairro = $this->bairroDAO->comId( $params['id_bairro'] );
					if( is_numeric($params['jornaleiro']) ){
						$jornaleiro = $this->jornaleiroDAO->comId( $params['jornaleiro'] );
						$logradouro = $params['logradouro'];
						$numero = $params['numero'];
						$complemento = $params['complemento'];
						if( (strlen($logradouro) < 30 && strlen($logradouro) > 0) && is_numeric($numero) && (strlen($complemento) < 30 && strlen($complemento) > 0)){
							$endereco = new Endereco( $logradouro, $numero, $complemento, $bairro  );
							$nome = $params['nome'];
							if( (strlen($nome) < 30 && strlen($nome) > 0)){
								$this->enderecoDAO->adicionar( $endereco );
								$pontoVenda = new PontoVenda( $nome, $jornaleiro, $endereco );
								$this->pontoVendaDAO->adicionar( $pontoVenda );
							}
							else{
								throw new Exception("Tamanho do nome invalido");
							}

						}else{
							throw new Exception("Endereco invalido");
						}

					}
					else{
						throw new Exception("Jornaleiro invalido");
					}

				}
				else{
					throw new Exception("Bairro invalido");
				}
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
			}
		}

		

	}








?>