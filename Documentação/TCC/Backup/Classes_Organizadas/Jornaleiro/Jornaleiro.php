<?php

	require_once('Pessoa.php');

	class Jornaleiro {

		private $tipoPagamento;
		private $pessoa;
		private $id;

		function __construct( $tipoPagamento = 0 , Pessoa $pessoa = null,  $id = 0){
			$this->tipoPagamento = $tipoPagamento; 
			$this->pessoa = $pessoa;
			$this->id = $id ;
		}

		function setTipoPagamento( $tipoPagamento ){
			$this->tipoPagamento = $tipoPagamento;
		}
		function getTipoPagamento(){
			return $this->tipoPagamento ;
		}
		function setPessoa( Pessoa $pessoa){
			$this->pessoa = $pessoa;
		}
		function getPessoa(){
			return $this->pessoa;
		}
		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}

	}







?>