<?php



	class ControladoraItemNota{
		
		private $itemNota; 
		private $geradoraResposta;
	

		function __construct( PDO $pdo, GeradoraResposta $geradoraResposta ){

			$cidadeDAO = new CidadeDAO( $pdo);
	 		$bairroDAO = new BairroDAO( $cidadeDAO , $pdo);
	 		$enderecoDAO = new EnderecoDAO( $pdo,$bairroDAO);
	 		$pessoaDAO = new PessoaDAO( $pdo );
			$jornaleiroDAO = new JornaleiroDAO( $pdo, $pessoaDAO);
			$pontoVendaDAO = new PontoVendaDAO( $pdo , $jornaleiroDAO, $enderecoDAO );
			$notaVendaDAO = new NotaVendaDAO( $pdo , $pontoVendaDAO) ;
			$jornalDAO = new JornalDao( $pdo );
			$precoCapaDAO =  new PrecoCapaDAO( $pdo, $jornalDAO );
			$this->itemNotaDAO = new ItemNotaDAO( $pdo, $precoCapaDAO, $notaVendaDAO );
			$this->geradoraResposta = $geradoraResposta;
		
		}

		function criarItensNota( $params){
			

			$itensNota = $params['itensNota'];
			foreach ($itensNota as $item ) {

				$notaVenda = $item->notaVenda;//REVER ESTA LINHA
				$qtdEntregue = $item->qtdEntregue;
				$precoCapa = $item->precoCapa ;//REVER ESTA LINHA 
				$itemNota = new ItemNota( $item->qtdEntregue, 0, $precoCapa, $notaVenda );  
				$this->itemNotaDAO->adicionar( $itemNota );
			
			}	
				
		}

		function listarItemNota(){

			$itensNota = $this->itemNotaDAO->listar();
			return $this->geradoraResposta->ok( $itensNota, GeradoraResposta::TIPO_JSON);


		}

		function buscarPorNotaVenda( $id ){
			$itensNota = $this->itemNotaDAO->buscarPorNotaVenda( $id );
			return $this->geradoraResposta->ok( $itens, GeradoraResposta::TIPO_JSON);
		}

	}








?>