<?php


	class Jornal{

		private $nome = '';
		private $id ;

		function __construct( $nome = '', $id = 0){
			$this->nome = $nome;
			$this->id = $id;
		}
		function setNome( $nome ){
			$this->nome = $nome;
		}
		function getNome(){
			return $this->nome;
		}

		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}


	}



?>