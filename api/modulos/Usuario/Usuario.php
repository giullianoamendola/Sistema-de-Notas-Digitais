<?php

	class Usuario{

		private $login ;
		private $senha ;

		function __construct( $login = '', $senha = '' ){
			$this->login = $login ;
			$this->senha = $senha ;
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
	}










?>