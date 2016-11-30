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

					if( is_numeric($params['pontoVenda'])){
						$pontoVenda = $this->pontoVendaDAO->comId( $params['pontoVenda'] );
					}
					else{ 
						throw new DAOException("Forneca o ponto de Venda corretamente", 1);
					}

					$dataPgmt = $this->calcularPagamento( $pontoVenda->getJornaleiro() );
					$data =  date('d/m/Y');
					$itensNotaForm = $params['itensNota'];
					$itensNota = [];
					$numeroDeJornais =(int) $this->jornalDAO->numeroDeRegistros();
					for( $contador = 0 ; $contador <  $numeroDeJornais ; $contador = $contador + 1 ) {
							if(is_numeric($itensNotaForm['precosCapa'][ $contador ]) && is_numeric($itensNotaForm['qtdEntregue'][$contador]) ){
								$precoCapa = $this->precoCapaDAO->comId( $itensNotaForm['precosCapa'][ $contador ] );
								$itemNota = new ItemNota( $itensNotaForm['qtdEntregue'][$contador], 0 , $precoCapa );
								$itensNota[] = $itemNota ;
							}
							else{ throw new DAOException("Os precos e as quantidades devem ser numericos", 1);
							}
					}
				
					$notaVenda = new NotaVenda( $data, $dataPgmt, 0.0, $pontoVenda );
					$notaVenda->setItensNota($itensNota);
					$this->notaVendaDAO->adicionar( $notaVenda );

					return $this->geradoraResposta->criado( '',GeradoraResposta::TIPO_TEXTO);	
				}catch( DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}	
			}



			function registrarPagamento( $params ){
				try{
					$id_pontovenda = $params['pontoVenda'];
					if( is_numeric( $id_pontovenda ) ){
						$pontoVenda = $this->pontoVendaDAO->comId( $id_pontovenda );
						$dataNota = $params['dataNota'];
						$notaVenda = $this->notaVendaDAO->buscarPorPontoEData( $pontoVenda, $dataNota );
						$notaVenda->setPaga(1);
						$this->notaVendaDAO->registrarPagamento( $notaVenda );
						return $this->geradoraResposta->semConteudo();
					}
					else{
						throw new DAOException("Forneca o ponto de Venda Corretamente");
					}
				}catch( DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}

			}

			function registrarVenda( $params ){
				try{
					$id_notaVenda = $params['id'];
					if( is_numeric($id_notaVenda)){
						$notaVenda = $this->notaVendaDAO->comId( $id_notaVenda );
						$itensNota = $notaVenda->getItensNota() ;
						$numeroDeJornais =(int) $this->jornalDAO->numeroDeRegistros();
						$itensForm =  $params["itensNota"] ;
						for( $contador = 0 ; $contador < $numeroDeJornais ; $contador ++){
							$row =  $itensForm[$contador] ;
							if( is_numeric($row['qtdVendido']) ){
								$itemNota = $itensNota[$contador] ;
								if( $itemNota->getQtdEntregue() >= $row['qtdVendido']){
									$itemNota->setQtdVendido( $row['qtdVendido']);
									$itensNota[$contador] = $itemNota ;
								}
								else{
									throw new Exception("A quantidade de vendidos nao pode ser maior que a quantidade de entregues");
								}
							}
							else{
								throw new DAOException("A quantidade vendida deve ser um numero !");
							}
						}
						$notaVenda->setItensNota( $itensNota );
						$this->notaVendaDAO->registrarVenda( $notaVenda );
						return $this->geradoraResposta->semConteudo();
					}
					else{
						throw new DAOException("Nota de Venda incorreta");
						
					}
				}catch( DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}

			}

			function buscarComId( $id ){
				try{
					if( is_numeric($id )){
						$notaVenda = $this->notaVendaDAO->comId( $id );
						return $this->geradoraResposta->ok( $notaVenda,GeradoraResposta::TIPO_JSON);
					}
					else{
						throw new Exception("Erro ao buscar a Nota de Venda");
					}
				}catch( DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}
			}

			function buscarPorDataEPontoVenda( $params ){
				try{

					$id_pontovenda = $params['pontoVenda'];
					if( is_numeric( $id_pontovenda )){
						$pontoVenda = $this->pontoVendaDAO->comId( (int)$id_pontovenda);
					}
					else{ throw new Exception("Erro ao buscar a Nota de Venda");}
					$dataNota = $params['dataNota'];
					if( preg_match(self::ER_DATA , $dataNota  )){	
						$notaVenda = $this->notaVendaDAO->buscarPorPontoEData( $pontoVenda, $dataNota ); 
						return $this->geradoraResposta->ok( $notaVenda, GeradoraResposta::TIPO_JSON );
					}
					else{ throw new Exception("Erro ao buscar a Nota de Venda"); }
					
				}catch(DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}
			}

			function buscarPorData( $params ){
				try{
					$dataNota = $params['dataNota'];
				if( preg_match( self::ER_DATA , $dataNota  )){
					$notasVenda = $this->notaVendaDAO->buscarPorData( $dataNota ); 
					return $this->geradoraResposta->ok( $notasVenda, GeradoraResposta::TIPO_JSON );
				}
				else{
						throw new DAOException("Forneca a data Corretamente");
					
					}			
				}catch(DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}
			}

			function buscarPorDataENaoPaga( $params ){
				try{
					$dataNota = $params['dataNota'];
					if( preg_match( self::ER_DATA , $dataNota  )){
						
						$notasVenda = $this->notaVendaDAO->buscarPorDataENaoPaga( $dataNota ); 
						return $this->geradoraResposta->ok( $notasVenda, GeradoraResposta::TIPO_JSON );
					}
					else{
						throw new DAOException("Forneca a data Corretamente");
					}
				}catch(DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}
			}

			function buscarNotasDoDia(){
				try{
					$data = [ "dataNota" => date('d/m/Y') ];
					$this->buscarPorData( $data );

				}catch( DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}
			}

			function alterarNotaVenda( $params ){
				try{

					$dataPgmt = $params['dataPgmt'];

					if( preg_match( self::ER_DATA , $dataPgmt  )){
						$id = $params['id'];
						if( is_numeric($id)){
							$itensNota = [] ;
							foreach ( $params['itensNota'] as $itemNota) {

								$itensNota[] = new ItemNota( $itemNota[0], $itemNota[1], null ,(int) $itemNota[2]);
							}

							$notaVenda = new NotaVenda( null, $dataPgmt, 0, null, $id, $itensNota );
							$this->notaVendaDAO->alterar( $notaVenda );
						}
						else{
							throw new DAOException("Erro ao alterar a nota de venda");
						}

					}

					else{
						throw new DAOException("Forneca a data Corretamente");
					}
				}catch( DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}

			}

			function excluirNotaVenda( $params ){
				try{
					$id = $params['id'];
					if( is_numeric($id )){
						$notaVenda = $this->notaVendaDAO->comId( $id );
						$this->notaVendaDAO->remover( $notaVenda );
					}
						
				}catch( DAOException $e  ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}
			}

			function pontosVendaSemNotaDoDia(){
				$data = date('d/m/Y');
				
				try{
					$notasVenda = $this->notaVendaDAO->buscarPorData( $data );
					$pontosVenda = $this->pontoVendaDAO->listar();
					$pontosComNota = [] ;
					$pontosSemNota = [] ;

					foreach ($notasVenda as $notaVenda ) {
							$pontosComNota[] = $notaVenda->getPontoVenda();
					}

					foreach ($pontosVenda as $pontoVenda ) {
							if( ! in_array( $pontoVenda, $pontosComNota )){
								$pontosSemNota[] = $pontoVenda ;
							}
					}

					return $this->geradoraResposta->ok( $pontosSemNota, GeradoraResposta::TIPO_JSON );

				}catch( DAOException $e ){
					return $this->geradoraResposta->erro( $e->getMessage(), GeradoraResposta::TIPO_TEXTO);
				}
			}

			private function calcularPagamento( $jornaleiro ){
				
				$tipoPagamento = $jornaleiro->getTipoPagamento();
				$dataPgmt = new DateTime(null );
				
				switch ($tipoPagamento) {
					case 1 :
							$dataPgmt->modify('+1 day');
							break;

					case 2 : 
							$dataPgmt->modify('+1 week');
							break;

					default:
							
						break;
				}
				return $dataPgmt->format('d/m/Y'); ;
			}

	const ER_DATA = "/^\d{2}\/\d{2}\/\d{4}$/";

}




?>