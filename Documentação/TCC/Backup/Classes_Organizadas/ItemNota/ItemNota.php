<?php
	require_once('NotaVenda.php');
	require_once('Jornal.php');

	class ItemNota {

		private $qtdEntregue;
		private $qtdVendido;
		private $notaVenda;
		private $jornal;
		private $id;

		function __construct( $qtdEntregue = 0 , $qtdVendido = 0 , NotaVenda $notaVenda = null , Jornal $jornal = null , $id = 0 ){
			
			$this->qtdEntregue = $qtdEntregue ;
			$this->qtdVendido = $qtdVendido ;
			$this->notaVenda = $notaVenda ;
			$this->jornal = $jornal ;
			$this->id = $id ;
		
		}

		function setQtdEntregue( $qtdEntregue ){
			$this->qtdEntregue = $qtdEntregue;
		}
		function  getQtdEntregue(){
			return $this->qtdEntregue ; 
		}

		function setQtdVendido( $qtdVendido ){
			$this->qtdVendido = $qtdVendido;
		}
		function  getQtdVendido(){
			return $this->qtdVendido ; 
		}

		function setNotaVenda( $notaVenda ){
			$this->notaVenda = $notaVenda ;
		}
		function getNotaVenda(){
			return $this->notaVenda ;
		}

		function setJornal( $jornal ){
			$this->jornal = $jornal;
		}
		function getJornal(){
			return $this->jornal ;
		}

		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}
	}





?>