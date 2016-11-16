<?php
	require_once('Pessoa.php');

	class PessoaFisica extends Pessoa{

		private $rg = 0;
		private $cpf = 0;

		function __construct(  $rg = 0, $cpf = 0 ){
			$this->rg = $rg ;
			$this->cpf = $cpf;
		}

		function setRg( $rg ){
			$this->rg = $rg;
		}
		function getRg(){
			return $this->rg;
		}


		function setCpf( $cpf ){
			$this->cpf = $cpf;
		}
		function getCpf(){
			return $this->cpf;
		}
	}


?>