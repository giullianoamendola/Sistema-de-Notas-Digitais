<?php


	class Roteiro{
		private $entregador;
		private $bairros[];
		

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