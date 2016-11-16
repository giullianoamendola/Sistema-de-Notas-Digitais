<?php
	
	require_once('Bairro.php');

	class Endereco{

		private $logradouro = '';
		private $numero = 0;
		private $complemento = '';
		private  $bairro ;
		private $id;

		function __construct( $logradouro = '', $numero = 0, $complemento = '', Bairro $bairro = null, $id = 0){
			$this->logradouro = $logradouro;
			$this->numero = $numero;
			$this->complemento = $complemento;
			$this->bairro = $bairro;
			$this->id = $id;
		}

		function setLogradouro( $logradouro ){
			$this->logradouro = $logradouro;
		}
		function getLogradouro(){
			return $this->logradouro ;
		}

		function setNumero( $numero ){
			$this->numero = $numero;
		}
		function getNumero(){
			return $this->numero;
		}
		
		function setComplemento( $complemento ){
			$this->complemento = $complemento;
		}
		function getComplemento(){
			return $this->complemento;
		}
		function setBairro( Bairro $bairro){
			$this->bairro = $bairro ;
		}
		function getBairro(){
			return $this->bairro;
		}
		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}


	}





?>