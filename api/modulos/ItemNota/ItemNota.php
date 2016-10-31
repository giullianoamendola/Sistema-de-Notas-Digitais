<?php


	class ItemNota {

		private $qtdEntregue;
		private $qtdVendido;
		private $notaVenda;
		private $precoCapa;
		private $id;

		function __construct( $qtdEntregue = 0 , $qtdVendido = 0 , PrecoCapa $precoCapa = null ,NotaVenda $notaVenda = null , $id = 0 ){
			
			$this->qtdEntregue = $qtdEntregue ;
			$this->qtdVendido = $qtdVendido ;
			$this->notaVenda = $notaVenda ;
			$this->precoCapa = $precoCapa;
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

		function setPrecoCapa( $precoCapa ){
			$this->precoCapa = $precoCapa;
		}
		function getPrecoCapa(){
			return $this->precoCapa ;
		}

		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}

		
	}





?>