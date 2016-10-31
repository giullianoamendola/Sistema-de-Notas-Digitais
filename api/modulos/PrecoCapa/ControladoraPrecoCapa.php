<?php



	class ControladoraPrecoCapa{

	private	$precoCapaDAO;
	private $geradoraResposta;

		function __construct( PDO $pdo, GeradoraResposta $geradoraResposta ){
	
			$jornalDAO = new JornalDAO( $pdo );
			$this->precoCapaDAO = new PrecoCapaDAO( $pdo, $jornalDAO );
			$this->geradoraResposta = $geradoraResposta;
		}

		function listarPrecoCapa(){
			try{
				$precosCapa = $this->precoCapaDAO->listar();
				//$this->geradoraResposta->ok( $precosCapa, GeradoraResposta::TIPO_JSON );

				$msg ='<table class = "table" border ="1" id = "itemNota">
					<thead> 
						<tr> <th> Jornal </th> <th>Preco </th> <th> Entregue</th> </tr>
					</thead>
					<tbody>
				';
				
				$contagem = 0 ;

				foreach( $precosCapa as $preco){
					$jornal = $preco->getJornal();

					$msg .= '<tr>
								<td>'.$jornal->getNome().'</td>
								<td>'.$preco->getPreco().'</td>
								<td>
									 <input type="text" id =entregue_'.$contagem.' > 
									 <input type="hidden" id =precoCapa_'.$contagem.' value = "'.$preco->getId().'" >
								</td>
							 </tr>';
					
					$contagem = $contagem + 1 ;
				}

				$msg .= '</tbody>
					    </table>
					    ';
				return $msg;
			}catch(DAOException $e ){
				
			}
		//retornar a msg ;

	

		}



	}














?>