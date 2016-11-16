<?php

	require_once('NotaVendaDAO.php');

	class ControladoraNotaVenda{

		private $notaVendaDAO; 
		private $notaVenda;

		function __construct(){

			$pdo = new PDO('mysql:host=localhost;dbname=a_outra', "root", '');
			$cidadeDAO = new CidadeDAO( $pdo);
	 		$bairroDAO = new BairroDAO( $cidadeDAO , $pdo);
	 		$enderecoDAO = new EnderecoDAO( $pdo,$bairroDAO);
	 		$pessoaDAO = new PessoaDAO( $pdo );
			$jornaleiroDAO = new JornaleiroDAO( $pdo, $pessoaDAO);
			$pontoVendaDAO = new PontoVendaDAO( $pdo , $jornaleiroDAO, $enderecoDAO );
			$this->notaVendaDAO = new NotaVendaDAO( $pdo , $pontoVendaDAO) ;
		
		}

		function adicionar( $notaVenda ){
			
			if( $this->validacao_NotaVenda()){
				$pontoVenda = $pontoVendaDAO->comId( $nota['id_PontoVenda']);
				$notaVenda = new NotaVenda( $notaVenda['dataNota'], $notaVenda['dataPgmt'], $notaVenda['comissao'], $pontoVenda, $notaVenda['id']);
				$notaVendaDAO->adicionar( $notaVenda );
			}
			else{
				//erro 
			}
		}


		
		private function validacao_NotaVenda(){

			return true;
		}





?>