<?php

	require_once('NotaVendaDAO.php');

		class ControladoraNotaVenda{

			private $notaVendaDAO; 
			private $notaVenda;
			private $geradoraResposta;
			private $pontoVendaDAO;
			private $precoCapaDAO;

			function __construct( PDO $pdo, GeradoraResposta $geradoraResposta ){

				$cidadeDAO = new CidadeDAO( $pdo);
		 		$bairroDAO = new BairroDAO( $cidadeDAO , $pdo);
		 		$enderecoDAO = new EnderecoDAO( $pdo,$bairroDAO);
		 		$pessoaDAO = new PessoaDAO( $pdo );
				$jornaleiroDAO = new JornaleiroDAO( $pdo, $pessoaDAO);
				$jornalDAO = new JornalDAO( $pdo );
				$this->pontoVendaDAO = new PontoVendaDAO( $pdo , $jornaleiroDAO, $enderecoDAO );
				$this->precoCapaDAO = new PrecoCapaDAO( $pdo , $jornalDAO);
				$this->notaVendaDAO = new NotaVendaDAO( $pdo , $this->pontoVendaDAO, $this->precoCapaDAO ) ;
				$this->geradoraResposta = $geradoraResposta;
			
			}

			function criarNotaVenda( $params ){
				try{
					$pontoVenda = $this->pontoVendaDAO->comId( $params['pontoVenda'] );
					$data = $params['dataNota'];
					$dataPgmt = $params['dataPgmt'];
					$itensNotaForm = $params['itensNota'];

					$itensNota = [];
					$MAXITENSPORNOTA = 8;
					for( $contador = 0 ; $contador <  $MAXITENSPORNOTA ; $contador = $contador + 1 ) {
					var_dump($itensNotaForm['precosCapa'][ $contador ]);

						$precoCapa = $this->precoCapaDAO->comId( $itensNotaForm['precosCapa'][ $contador ] );
						$itemNota = new ItemNota( $itensNotaForm['qtdEntregue'][$contador], 0 , $precoCapa );
						$itensNota[] = $itemNota ;
					}


					$notaVenda = new NotaVenda( $data, $dataPgmt, 0.0, $pontoVenda );
					$notaVenda->setItensNota($itensNota);

					$this->notaVendaDAO->adicionar( $notaVenda );

					return $this->geradoraResposta->criado( '',GeradoraResposta::TIPO_TEXTO);	
				}catch( DAOException $e ){

				}	
			}

			function registrarPagamento( $params ){
				try{

					$id_pontovenda = $params['pontoVenda'];
					$pontoVenda = $this->pontoVendaDAO->comId( $id_pontovenda );
					$dataNota = $params['dataNota'];
					$notaVenda = $this->notaVendaDAO->buscarPorPontoEData( $pontoVenda, $dataNota ); 
					$notaVenda->setPaga(1);
					$this->notaVendaDAO->alterar( $notaVenda );
					return $this->geradoraResposta->semConteudo();
				}catch( DAOException $e ){

				}

			}

			function buscarComId( $id ){
				try{
					$notaVenda = $this->notaVendaDAO->comId( $id );
					return $this->geradoraResposta->ok( $notaVenda,GeradoraResposta::TIPO_JSON  );
				}catch( DAOException $e ){

				}
			}

			function buscarPorDataEPontoVenda( $params ){
				try{

					$id_pontovenda = $params['pontoVenda'];
					$pontoVenda = $this->pontoVendaDAO->comId( $id_pontovenda);
					$dataNota = $params['dataNota'];
					$notaVenda = $this->notaVendaDAO->buscarPorPontoEData( $pontoVenda, $dataNota ); 

					return $this->geradoraResposta->ok( $notaVenda, GeradoraResposta::TIPO_JSON );
				}catch(DAOException $e ){
					
				}
			}

			function buscarPorData( $params ){
				try{

					$dataNota = $params['dataNota'];
					$notasVenda = $this->notaVendaDAO->buscarPorData( $dataNota ); 

					return $this->geradoraResposta->ok( $notasVenda, GeradoraResposta::TIPO_JSON );
				}catch(DAOException $e ){
					
				}
			}

			function buscarPorDataENaoPaga( $params ){
				try{

					$dataNota = $params['dataNota'];
					$notasVenda = $this->notaVendaDAO->buscarPorDataENaoPaga( $dataNota ); 

					return $this->geradoraResposta->ok( $notasVenda, GeradoraResposta::TIPO_JSON );
				}catch(DAOException $e ){
					
				}
			}



}




?>