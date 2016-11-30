<?php



	class ControladoraPrecoCapa{

	private	$precoCapaDAO;
	private $geradoraResposta;
	private $jornalDAO ;

		function __construct( PDO $pdo, GeradoraResposta $geradoraResposta ){
	
			$this->jornalDAO = new JornalDAO( $pdo );
			$this->precoCapaDAO = new PrecoCapaDAO( $pdo, $this->jornalDAO );
			$this->geradoraResposta = $geradoraResposta;
		}

		function listarPrecoCapaDoDia(){
			try{
				$data =  date('d/m/Y');
				$precosCapa = $this->precoCapaDAO->listarPorData( $data );
				return $this->geradoraResposta->ok( $precosCapa, GeradoraResposta::TIPO_JSON );
			}catch( DAOException $e ){
				return $this->geradoraResposta->erro("['ERRO DE ACESSO AO BANCO DE DADOS : ']"+$e->getMessage(),GeradoraResposta::TIPO_JSON );
			}
	

		}

		function listarPrecoCapaPorData(){
			try{

				$data  = date('d/m/Y');
				$precosCapa = $this->precoCapaDAO->listarPorData( $data );
				
				if( $precosCapa == null ){
					
					$data = new DateTime( $data );
  					$data->modify('-1 week');
					$precosCapa = $this->precoCapaDAO->listarPorData( $data->format('d/m/Y') );
					
					if( $precosCapa != null ){
						for($contador = 0 ; $contador < $this->jornalDAO->numeroDeRegistros() ; $contador = $contador + 1 ){
							$precosCapa[$contador]->setId(0);
						}
					}
				}

				return $this->geradoraResposta->ok( $precosCapa, GeradoraResposta::TIPO_JSON );
			
			}catch(DAOException $e ){
				return $this->geradoraResposta->erro("['ERRO DE ACESSO AO BANCO DE DADOS : ']"+$e->getMessage(),GeradoraResposta::TIPO_JSON );
			}
	

		}

		function lancarPrecoCapa( $params ){
			try{

				$precosCapa =  $params['precosCapa'];
				$contador = 0 ;
				$data = date('d/m/Y');
				
				foreach ($precosCapa as $p ) {
					$preco = $p['preco'];
					$id = $p['id'] ;
					$id_jornal = $p['jornal'] ;
					if( is_numeric($preco)  && is_numeric( $id_jornal ) ){
						$jornal = $this->jornalDAO->comId( $id_jornal );
						$precoCapa = new PrecoCapa( $preco, $data,  $jornal, $id );
						$this->precoCapaDAO->lancar( $precoCapa );	
					}
					else{
						throw new Exception("Precos nao sao numericos");
					}

				}

				

			}catch( DAOException $e ){
				return $this->geradoraResposta->erro("['ERRO DE ACESSO AO BANCO DE DADOS : ']"+$e->getMessage(),GeradoraResposta::TIPO_JSON );
			}

			return $this->geradoraResposta->criado(  '["PRECOS LANCADOS : "]',GeradoraResposta::TIPO_JSON);
		}

	}




?>