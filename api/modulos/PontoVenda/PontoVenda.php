<?php


	class PontoVenda{

		private $nome ='';
		private $jornaleiro = null ;
		private $endereco = null;
		private $id = 0;

		function __construct( $nome = '', Jornaleiro $jornaleiro = null,  Endereco $endereco = null, $id = 0 ){
			$this->nome = $nome ;
			$this->jornaleiro = $jornaleiro ;
			$this->endereco = $endereco ;
			$this->id = $id;
		}

		function setNome( $nome ){
			$this->nome = $nome;
		}
		function getNome(){
			return $this->nome;
		}

		function setEndereco( Endereco $endereco ){
			$this->endereco = $endereco ;
		}
		function getEndereco(){
			return $this->endereco;
		}

		function setJornaleiro( Jornaleiro $jornaleiro ){
			$this->jornaleiro = $jornaleiro ;
		}
		function getJornaleiro(){
			return $this->jornaleiro;
		}
		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}
	}







?>