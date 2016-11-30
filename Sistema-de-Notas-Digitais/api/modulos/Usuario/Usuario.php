<?php

	class Usuario{

		private $nome ;
		private $login ;
		private $senha ;
		private $perfil ;
		private $id ;
		
		function __construct( $login = '', $senha = '', $nome = '' , $perfil = null  , $id = 0 ){
			$this->login = $login ;
			$this->senha = $senha ;
			$this->nome = $nome ;
			$this->perfil = $perfil ;
			$this->id = $id ;
		}

		function setLogin( $login ){
			$this->login = $login ;
		}
		function getLogin(){
			return $this->login ;
		}

		function setSenha( $senha ){
			$this->senha = $senha ;
		}
		function getSenha(){
			return $this->senha ;
		}

		function setNome( $nome ){
			$this->nome = $nome ;
		}
		function getNome(){
			return $this->nome ;
		}

		function setPerfil( $perfil ){
			$this->perfil = $perfil ;
		}
		function getPerfil(){
			return $this->perfil ;
		}

		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}
	}










?>