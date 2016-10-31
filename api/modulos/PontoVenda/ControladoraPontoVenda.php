<?php

	

	class ControladoraPontoVenda{

		private $pontoVendaDAO ;
		private $geradoraResposta;

		function __construct( PDO $pdo ,GeradoraResposta $geradoraResposta ){
			$this->pdo = $pdo ;
			$cidadeDAO = new CidadeDAO( $pdo);
	 		$bairroDAO = new BairroDAO( $cidadeDAO , $pdo);
	 		$enderecoDAO = new EnderecoDAO( $pdo,$bairroDAO);
	 		$pessoaDAO = new PessoaDAO( $pdo );
			$jornaleiroDAO = new JornaleiroDAO( $pdo, $pessoaDAO);
			$this->pontoVendaDAO = new PontoVendaDAO( $pdo , $jornaleiroDAO, $enderecoDAO );
			$this->geradoraResposta = $geradoraResposta ;
		}
		
		function listarPontoVenda(){
			
			try{
				$pontosVenda = $this->pontoVendaDAO->listar();

				$msg ='<select class ="select col-md-2" id = "pontovenda">';

				foreach( $pontosVenda as $ponto){

					$msg .= '<option value ="'.$ponto->getId().'">'.$ponto->getNome().'</option>';
				}

				$msg .= '</select>';

				return $msg;
			}catch( DAOException $e ){

			}
		}

		function comId( $params ){
			try{
				$pontoVenda =  $this->pontoVendaDAO->comId( $params->id );
				$this->geradoraRespostaResposta->ok( $pontoVenda , GeradoraResposta::TIPO_TEXTO);
			}catch( DAOException $e ){
				
			}
		}

		

	}








?>