<?php
	require_once('Jornal.php');

	class PrecoCapa{
		
		private $data;
		private $preco = 0.0;
		private $jornal ;
		private $id;

		function __construct( $preco = 0.0, $data = null, Jornal $jornal, $id = 0){
			$this->data = $data;
			$this->preco = $preco;
			$this->jornal = $jornal;
			$this->id = $id;
		}

		function setData( $data){
			$this->data = $data;
		}
		function getData(){
			return $this->data;
		}

		function setPreco( $preco ){
			$this->preco = $preco;
		}
		function getPreco(){
			return $this->preco;
		}

		function setJornal( $jornal ){
			$this->jornal = $jornal ;
		}
		function getJornal(){
			return $this->jornal;
		}
	}




?>