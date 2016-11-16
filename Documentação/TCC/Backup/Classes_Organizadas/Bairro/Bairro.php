<?php
	
	require_once('Cidade.php');

	class Bairro{

		private $nome = '' ;
		private $cidade = null ;
		private $id = 0;

		function __construct( $nome = '', Cidade $cidade = null, $id = 0 ){
			$this->nome = $nome ;
			$this->cidade = $cidade ;
			$this->id = $id ;
		}

		function setNome( $nome ){
			$this->nome = $nome;
		}
		function getNome(){
			return $this->nome;
		}

		function setCidade( Cidade $cidade){
			$this->cidade = $cidade ;
		}
		function getCidade(){
			return $this->cidade;
		}
		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}

	}






?>