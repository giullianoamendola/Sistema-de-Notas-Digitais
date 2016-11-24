<?php


	class NotaVendaDAO implements DAO{

		private $pdo;
		private $pontoVendaDAO;
		private $precoCapaDAO;
		private $sql;

		function __construct( PDO $pdo, PontoVendaDAO $pontoVendaDAO , PrecoCapaDAO $precoCapaDAO){

			$this->pdo = $pdo ;
			$this->pontoVendaDAO = $pontoVendaDAO;
			$this->precoCapaDAO = $precoCapaDAO ;
		}

		function adicionar( &$notaVenda ){
			
			$pontoVenda = $notaVenda->getPontoVenda();
/*
			try{
				$notaExistente = $this->buscarPorPontoEData( $pontoVenda , $notaVenda->getDataNota() );
				if( $notaExistente != null){
					return ...
				}

			}catch( Exception $e ){
				throw new DAOException ( $e );
			}
*/	
			$this->sql  = "INSERT INTO notaVenda( dataNota, dataPgmt, comissao, id_pontoVenda) VALUES( :dataNota, :dataPgmt, :comissao, :id_pontoVenda) ";
			$pontoVenda = $notaVenda->getPontoVenda();
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "dataNota"=> $notaVenda->getDataNota(),
									 "dataPgmt"=> $notaVenda->getDataPgmt(),
									 "comissao"=> $notaVenda->getComissao(),
									 "id_pontoVenda"=> $pontoVenda->getId()

									));
				$notaVenda->setId( $this->pdo->lastInsertId());
			}catch( Exception $e){
				throw new DAOException( $e );
			}

			$this->sql = "INSERT INTO itemNota( qtdEntregue, qtdVendido, id_precoCapa , id_notaVenda) VALUES( :qtdEntregue, :qtdVendido , :id_precoCapa , :id_notaVenda)";
			
			$id_notaVenda =(int) $notaVenda->getId();
			$itensNota = $notaVenda->getItensNota();
			$contador = 0;
			$numeroDeJornais = 5;//MUDAR DEPOIS PEGAR DO BANCO
			for($contador = 0 ; $contador < $numeroDeJornais ; $contador = $contador +1  ) {

					$itemNota = $itensNota[$contador];
					$precoCapa = $itemNota->getPrecoCapa();
					$notaVenda = $itemNota->getNotaVenda();
					try{
						$ps = $this->pdo->prepare( $this->sql );
						$ps->execute( array( "qtdEntregue"=>$itemNota->getQtdEntregue(),
											 "qtdVendido"=>$itemNota->getQtdVendido(),
											 "id_precoCapa"=> $precoCapa->getId(),
											 "id_notaVenda"=> $id_notaVenda
											));
						$itemNota->setId( $this->pdo->lastInsertId());
					}catch( Exception $e ){
						throw new DAOException( $e );
					}

			}
		}

		function alterar( $notaVenda ){
			$this->sql = "UPDATE notaVenda SET dataPgmt = :dataPgmt  WHERE id = :id ";

			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "dataPgmt"=> $notaVenda->getDataPgmt(),
									 "id"=>$notaVenda->getId()
									));

				$this->sql = "UPDATE itemNota SET qtdEntregue = :qtdEntregue , qtdVendido = :qtdVendido WHERE id = :id ";
				
				$itensNota = $notaVenda->getItensNota();
				
				foreach ($itensNota as $itemNota ) {
					var_dump($itemNota);
					$ps = $this->pdo->prepare($this->sql);
					$ok = $ps->execute( array( "qtdEntregue"=> $itemNota->getQtdEntregue(),
									 	 "qtdVendido"=> $itemNota->getQtdVendido(),
									 	 "id"=> $itemNota->getId()
									    ));
					var_dump($ok);
				}

			}catch( Exception $e ){
				throw new DAOException( $e );
			}
		}

		function remover( $notaVenda ){
			$this->sql = "DELETE FROM notaVenda WHERE id =:id ";
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=>$notaVenda->getId()));
			}catch( Exception $e){
				throw new DAOException( $e );
			}
		}

		function comId( $id ){
			$this->sql = "SELECT * FROM notaVenda WHERE id = :id ";
			$notaVenda = null ;

			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id"=> $id));
				$resultado = $ps->fetchObject();
				$pontoVenda = $this->pontoVendaDAO->comId( $resultado->id_pontovenda);
				$notaVenda = new NotaVenda( $resultado->dataNota, $resultado->dataPgmt, $resultado->comissao, $pontoVenda, $resultado->id);
				$this->sql = "SELECT * FROM itemNota WHERE id_notaVenda = :id_notaVenda";
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( "id_notaVenda"=> $notaVenda->getId()));
				$resultado = $ps->fetchAll();
				$itensNota = [] ;
				foreach ($resultado as $row ) {

					$precoCapa = $this->precoCapaDAO->comId( $row['id_precocapa'] );

					$itemNota = new ItemNota( $row['qtdEntregue'],$row['qtdVendido'] ,$precoCapa , $row['id']);

					$itensNota[] = $itemNota ; 
				}
				$notaVenda->setItensNota( $itensNota );
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			return $notaVenda;
		}

		function listar(){
			$this->sql = "SELECT * FROM notaVenda";
			$notasVenda = [];
			try{
				$resultado = $this->pdo->query( $this->sql );
				foreach( $resultado as $row){
					$pontoVenda = $this->pontoVendaDAO->comId( $row['id_pontoVenda']);
					$notaVenda = new NotaVenda($row['dataNota'], $row['dataPgmt'], $row['comissao'], $pontoVenda, $row['id']  );
					$notasVenda[] = $notaVenda; 
				}
			}catch( Exception $e){
				throw new DAOException( $e );
			}

			return $notasVenda;
		}

		function buscarPorPontoEData( $pontoVenda, $dataNota ){
			$this->sql = "SELECT * FROM notaVenda WHERE id_pontoVenda = :id_pontoVenda AND dataNota = :dataNota";
			$notaVenda = null ;
			$itensNota = [] ;
			try{

				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute( array( "id_pontoVenda"=> $pontoVenda->getId() , "dataNota"=> $dataNota ));
				$resultado = $ps->fetchObject();
				$notaVenda = new NotaVenda( $dataNota, $resultado->dataPgmt, $resultado->comissao, $pontoVenda, $resultado->id, $resultado->paga);

					$this->sql = "SELECT * FROM itemNota WHERE id_notavenda = :id_notavenda";
					$id_notaVenda = $notaVenda->getId();			
					$ps = $this->pdo->prepare( $this->sql );
					$ps->execute( array( "id_notavenda"=> $id_notaVenda ));
					$resultado = $ps->fetchAll();	
					foreach ($resultado as $row ) {
						$precoCapa = $this->precoCapaDAO->comId( $row['id_precocapa'] );
						$itemNota = new ItemNota( $row['qtdEntregue'], $row['qtdVendido'] ,$precoCapa , $row['id']);

						$itensNota[] = $itemNota ; 
					}	
	
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			$notaVenda->setItensNota( $itensNota );

			return $notaVenda ;
		}

		function buscarPorData( $dataNota ){
			$this->sql = "SELECT * FROM notaVenda WHERE  dataNota = :dataNota ";
			$notasVenda = [] ;
			try{

				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute(array("dataNota"=> $dataNota ));
				$resultado = $ps->fetchAll();
				$this->sql = "SELECT * FROM itemNota WHERE id_notaVenda = :id_notaVenda";
				foreach ($resultado as $row) {
					$pontoVenda = $this->pontoVendaDAO->comId( $row['id_pontovenda']);
					$notaVenda = new NotaVenda( $dataNota, $row['dataPgmt'], $row['comissao'], $pontoVenda, $row['id'], $row['paga']);
					$id_notaVenda = $notaVenda->getId();
					$itensNota = [] ;
					$ps = $this->pdo->prepare( $this->sql );
					$ps->execute( array( "id_notaVenda"=> $id_notaVenda ));
					$r = $ps->fetchAll();			
					foreach ($r as $row ) {

						$precoCapa = $this->precoCapaDAO->comId( $row['id_precocapa'] );
						$itemNota = new ItemNota( $row['qtdEntregue'], 0 ,$precoCapa , $row['id']);

						$itensNota[] = $itemNota ; 	
						$notaVenda->setItensNota( $itensNota );
						
					}
					$notasVenda[] = $notaVenda ;
				}
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			return $notasVenda ;
		}


		function buscarPorDataENaoPaga( $dataNota ){
			$this->sql = "SELECT * FROM notaVenda WHERE  dataNota = :dataNota AND paga = 0";
			$notasVenda = [] ;
			try{

				$ps = $this->pdo->prepare( $this->sql );
				$ps->execute(array("dataNota"=> $dataNota ));
				$resultado = $ps->fetchAll();
				$this->sql = "SELECT * FROM itemNota WHERE id_notaVenda = :id_notaVenda";
				foreach ($resultado as $row) {
					$pontoVenda = $this->pontoVendaDAO->comId( $row['id_pontovenda']);
					$notaVenda = new NotaVenda( $dataNota, $row['dataPgmt'], $row['comissao'], $pontoVenda, $row['id'], $row['paga']);
					$id_notaVenda = $notaVenda->getId();
					$itensNota = [] ;
					$ps = $this->pdo->prepare( $this->sql );
					$ps->execute( array( "id_notaVenda"=> $id_notaVenda ));
					$r = $ps->fetchAll();			
					foreach ($r as $row ) {

						$precoCapa = $this->precoCapaDAO->comId( $row['id_precocapa'] );
						$itemNota = new ItemNota( $row['qtdEntregue'], 0 ,$precoCapa , null , $row['id']);

						$itensNota[] = $itemNota ; 	
						$notaVenda->setItensNota( $itensNota );
						
					}
					$notasVenda[] = $notaVenda ;
				}
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

			return $notasVenda ;
		}

		function registrarPagamento( $notaVenda ){
				$this->sql = "UPDATE notaVenda SET paga = :paga WHERE dataNota = :dataNota   AND id_pontoVenda = :id_pontoVenda ";
			$pontoVenda = $notaVenda->getPontoVenda();
			
			try{
				$ps = $this->pdo->prepare($this->sql);
				$ps->execute( array( 
									 "paga"=>$notaVenda->getPaga(),
									 "dataNota"=>$notaVenda->getDataNota(),
									 "id_pontoVenda"=>$pontoVenda->getId()
									));
			}catch( Exception $e ){
				throw new DAOException( $e );
			}

		}

		function registrarVenda( $notaVenda ){
			
			try{

				$itensNota = $notaVenda->getItensNota();
				$comissao = $this->calcularComissao( $itensNota );
				
				$this->sql = "UPDATE itemNota SET qtdVendido = :qtdVendido WHERE id = :id";
				foreach ($itensNota as $itemNota ) {
					$ps = $this->pdo->prepare($this->sql);
					$ps->execute( array( 
										 "qtdVendido"=>$itemNota->getQtdVendido(),
										 "id"=>$itemNota->getId()
										));
				}

				$this->sql = "UPDATE notaVenda SET comissao = :comissao WHERE id = :id";

				$ps = $this->pdo->prepare( $this->sql );

				$ps->execute( array( "comissao"=> $comissao , "id"=> $notaVenda->getId()));

			}catch( Exception $e ){
				throw new DAOException( $e );
			}

		}

		private function calcularComissao( $itensNota ){
			$comissao = 0 ;
			$venda = 0 ;
			foreach ($itensNota as $itemNota ) {
				$qtdVendido =  $itemNota->getQtdVendido();
				$precoCapa = $itemNota->getPrecoCapa();
				$venda =  $venda + ( $qtdVendido * $precoCapa->getPreco() );
			}

			$comissao = $venda * 0.15 ;

			return $comissao ;
		}

	}






?>