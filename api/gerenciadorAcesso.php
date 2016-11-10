<?php

	session_start();

	$_SESSION['usuario'] = 'adm';

	if( isset( $_SESSION['usuario'])){
		$u = $_SESSION['usuario'];
		echo $u ;
	}


	session_destroy();




?>