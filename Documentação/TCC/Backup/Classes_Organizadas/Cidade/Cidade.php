<?php

	class Cidade{

		private $nome = '';
		private $uf = '';
		private $id = 0;

		function __construct( $nome = '', $uf = '', $id = 0){
			$this->nome = $nome ;
			$this->uf = $uf ;
			$this->id = $id ;
		}

		function setNome( $nome ){
			$this->nome = $nome;
		}
		function getNome(){
			return $this->nome;
		}

		function setUf( $uf ){
			$this->uf = $uf ;
		}		
		function getUf(){
			return $this->uf;
		}
		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}
	}


?>