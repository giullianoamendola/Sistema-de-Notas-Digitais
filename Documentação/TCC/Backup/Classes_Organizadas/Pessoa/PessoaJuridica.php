<?php
	require_once('Pessoa.php');

	class PessoaJuridica extends Pessoa{

		private $nomeContato = '';
		private $cnpj = 0;

		function __construct( $nomeContato ='', $cnpj = 0){
			$this->nomeContato = $nomeContato;
			$this->cnpj = $cnpj;
		}

		function setNomeContato( $nomeContato ){
			$this->nomeContato = $nomeContato;
		}
		function getNomeContato(){
			return $this->nomeContato;
		}


		function setCnpj( $cnpj ){
			$this->cnpj = $cnpj;
		}
		function getCnpj(){
			return $this->cnpj;
		}
	}


?>