<?php
	
	require_once('PontoVenda.php');

	class NotaVenda{

		private $dataNota;
		private $dataPgmt;
		private $pontoVenda;
		private $comissao;
		private $id;


		function __construct( $dataNota = null, $dataPgmt = null, $comissao = 0.0, PontoVenda $pontoVenda, $id = 0 ){
			$this->dataNota = $dataNota;
			$this->dataPgmt = $dataPgmt;
			$this->comissao = $comissao;
			$this->pontoVenda = $pontoVenda;
			$this->id = $id ;

		}

		function setDataNota( $dataNota ){
			$this->dataNota = $dataNota;
		}
		function getDataNota(){
			return $this->dataNota;
		}

		function setDataPgmt( $dataPgmt ){
			$this->dataPgmt = $dataPgmt;
		}
		function getDataPgmt(){
			return $this->dataPgmt;
		}	

		function setPontoVenda( PontoVenda $pontoVenda){
			$this->pontoVenda = $pontoVenda;
		}
		function getPontoVenda(){
			return $this->pontoVenda ;
		}

		function setComissao( $comissao){
			$this->comissao = $comissao;
		}
		function getComissao(){
			return $this->comissao;
		}

		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}		
	}




?>