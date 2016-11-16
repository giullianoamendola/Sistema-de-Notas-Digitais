<?php

	class NotaVenda{

		private $dataNota;
		private $dataPgmt;
		private $pontoVenda;
		private $comissao;
		private $id;
		private $itensNota = [] ;
		private $paga;


		function __construct(
			$dataNota = NULL,
			$dataPgmt = NULL,
			$comissao = 0.0,
			PontoVenda $pontoVenda = NULL,
			$id = 0,
			$itensNota = []	,
			$paga = 0 	
			){
			$this->dataNota = $dataNota;
			$this->dataPgmt = $dataPgmt;
			$this->comissao = $comissao;
			$this->pontoVenda = $pontoVenda;
			$this->id = $id ;
			$this->itensNota = $itensNota;
			$this->paga = $paga ;

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

		function setItensNota( $itensNota ){
			$this->itensNota = $itensNota ;
		}		
		function getItensNota(){
			return $this->itensNota;
		}	

		function setId( $id ){
			$this->id = $id ;
		}		
		function getId(){
			return $this->id;
		}

		function setPaga( $paga ){
			$this->paga = $paga ;
		}		
		function getPaga(){
			return $this->paga;
		}	
	}




?>