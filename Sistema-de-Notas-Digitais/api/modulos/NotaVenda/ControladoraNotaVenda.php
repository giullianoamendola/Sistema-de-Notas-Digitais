<?php

	require_once('NotaVendaDAO.php');

		class ControladoraNotaVenda{

			private $notaVendaDAO; 
			private $notaVenda;
			private $geradoraResposta;
			private $pontoVendaDAO;
			private $precoCapaDAO;
			private $jornalDAO;
			function __construct( PDO $pdo, GeradoraResposta $geradoraResposta ){

				$cidadeDAO = new CidadeDAO( $pdo);
		 		$bairroDAO = new BairroDAO( $cidadeDAO , $pdo);
		 		$enderecoDAO = new EnderecoDAO( $pdo,$bairroDAO);
		 		$pessoaDAO = new PessoaDAO( $pdo );
				$jornaleiroDAO = new JornaleiroDAO( $pdo, $pessoaDAO);
				$this->jornalDAO = new JornalDAO( $pdo );
				$this->pontoVendaDAO = new PontoVendaDAO( $pdo , $jornaleiroDAO, $enderecoDAO );
				$this->precoCapaDAO = new PrecoCapaDAO( $pdo , $this->jornalDAO);
				$this->notaVendaDAO = new NotaVendaDAO( $pdo , $this->pontoVendaDAO, $this->precoCapaDAO ) ;
				$this->geradoraResposta = $geradoraResposta;
			
			}

			function criarNotaVenda( $params ){
				try{
					$pontoVenda = $this->pontoVendaDAO->comId( $params['pontoVenda'] );
					$dataPgmt = $this->calcularPagamento( $pontoVenda->getJornaleiro() );
					$data = $params['dataNota'];
				/*	$data = explode("/", $data );
					$data = implode("", $data );
					var_dump($data);*/
					$itensNotaForm = $params['itensNota'];

					$itensNota = [];
					$numeroDeJornais =(int) $this->jornalDAO->numeroDeRegistros();
					for( $contador = 0 ; $contador <  $numeroDeJornais ; $contador = $contador + 1 ) {

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
					$this->notaVendaDAO->registrarPagamento( $notaVenda );
					return $this->geradoraResposta->semConteudo();
				}catch( DAOException $e ){

				}

			}

			function registrarVenda( $params ){
				try{
					$id_notaVenda = $params['id'];
					$notaVenda = $this->notaVendaDAO->comId( $id_notaVenda );
					$itensNota = $notaVenda->getItensNota() ;
					$numeroDeJornais =(int) $this->jornalDAO->numeroDeRegistros();
					$itensForm =  $params["itensNota"] ;
					for( $contador = 0 ; $contador < $numeroDeJornais ; $contador ++){
						$row =  $itensForm[$contador] ;
						$itemNota = $itensNota[$contador] ;
						$itemNota->setQtdVendido( $row['qtdVendido']);
						$itensNota[$contador] = $itemNota ;
					}
					$notaVenda->setItensNota( $itensNota );
					$this->notaVendaDAO->registrarVenda( $notaVenda );
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
					$pontoVenda = $this->pontoVendaDAO->comId( (int)$id_pontovenda);
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

			function alterarNotaVenda( $params ){
				try{

					$dataPgmt = $params['dataPgmt'];
					$id = $params['id'];
					$itensNota = [] ;
					foreach ( $params['itensNota'] as $itemNota) {

						$itensNota[] = new ItemNota( $itemNota[0], $itemNota[1], null ,(int) $itemNota[2]);
					}

					$notaVenda = new NotaVenda( null, $dataPgmt, 0, null, $id, $itensNota );
					$this->notaVendaDAO->alterar( $notaVenda );

				}catch( DAOException $e ){

				}

			}

			function excluirNotaVenda( $params ){
				try{

					$id = $params['id'];
					$notaVenda = $this->notaVendaDAO->comId( $id );
					$this->notaVendaDAO->remover( $notaVenda );
					
				}catch( DAOException $e  ){

				}
			}

			private function calcularPagamento( $jornaleiro ){
				
				$tipoPagamento = $jornaleiro->getTipoPagamento();
				$dataPgmt =  date('dmy');
				$dataPgmt = new DateTime( $dataPgmt );
				
				switch ($tipoPagamento) {
					case 1 :
							$dataPgmt->modify('+1 day');
							break;

					case 2 : 
							$dataPgmt->modify('+1 week');
							break;
					case 3 :
							$dataPgmt->modify('+1 month');	
							break;
					default:
							
						break;
				}
				return $dataPgmt->format('dmY'); ;
			}



			

}




?>