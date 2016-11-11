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
				$data =  date('dmy');
				$precosCapa = $this->precoCapaDAO->listarPorData( $data );
				return $this->geradoraResposta->ok( $precosCapa, GeradoraResposta::TIPO_JSON );
			}catch( DAOException $e ){
				
			}
	

		}

		function listarPrecoCapaPorData(){
			try{
				$data  = date('dmy');

				$precosCapa = $this->precoCapaDAO->listarPorData( $data );
				
				if( $precosCapa == null ){
					$data = new DateTime( $data );
  					$data->modify('-1 week');
					$precosCapa = $this->precoCapaDAO->listarPorData( $data->format('dmY') );
				}

				return $this->geradoraResposta->ok( $precosCapa, GeradoraResposta::TIPO_JSON );
			}catch(DAOException $e ){
				
			}
	

		}


		function lancarPrecoCapa( $params ){
			try{
				$precosCapa = $params['precosCapa'];
				$jornais = $params['jornais'];
				$contador = 0 ;
				$data = date('dmy');

				for ($contador=0; $contador < 9 ; $contador++) { 
					

					$preco = $precosCapa[$contador][0];
					$id = $precosCapa[$contador][1];
					$jornal = $this->jornalDAO->comId( $jornais[$contador]);
					$precoCapa = new PrecoCapa( $preco, $data,  $jornal, $id );
					$this->precoCapaDAO->lancar( $precoCapa );
				}

			}catch( DAOException $e ){

			}

			return $this->geradoraResposta->criado( 'PRECOS LANCADA ',GeradoraResposta::TIPO_TEXTO);
		}

	}




?>

