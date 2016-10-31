<?php
	require_once( "DAOException.php");

	 interface DAO{

		function adicionar( &$obj);
		function remover( $obj );
		function alterar( $obj);
		function comId( $id);
		function listar();

	}






?>