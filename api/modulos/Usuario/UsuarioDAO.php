<?php

	class UsuarioDAO implements DAO{

		private $pdo ;
		private $sql ;
		//private $pessoaDAO ;

		function __construct( PDO $pdo ){
			$this->pdo = $pdo ;
			//$this->pessoaDAO = $pessoaDAO ;
		}

		function adicionar( &$usuario ){

		}

		function alterar( $usuario ){

		}

		function remover( $usuario ){

		}

		function comId( $id ){

		}

		function listar(){

		}

		function logar( $usuario ){

		}

		function logout( $usuario ){
			
		}


	}



?>