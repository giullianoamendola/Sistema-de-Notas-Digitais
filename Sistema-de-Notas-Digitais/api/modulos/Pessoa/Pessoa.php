<?php

	class Pessoa{

	private $nome = '';
	private $email = '';
	private $telefone = 0;
	private $id = 0;

	function __construct( $nome = '', $email = '', $telefone = 0, $id = 0 ){

			$this->nome = $nome ;
			$this->email = $email;
			$this->telefone = $telefone;
			$this->id = $id ;
	}

	function setNome( $nome ){
		$this->nome = $nome;
	}
	function getNome(){
		return $this->nome;
	}

	function setEmail( $email ){
		$this->email = $email;
	}
	function getEmail(){
		return $this->email;
	}

	function setTelefone( $telefone ){
		$this->telefone = $telefone;
	}
	function getTelefone(){
		return $this->telefone;
	}
	function setId( $id ){
		$this->id = $id ;
	}		
	function getId(){
		return $this->id;
	}
}


?>