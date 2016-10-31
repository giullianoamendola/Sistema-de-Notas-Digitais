<?php
	require_once('PessoaFisica.php');
	require_once('Bairro.php');

	class Roteiro{
		private PessoaFisica $entregador;
		private Bairro $bairros[];
		

		function __construct( PessoaFisica $entregador = null, Bairro $bairros = null){
			$this->entregador = $entregador;
			$this->bairros = $bairros;
		}

		function setEntregador( PessoaFisica $entregador ){
			$this->entregador = $entregador;
		}
		function getEntregador(){
			return $this->entregador;
		}

		function setBairros( Bairro bairros[] ){
			$this->bairros = $bairros; 
		}

		function getBairros(){
			return $this->bairros[];
		}


	}



?>